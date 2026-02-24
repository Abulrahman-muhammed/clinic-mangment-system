<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class BookingController extends Controller
{
    // ─────────────────────────────────────────────
    //  Show booking form
    // ─────────────────────────────────────────────
    public function create(Doctor $doctor)
    {
        $schedules = $doctor->schedules;
        return view('front.booking.create', compact('doctor', 'schedules'));
    }

    // ─────────────────────────────────────────────
    //  Store booking
    // ─────────────────────────────────────────────
public function store(Request $request, Doctor $doctor)
{
    // 1. Pre-fetch existing patient to handle the 'unique' validation rule properly
    $existingPatient = Patient::where('email', $request->patient_email)->first();

    $validated = $request->validate([
        'appointment_date'   => ['required', 'date', 'after_or_equal:today'],
        'appointment_time'   => ['required', 'date_format:H:i'],
        'patient_name'       => ['required', 'string', 'max:120'],
        'patient_phone'      => ['required', 'string', 'max:20'],
        'patient_email'      => [
            'required', 
            'email', 
            'max:120',
            // Allows the current email owner to proceed, but blocks others
            Rule::unique('patients', 'email')->ignore($existingPatient?->id),
        ],
        'patient_dob'        => ['nullable', 'date', 'before:today'],
        'patient_gender'     => ['nullable', 'in:male,female'],
        'patient_blood_type' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
        'patient_notes'      => ['nullable', 'string', 'max:2000'],
        'payment_method'     => ['required', 'in:card,at_clinic'],
    ], [
        // English error messages
        'patient_email.unique'      => 'This email is already associated with another patient profile.',
        'appointment_time.required' => 'Please select a preferred time for your appointment.',
    ]);

    // 2. Check slot availability (Excluding cancelled and completed appointments)
    $taken = Booking::where('doctor_id', $doctor->id)
        ->where('appointment_date', $validated['appointment_date'])
        ->where('appointment_time', $validated['appointment_time'])
        ->whereNotIn('status', ['cancelled', 'completed'])
        ->exists();

    if ($taken) {
        return back()
            ->withInput()
            ->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another.']);
    }

    // 3. Update or Create Patient 
    // This will update the info (including phone) if the email exists, or create a new row if not
    $patient = Patient::updateOrCreate(
        ['email' => $validated['patient_email']],
        [
            'name'            => $validated['patient_name'],
            'phone'           => $validated['patient_phone'],
            'date_of_birth'   => $validated['patient_dob'] ?? null,
            'gender'          => $validated['patient_gender'] ?? null,
            'blood_type'      => $validated['patient_blood_type'] ?? null,
            'medical_history' => $validated['patient_notes'] ?? null,
            // Preserves existing password or generates a random one for new patients
            'password'        => $existingPatient ? $existingPatient->password : bcrypt(Str::random(32)),
        ]
    );

    // 4. Create Booking
    $booking = Booking::create([
        'user_id'          => Auth::id(),
        'doctor_id'        => $doctor->id,
        'patient_id'       => $patient->id,
        'appointment_date' => $validated['appointment_date'],
        'appointment_time' => $validated['appointment_time'],
        'payment_method'   => $validated['payment_method'],
        'amount'           => $doctor->consultation_fee,
        'payment_status'   => 'pending',
        'status'           => 'pending',
        'notes'            => $validated['patient_notes'] ?? null,
    ]);

    // 5. Redirect based on payment method
    if ($validated['payment_method'] === 'card') {
        return redirect()->route('front.booking.fake-checkout', $booking);
    }

    return redirect()
        ->route('front.booking.success', $booking)
        ->with('success', 'Booking received! Please pay at the clinic. Your appointment is pending confirmation.');
}

    // ─────────────────────────────────────────────
    //  Fake Stripe checkout page
    // ─────────────────────────────────────────────
    public function fakeCheckout(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->payment_status === 'pending', 403);

        return view('front.booking.fake-checkout', compact('booking'));
    }

    // ─────────────────────────────────────────────
    //  Simulate payment result
    // ─────────────────────────────────────────────
    public function simulatePayment(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->payment_status === 'pending', 403);

        $request->validate(['result' => 'required|in:success,fail']);

        if ($request->result === 'success') {
            $booking->update([
                'payment_status' => 'paid',
                'status'         => 'confirmed',
                'card_last4'     => $request->input('card_last4', '4242'),
                'card_name'      => $request->input('card_name',  'Test User'),
                'card_expiry'    => $request->input('card_expiry', '12/26'),
            ]);

            // ── Create invoice automatically for card payments ──
            Invoice::create([
                'patient_id'   => $booking->patient_id,
                'doctor_id'    => $booking->doctor_id,
                'user_id'      => Auth::id(),
                'booking_id'   => $booking->id,
                'amount'       => $booking->amount,
                'status'       => 'paid',
                'invoice_date' => now()->toDateString(),
                'notes'        => 'Online payment via card ending in ' . $request->input('card_last4', '4242'),
            ]);

            return redirect()
                ->route('front.booking.success', $booking)
                ->with('success', 'Payment successful! Your appointment is confirmed and invoice has been generated.');
        }

        // Payment failed
        $booking->update([
            'payment_status' => 'failed',
            'status'         => 'cancelled',
        ]);

        return redirect()
            ->route('front.booking.failed', $booking)
            ->with('error', 'Payment failed. Your booking has been cancelled. Please try again.');
    }

    // ─────────────────────────────────────────────
    //  Result pages
    // ─────────────────────────────────────────────
    public function success(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        return view('front.booking.success', compact('booking'));
    }

    public function failed(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        return view('front.booking.failed', compact('booking'));
    }

    // ─────────────────────────────────────────────
    //  My appointments list
    // ─────────────────────────────────────────────
    public function appointments(Request $request)
    {
        $query = Booking::where('user_id', Auth::id())
            ->with(['doctor.user', 'doctor.major'])
            ->latest('appointment_date');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(8)->withQueryString();

        return view('front.booking.appointments', compact('bookings'));
    }

    // ─────────────────────────────────────────────
    //  Cancel (at_clinic only)
    // ─────────────────────────────────────────────
    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless(in_array($booking->status, ['pending', 'confirmed']), 403);
        abort_unless($booking->payment_method === 'at_clinic', 403);

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    // ─────────────────────────────────────────────
    //  Soft delete (archive)
    // ─────────────────────────────────────────────
    public function destroy(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        
        // Server-side guard: only allow deleting cancelled or completed
        abort_unless(in_array($booking->status, ['cancelled', 'completed']), 403);
        
        $booking->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }
}