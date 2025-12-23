<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate();
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
    public function show(string $id)
    {
        //
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
}
