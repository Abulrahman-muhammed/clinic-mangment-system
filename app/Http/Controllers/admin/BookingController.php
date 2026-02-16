<?php

namespace App\Http\Controllers\admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
class BookingController extends Controller
{
public function index(Request $request)
{
    // Start query with doctor relationship to avoid N+1
    $query = Booking::with('doctor');

    // Filter by Search (Name, Email, or Phone)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    // Filter by Specific Doctor
    if ($request->filled('doctor_id')) {
        $query->where('doctor_id', $request->doctor_id);
    }

    // Filter by Date
    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    $bookings = $query->latest('date')->paginate(10)->withQueryString();
    
    // Get list of doctors for the filter dropdown
    $doctors = \App\Models\Doctor::all(); 

    return view('admin.bookings.index', compact('bookings', 'doctors'));
}

public function updateStatus(Request $request, $id) {
    $booking = Booking::findOrFail($id);
    $booking->status = $request->status;
    $booking->save();
    
    return response()->json(['success' => true, 'status' => $booking->status]);
}

    public function destroy(Booking $booking) {

        $booking->delete();
        return redirect()->route('admin.booking.index')->with('success', 'Booking deleted successfully');
    }
    public function edit($id) {
        $booking = Booking::findOrFail($id);
        $doctors = Doctor::all();
        return view('admin.bookings.edit', compact('booking', 'doctors'));
    }   
    public function update(Request $request, $id) {
        $booking = Booking::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        $booking->update([
            'status' => $request->status,
        ]);
        // if user has role doctor 
        if(auth()->user()->hasRole('doctor')) {
            return redirect()->route('admin.doctor.myBookings')->with('success', 'Booking status updated successfully');
        }
        // if user has role admin 
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist')) {
            return redirect()->route('admin.booking.index')->with('success', 'Booking status updated successfully');
        }
    }
}
