<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use App\Models\Invoice;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // 1. Initialize the query
        $query = Patient::query();
    
        // 2. Filter by Name, Email, or Phone (Search input)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
    
        // 3. Filter by Gender (Dropdown)
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
    
        // 4. Filter by Blood Type (Dropdown)
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }
    
        // 5. Execute with sorting and pagination
        // latest() ensures newly registered patients appear first
        $patients = $query->latest()->paginate(10);
    
        // 6. Return the view with the filtered patients
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15|unique:patients',
            'gender' => 'required|in:male,female',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
        ]); 
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'address' => $request->address,
            'medical_history' => $request->medical_history,
        ]);
        return redirect()->route('admin.patient.index')->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
public function show(Patient $patient)
{
    // Get patient's appointments
    $appointments = Booking::where('phone', $patient->phone)
                          ->with(['doctor.user', 'doctor.major'])
                          ->latest()
                          ->paginate(10);
    
    // Get patient's invoices
    $invoices = Invoice::where('patient_id', $patient->id)
                      ->with('doctor.user')
                      ->latest()
                      ->take(5)
                      ->get();
    
    // Statistics
    $stats = [
        'total_appointments' => Booking::where('phone', $patient->phone)->count(),
        'completed_appointments' => Booking::where('phone', $patient->phone)
                                          ->where('status', 'completed')
                                          ->count(),
        'pending_appointments' => Booking::where('phone', $patient->phone)
                                        ->where('status', 'pending')
                                        ->count(),
        'total_invoices' => Invoice::where('patient_id', $patient->id)->count(),
        'total_amount' => Invoice::where('patient_id', $patient->id)->sum('amount'),
    ];
    
    return view('admin.patients.show', compact('patient', 'appointments', 'invoices', 'stats'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email,'.$patient->id,
            'password' => 'nullable|string|min:8',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15|unique:patients,phone,'.$patient->id,
            'gender' => 'required|in:male,female',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string',
        ]);
        $patient->name = $request->name;
        $patient->email = $request->email;
        if ($request->password) {
            $patient->password = bcrypt($request->password);
        }
        $patient->date_of_birth = $request->date_of_birth;
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->blood_type = $request->blood_type;
        $patient->address = $request->address;
        $patient->medical_history = $request->medical_history;
        $patient->save();
        return redirect()->route('admin.patient.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('admin.patient.index')->with('success', 'Patient deleted successfully.');
    }
    public function trashed(Request $request)
    {
        $query = Patient::onlyTrashed();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Blood type filter
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }

        $patients = $query->latest('deleted_at')->paginate(15);

        return view('admin.patients.trashed', compact('patients'));
    }

    public function restore($id)
    {
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->restore();

        return redirect()->route('admin.patient.trashed')
            ->with('success', "Patient '{$patient->name}' has been restored successfully!");
    }
}
