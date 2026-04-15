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
 
            // 📅 Stats
            'today_count' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->count(),
 
            'upcoming_count' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', '>', today())
                ->count(),
 
            'bookings_count' => Booking::where('doctor_id', $doctor->id)->count(),
 
            // 🗓️ Schedules count
            'schedules_count' => DoctorSchedule::where('doctor_id', $doctor->id)->count(),
 
            // 🧾 Invoices count
            'invoices_count' => Invoice::where('doctor_id', $doctor->id)->count(),
 
            // 👤 Patients (Booking + Invoice) — unique
            'patients_count' => DB::table(function ($query) use ($doctor) {
                $query->select('patient_id')
                    ->from('bookings')
                    ->where('doctor_id', $doctor->id)
                    ->union(
                        DB::table('invoices')
                            ->select('patient_id')
                            ->where('doctor_id', $doctor->id)
                    );
            }, 'patients')->distinct()->count('patient_id'),
 
            // 💰 Bookings Earnings (من حقل amount في bookings)
            'bookings_earnings_today' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->where('status', 'completed')
                ->sum('amount'),
 
            'bookings_earnings_month' => Booking::where('doctor_id', $doctor->id)
                ->whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)
                ->where('status', 'completed')
                ->sum('amount'),
 
            // 🧾 Invoices Earnings (من حقل amount في invoices)
            'invoices_earnings_today' => Invoice::where('doctor_id', $doctor->id)
                ->whereDate('invoice_date', today())
                ->sum('amount'),
 
            'invoices_earnings_month' => Invoice::where('doctor_id', $doctor->id)
                ->whereMonth('invoice_date', now()->month)
                ->whereYear('invoice_date', now()->year)
                ->sum('amount'),
 
            // 📋 Today's bookings
            'today_bookings' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->with('patient')
                ->orderBy('appointment_time')
                ->get(),
 
            // 📋 Recent bookings
            'recent_bookings' => Booking::where('doctor_id', $doctor->id)
                ->with(['patient', 'user'])
                ->latest()
                ->take(5)
                ->get(),
 
            // 👤 Recent patients — من Booking مع patient
        'recent_patients' => collect(
            Booking::where('doctor_id', $doctor->id)
                ->select('patient_id', 'appointment_date as date')
                ->get()
        )->merge(
            Invoice::where('doctor_id', $doctor->id)
                ->select('patient_id', 'invoice_date as date')
                ->get()
        )
        ->groupBy('patient_id')
        ->map(function ($items) {
            return $items->sortByDesc('date')->first(); // آخر زيارة
        })
        ->sortByDesc('date')
        ->take(5)
        ->map(function ($item) {
            $item->patient = \App\Models\Patient::find($item->patient_id);
            return $item;
        }),
 
            // 🗓️ Schedule
            'schedules' => DoctorSchedule::where('doctor_id', $doctor->id)
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