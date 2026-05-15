<?php

namespace App\Http\Controllers\admin;

use App\Models\Booking;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // الـ Status Transitions المسموح بيها
    private const ALLOWED_TRANSITIONS = [
        'pending'   => ['confirmed', 'cancelled'],
        'confirmed' => ['completed', 'cancelled'],
        'completed' => [],   // نهائي - مينفعش يتغير
        'cancelled' => [],   // نهائي - مينفعش يتغير
    ];

    // ─────────────────────────────────────────────
    //  Index
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'doctor.user', 'doctor.major'])
            ->latest('appointment_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name',  'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if (auth()->user()->hasRole('doctor')) {
            $query->whereHas('doctor', fn($q) => $q->where('user_id', auth()->id()));
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();
        $doctors  = Doctor::with('user')->get();

        return view('admin.bookings.index', compact('bookings', 'doctors'));
    }

    // ─────────────────────────────────────────────
    //  Edit
    // ─────────────────────────────────────────────
    public function edit($id)
    {
        $booking = Booking::with(['patient', 'doctor.user'])->findOrFail($id);

        // ✅ Authorization: Doctor يشوف بس bookings بتاعته
        if (auth()->user()->hasRole('doctor')) {
            abort_if($booking->doctor->user_id !== auth()->id(), 403);
        }

        $doctors = Doctor::with('user')->get();

        return view('admin.bookings.edit', compact('booking', 'doctors'));
    }

    // ─────────────────────────────────────────────
    //  Update - مع Transaction + Validation منطقي
    // ─────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        // ✅ Lock the row لمنع Race Condition
        $booking = Booking::lockForUpdate()->findOrFail($id);

        // ✅ Authorization
        if (auth()->user()->hasRole('doctor')) {
            abort_if($booking->doctor->user_id !== auth()->id(), 403);
        }

        // ✅ Basic validation
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $newStatus     = $request->status;
        $currentStatus = $booking->status;

        // ✅ App-level: منع تغيير Status بشكل غير منطقي
        if ($newStatus !== $currentStatus) {
            $allowed = self::ALLOWED_TRANSITIONS[$currentStatus] ?? [];

            if (!in_array($newStatus, $allowed)) {
                return back()->withErrors([
                    'status' => "Cannot change the status from [{$currentStatus}] to [{$newStatus}]."
                ]);
            }
        }

        // ✅ Transaction: كل العمليات تنجح أو كلها تفشل
        DB::transaction(function () use ($booking, $newStatus) {
            $updateData = ['status' => $newStatus];

            if ($newStatus === 'completed') {
                $updateData['payment_status'] = 'paid';
            }

            $booking->update($updateData);
        });

        $route = auth()->user()->hasRole('doctor')
            ? 'admin.doctor.myBookings'
            : 'admin.booking.index';

        return redirect()->route($route)
            ->with('success', 'Appointment status updated successfully.');
    }

    // ─────────────────────────────────────────────
    //  Destroy - مع Authorization
    // ─────────────────────────────────────────────
    public function destroy(Booking $booking)
    {
        // ✅ Doctor ميحذفش غير bookings بتاعته
        if (auth()->user()->hasRole('doctor')) {
            abort_if($booking->doctor->user_id !== auth()->id(), 403);
        }

        $booking->delete();

        return redirect()->route('admin.booking.index')
            ->with('success', 'Appointment archived successfully.');
    }

    // ─────────────────────────────────────────────
    //  Trashed
    // ─────────────────────────────────────────────
    public function trashed(Request $request)
    {
        $query = Booking::onlyTrashed()
            ->with(['patient', 'doctor.user', 'doctor.major'])
            ->latest('appointment_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name',  'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $bookings = $query->paginate(10)->withQueryString();
        $doctors  = Doctor::with('user')->get();

        return view('admin.bookings.trashed', compact('bookings', 'doctors'));
    }

    // ─────────────────────────────────────────────
    //  Restore - مع Authorization
    // ─────────────────────────────────────────────
    public function restore($id)
    {
        $booking = Booking::withTrashed()->findOrFail($id);

        // ✅ Doctor ميعملش restore لـ bookings مش بتاعته
        if (auth()->user()->hasRole('doctor')) {
            abort_if($booking->doctor->user_id !== auth()->id(), 403);
        }

        $booking->restore();

        return redirect()->route('admin.booking.trashed')
            ->with('success',  'Appointment restored successfully.');
    }
}