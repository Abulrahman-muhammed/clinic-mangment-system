<?php

namespace App\Http\Controllers\admin;

use App\Models\Booking;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // ─────────────────────────────────────────────
    //  Index
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'doctor.user', 'doctor.major'])
            ->latest('appointment_date');

        // Search by patient name / email / phone
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

        // Doctors see only their own bookings
        if (auth()->user()->hasRole('doctor')) {
            $query->whereHas('doctor', fn($q) => $q->where('user_id', auth()->id()));
        }

        $bookings = $query->paginate(10)->withQueryString();
        $doctors  = Doctor::with('user')->get();

        return view('admin.bookings.index', compact('bookings', 'doctors'));
    }

    // ─────────────────────────────────────────────
    //  Edit
    // ─────────────────────────────────────────────
    public function edit($id)
    {
        $booking = Booking::with(['patient', 'doctor.user'])->findOrFail($id);
        $doctors = Doctor::with('user')->get();

        return view('admin.bookings.edit', compact('booking', 'doctors'));
    }

    // ─────────────────────────────────────────────
    //  Update (status only)
    // ─────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        $route = auth()->user()->hasRole('doctor')
            ? 'admin.doctor.myBookings'
            : 'admin.booking.index';

        return redirect()->route($route)
            ->with('success', 'Booking status updated successfully.');
    }

    // ─────────────────────────────────────────────
    //  Soft delete (archive)
    // ─────────────────────────────────────────────
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.booking.index')
            ->with('success', 'Booking archived successfully.');
    }

    // ─────────────────────────────────────────────
    //  Trashed list
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
    //  Restore
    // ─────────────────────────────────────────────
    public function restore($id)
    {
        Booking::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.booking.trashed')
            ->with('success', 'Booking restored successfully.');
    }
}