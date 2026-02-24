<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Major;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index() {

        $majors = Major::orderBy('id', 'desc')
        ->limit(4)
        ->get();

        $doctors = Doctor::with('major')
        ->orderBy('id', 'desc')
        ->limit(4)
        ->get();

        $services = Service::orderBy('id', 'desc')
        ->limit(4)
        ->get();

        return view('front.pages.home', compact('majors', 'doctors', 'services'));
    }

    // about us page
    public function about() {
        return view('front.pages.about');
    }

    public function appointments(Request $request)
{
    $query = Booking::where('user_id', Auth::id())
        ->with(['doctor.user', 'doctor.major'])
        ->latest('appointment_date');

    // Filter by status tab
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    $bookings = $query->paginate(8)->withQueryString();

    return view('front.booking.my-appoiments', compact('bookings'));
}

// ─────────────────────────────────────────────
//  Cancel appointment
// ─────────────────────────────────────────────
public function cancel(Booking $booking)
{
    abort_unless($booking->user_id === Auth::id(), 403);
    abort_unless(in_array($booking->status, ['pending', 'confirmed']), 403);

    $booking->update([
        'status'         => 'cancelled',
        'payment_status' => $booking->payment_status === 'paid' ? 'refunded' : $booking->payment_status,
    ]);

    return back()->with('success', 'Appointment cancelled successfully.');
}

}
