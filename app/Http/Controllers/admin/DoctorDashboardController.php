<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice, Patient, Booking, Doctor, DoctorSchedule};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Visit;
class DoctorDashboardController extends Controller
{
    // 🔹 Get logged doctor
    private function getDoctor()
    {
        return Doctor::where('user_id', auth()->id())->firstOrFail();
    }

    // ─────────────────────────────────────────────
    // 📊 Dashboard
    // ─────────────────────────────────────────────
    public function dashboard()
    {
        $doctor = $this->getDoctor();

        $data = [

            // 📅 Stats
            'today_count' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->count(),

            'upcoming_count' => Booking::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', '>', today())
                ->count(),

            'bookings_count' => Booking::where('doctor_id', $doctor->id)->count(),

            // 👤 Patients (Booking + Invoice)
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

            // 💰 Earnings
            'earnings_today' => Invoice::where('doctor_id', $doctor->id)
                ->whereDate('invoice_date', today())
                ->sum('amount'),

            'earnings_month' => Invoice::where('doctor_id', $doctor->id)
                ->whereMonth('invoice_date', now()->month)
                ->sum('amount'),

            // ✅ إضافة schedules_count
            'schedules_count' => DoctorSchedule::where('doctor_id', $doctor->id)->count(),

            // ✅ إضافة invoices_count
            'invoices_count' => Invoice::where('doctor_id', $doctor->id)->count(),

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

            // ✅ إضافة recent_patients (من Booking مع patient)
            'recent_patients' => Booking::where('doctor_id', $doctor->id)
                ->with('patient')
                ->latest()
                ->take(5)
                ->get(),

            // 🗓️ Schedule
            'schedules' => DoctorSchedule::where('doctor_id', $doctor->id)
                ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                ->get(),
        ];

        return view('admin.home', compact('data'));
    }

    // ─────────────────────────────────────────────
    // 🧾 My Invoices
    // ─────────────────────────────────────────────
    public function myInvoices(Request $request)
    {
        $doctor = $this->getDoctor();

        $query = Invoice::where('doctor_id', $doctor->id)
            ->with('patient');

        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('invoice_date', $request->date);
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    // ─────────────────────────────────────────────
    // 👤 My Patients (Booking + Invoice)
    // ─────────────────────────────────────────────
    public function myPatients(Request $request)
    {
        $doctor = $this->getDoctor();

        // 🔥 collect patient IDs from both tables
        $bookingPatients = Booking::where('doctor_id', $doctor->id)
            ->pluck('patient_id');

        $invoicePatients = Invoice::where('doctor_id', $doctor->id)
            ->pluck('patient_id');

        $patientIds = $bookingPatients
            ->merge($invoicePatients)
            ->unique();

        $patients = Patient::whereIn('id', $patientIds)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->gender && $request->gender != 'all', function ($query) use ($request) {
                $query->where('gender', $request->gender);
            })
            ->when($request->blood_type && $request->blood_type != 'all', function ($query) use ($request) {
                $query->where('blood_type', $request->blood_type);
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    // ─────────────────────────────────────────────
    // 📅 My Bookings
    // ─────────────────────────────────────────────
    public function myBookings(Request $request)
    {
        $doctor = $this->getDoctor();
 
        $query = Booking::where('doctor_id', $doctor->id)
            ->with(['patient', 'user']);
 
        // 🔍 Search by patient name / email / phone
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }
 
        // 🏷️ Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        // 📅 Filter by appointment date
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }
 
        $bookings = $query->latest()->paginate(10)->withQueryString();
 
        return view('admin.bookings.index', compact('bookings'));
    }
 

    // ─────────────────────────────────────────────
    // 🗓️ My Schedule
    // ─────────────────────────────────────────────
    public function mySchedule(Request $request)
    {
        $doctor = $this->getDoctor();

        $query = DoctorSchedule::where('doctor_id', $doctor->id);

        if ($request->filled('day')) {
            $query->where('day_of_week', $request->day);
        }

        $schedules = $query->latest()->paginate(10)->withQueryString();

        return view('admin.schedules.index', compact('schedules', 'doctor'));
    }

    // myVisits

public function myVisits(Request $request)
{
    $doctor = $this->getDoctor();

    $query = Visit::where('doctor_id', $doctor->id)
        ->with(['patient', 'receptionist']);

    if ($request->filled('search')) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $visits = $query->latest()->paginate(10)->withQueryString();

    $doctors = []; // doctors list not needed for doctor role (filter hides it)

    return view('admin.visits.index', compact('visits', 'doctors'));
}
}