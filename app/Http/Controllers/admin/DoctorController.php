<?php

namespace App\Http\Controllers\admin;

use App\Models\Doctor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Traits\UploadFile;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
class DoctorController extends Controller
{

    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Doctor::with('major', 'user');

        // Filter by name
        if ($request->filled('name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('major_id', $request->department);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $doctors = $query->withoutTrashed()->orderBy('id', 'desc')->paginate(10);
        $majors = Major::orderBy('title', 'asc')->get();

        return view('admin.doctors.index', compact('doctors', 'majors'));
    }
    public function trashed(Request $request)
    {
        $query = Doctor::onlyTrashed()->with(['major', 'user' => function($q) {
            $q->withTrashed(); // يجلب الـ soft deleted users
        }]);

        // Filter by name
        if ($request->filled('name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('major_id', $request->department);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $doctors = $query->orderBy('id', 'desc')->paginate(10);
        $majors = Major::orderBy('title', 'asc')->get();

        return view('admin.doctors.trashed', compact('doctors', 'majors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::get();
        return view('admin.doctors.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {

        if($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->image, Doctor::IMAGE_PATH);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);
        $user->assignRole('doctor');

        Doctor::create([
            'user_id' => $user->id,
            'major_id' => $request->major_id,
            'image' => $imageName?? null ,
            'bio' => $request->bio,
            'address' => $request->address,
            'gender' => $request->gender,
            'consultation_fee' => $request->consultation_fee,
            'years_of_experience' => $request->years_of_experience,
            'status' => $request->status,       
        ]);

        return redirect()->route('admin.doctor.index')->with('success', 'Doctor added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $majors = Major::get();
        return view('admin.doctors.edit', compact('doctor','majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $imageName = null;

        if($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->image, Doctor::IMAGE_PATH, $doctor->image);
        }
        

        $doctor->update([
            'major_id' => $request->major_id,
            'image' => $imageName?? $doctor->image,
            'bio' => $request->bio,
            'address' => $request->address,
            'gender' => $request->gender,
            'consultation_fee' => $request->consultation_fee,
            'years_of_experience' => $request->years_of_experience,
        ]);
        if($doctor->user) {            
            $doctor->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password ? bcrypt($request->password) : $doctor->user->password,
            ]);
        }

        return redirect()->route('admin.doctor.index')->with('success', 'Doctor updated successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::with('major')->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor) {
        $doctor->delete();
        if($doctor->user){
            $doctor->user->delete();
        }
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor Archived successfully');
    }
    /**
     * Get doctor info by ID (for AJAX requests)
     */
    public function info($id)
    {
        $doctor = Doctor::with('major')->find($id);


        return response()->json([
            'department_name' => $doctor->major->title ?? 'N/A',
            'consultation_fee' => $doctor->consultation_fee ?? 0,
        ]);
    }

    // restore doctor
    public function restore($id)
    {
        $doctor = Doctor::withTrashed()->findOrFail($id);
        $doctor->restore();
        if($doctor->user()->withTrashed()->first()) {
            $doctor->user()->withTrashed()->first()->restore();
        }
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor restored successfully');
    }
}
