<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Major;
use App\Models\Doctor;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString(); // تعريف التاريخ الحالي مرة واحدة لاستخدامه في كل الاستعلامات

        // 1. Admin Dashboard Logic
        if ($user->hasRole('admin')) {
            $majors = Major::count();
            $doctors = Doctor::count();
            $bookings = Booking::count();
            $users = User::count();

            // Statistics
            $pendingBookings = Booking::where('status', 'pending')->count();
            $todayBookings = Booking::whereDate('appointment_date', $today)->count();
            $completedBookings = Booking::where('status', 'completed')->count();

            // Recent Bookings (Optimized with Eager Loading)
            $recentBookings = Booking::with(['doctor.user', 'patient'])
                ->latest()
                ->take(10)
                ->get();

            // Top Doctors (Most Bookings)
            $topDoctors = Doctor::withCount('bookings')
                ->with('user')
                ->orderBy('bookings_count', 'desc')
                ->take(5)
                ->get();

            return view('admin.home', compact(
                'majors', 'doctors', 'bookings', 'users',
                'pendingBookings', 'todayBookings', 'completedBookings',
                'recentBookings', 'topDoctors'
            ));
        }

        // 2. Doctor Dashboard Logic
        if ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', Auth::id())->first();

            if (!$doctor) {
                abort(404, 'Doctor profile not found');
            }

            $data = [
                'bookings_count'  => Booking::where('doctor_id', $doctor->id)->count(),
                
                // Count unique patients who have invoices with this doctor
                'patients_count'  => Invoice::where('doctor_id', $doctor->id)
                    ->distinct('patient_id')
                    ->count('patient_id'),

                'today_bookings'  => Booking::where('doctor_id', $doctor->id)
                    ->whereDate('appointment_date', $today)
                    ->count(),

                'schedules_count' => DoctorSchedule::where('doctor_id', $doctor->id)->count(),
                
                'recent_bookings' => Booking::where('doctor_id', $doctor->id)
                    ->with('patient')
                    ->latest()
                    ->take(5)
                    ->get(),

                'schedules'       => DoctorSchedule::where('doctor_id', $doctor->id)
                    ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                    ->get(),
            ];

            return view('admin.home', compact('data'));
        }

        // 3. Receptionist Dashboard Logic
        if ($user->hasRole('receptionist')) {
            $todayBookings = Booking::whereDate('appointment_date', $today)->count();
            $pendingBookings = Booking::where('status', 'pending')->count();
            $completedToday = Booking::whereDate('appointment_date', $today)
                ->where('status', 'completed')
                ->count();
            $totalPatients = Patient::count();

            $todayAppointments = Booking::whereDate('appointment_date', $today)
                ->with(['doctor.user', 'doctor.major', 'patient'])
                ->orderBy('appointment_time', 'asc') // ترتيب حسب الوقت لسهولة العمل اليومي
                ->take(15)
                ->get();

            return view('admin.home', compact(
                'todayBookings', 'pendingBookings', 'completedToday',
                'totalPatients', 'todayAppointments'
            ));
        }

        return redirect()->route('home');
    }
}