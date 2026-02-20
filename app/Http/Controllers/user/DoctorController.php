<?php

namespace App\Http\Controllers\user;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Major;
class DoctorController extends Controller
{
    public function index() {
    $doctors    = Doctor::with(['user', 'major'])->paginate(12);
    $specialties = Major::all();
        return view('front.doctors.doctor', compact('doctors', 'specialties'));
    }

    public function bookingPage(Doctor $doctor) {
        return view('front.doctors.booking', compact('doctor'));
    }

    public function booking(StoreBookingRequest $request, Doctor $doctor) {

        //dd($doctor);

        Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'doctor_id' => $doctor->id        
        ]);

        return redirect()->back()->with('success', 'Your appointment has been booked successfully');
        
    }

public function show(Doctor $doctor) {
    $doctor->load(['user', 'major', 'schedules']);
    return view('front.doctors.show', compact('doctor'));
}
}
