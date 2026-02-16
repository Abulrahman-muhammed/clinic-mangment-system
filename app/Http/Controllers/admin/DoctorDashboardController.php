<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Invoice, Patient, Booking, Doctor, DoctorSchedule};
use Illuminate\Support\Facades\Auth;


class DoctorDashboardController extends Controller
{
    // دالة مساعدة خاصة بالكنترولر لتقليل التكرار
    private function getDoctor()
    {
        return Doctor::where('user_id', auth()->id())->firstOrFail();
    }

    // my invoices
    public function myInvoices(Request $request)
    {
        $doctor = $this->getDoctor();
        
        $query = Invoice::where('doctor_id', $doctor->id);

        if ($request->filled('search')) {
            $query->where('patient_id', $request->search);
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

    // my patients
    public function myPatients(Request $request)
    {
        $doctor = $this->getDoctor();

        // نجلب فقط الـ IDs للمرضى الذين لديهم فواتير مع هذا الدكتور
        $patientIds = Invoice::where('doctor_id', $doctor->id)->distinct()->pluck('patient_id');

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

    // my bookings
    public function myBookings()
    {
        $doctor = $this->getDoctor();
        $bookings = Booking::where('doctor_id', $doctor->id)->latest()->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    // my schedule
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

public function dashboard()
{
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




}