<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Major;
use App\Models\Doctor;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
class AdminController extends Controller
{
    public function index() {
        $user = Auth::user();
        
        // Admin view data
        if ($user->hasRole('admin')) {
            $majors = Major::count();
            $doctors = Doctor::count();
            $bookings = Booking::count();
            $users = User::count();
            
            // إحصائيات إضافية
            $pendingBookings = Booking::where('status', 'pending')->count();
            $todayBookings = Booking::whereDate('date', today())->count();
            $completedBookings = Booking::where('status', 'completed')->count();
            
            // آخر المواعيد
            $recentBookings = Booking::with(['doctor.user', 'patient'])
                                    ->latest()
                                    ->take(10)
                                    ->get();
            
            // أفضل الدكاترة (الأكثر حجوزات)
            $topDoctors = Doctor::withCount('bookings')
                               ->with('user')
                               ->orderBy('bookings_count', 'desc')
                               ->take(5)
                               ->get();
            
            return view('admin.home', compact(
                'majors', 
                'doctors', 
                'bookings', 
                'users',
                'pendingBookings',
                'todayBookings',
                'completedBookings',
                'recentBookings',
                'topDoctors'
            ));
        }
        
        // Doctor view data
        if ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', Auth::id())->first();
            
            if (!$doctor) {
                abort(404, 'Doctor profile not found');
            }

            $data = [
                'bookings_count'  => Booking::where('doctor_id', $doctor->id)->count(),
                
                'patients_count'  => Invoice::where('doctor_id', $doctor->id)
                                            ->distinct('patient_id')
                                            ->count('patient_id'),
                
                'schedules_count' => DoctorSchedule::where('doctor_id', $doctor->id)->count(),
                
                'invoices_count'  => Invoice::where('doctor_id', $doctor->id)->count(),
                
                'recent_bookings' => Booking::where('doctor_id', $doctor->id)
                                            ->latest()
                                            ->take(5)
                                            ->get(),
                
                'schedules'       => DoctorSchedule::where('doctor_id', $doctor->id)
                                                  ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                                                  ->get(),
                
                'recent_patients' => Invoice::where('doctor_id', $doctor->id)
                                           ->with('patient')
                                           ->select('patient_id', DB::raw('MAX(created_at) as last_visit'))
                                           ->groupBy('patient_id')
                                           ->orderBy('last_visit', 'desc')
                                           ->take(5)
                                           ->get()
            ];
            
            return view('admin.home', compact('data'));
        }
        
        // Receptionist view data
        if ($user->hasRole('receptionist')) {
            $todayBookings = Booking::whereDate('date', today())->count();
            $pendingBookings = Booking::where('status', 'pending')->count();
            $completedToday = Booking::whereDate('date', today())
                                    ->where('status', 'completed')
                                    ->count();
            $totalPatients = Patient::count();
            
            $todayAppointments = Booking::whereDate('date', today())
                                       ->with(['doctor.user', 'doctor.major'])
                                       ->latest()
                                       ->take(10)
                                       ->get();
            
            return view('admin.home', compact(
                'todayBookings', 
                'pendingBookings', 
                'completedToday',
                'totalPatients',
                'todayAppointments'
            ));
        }
        
        return redirect()->route('home');
    }
}