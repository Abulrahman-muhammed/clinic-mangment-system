<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Doctor;
use App\Models\Major;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Traits\UploadFile;      
use App\Models\Receptionist;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class profileController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function adminProfile()
    {
        $user = Auth::user();
        return view('admin.profile.admin', compact('user'));
    }

    public function updateAdminProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
    
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
    
        $user->save();
    
        return redirect()
            ->route('admin.profile.admin')
            ->with('success', 'Your profile has been updated successfully.');
    }

    public function doctorProfile()
    {
        $doctor = Doctor::with('major', 'user')->where('user_id', Auth::user()->id)->first();
        $majors = Major::get();
        return view('admin.profile.doctor', compact('doctor', 'majors'));
    }

    public function updateDoctorProfile(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $doctor = Doctor::with('user')->where('user_id', Auth::id())->firstOrFail();
    
        $imageName = $doctor->image; 
    
        if($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->image, Doctor::IMAGE_PATH, $doctor->image);
        }
    
        $doctor->update([
            'major_id'            => $request->major_id,
            'image'               => $imageName,
            'bio'                 => $request->bio,
            'address'             => $request->address,
            'gender'              => $request->gender,
            'consultation_fee'    => $request->consultation_fee,
            'years_of_experience' => $request->years_of_experience,
        ]);
    
        if($doctor->user) {            
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
    
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
    
            $doctor->user->update($userData);
        }
    
        return redirect()->route('admin.profile.doctor')
                            ->with('success', 'Your profile has been updated successfully.');
    }


    public function receptionistProfile()
    {
        $receptionist = Receptionist::with('user')->where('user_id', Auth::user()->id)->first();
        return view('admin.profile.reception', compact('receptionist'));
    }

    public function updateReceptionistProfile(Request $request)
    {
        $receptionist = Receptionist::with('user')->where('user_id', Auth::user()->id)->firstOrFail();
        
// 1. Inline Validation
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($receptionist->user_id)],
        'phone'    => ['required', 'string', 'max:20', Rule::unique('users')->ignore($receptionist->user_id)],
        'address'  => 'nullable|string|max:500',
        'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    try {
        DB::beginTransaction();

        // 2. Update User Account Data
        $user = $receptionist->user;
        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        // 3. Update Receptionist Specific Data
        $receptionist->address = $validated['address'];

        // 4. Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($receptionist->image && File::exists(public_path('images/receptionists/' . $receptionist->image))) {
                File::delete(public_path('images/receptionists/' . $receptionist->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/receptionists'), $imageName);
            $receptionist->image = $imageName;
        }

        $receptionist->save();

        DB::commit();
        return back()->with('success', 'Profile updated successfully!');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'An error occurred while updating the profile: ' . $e->getMessage()]);
    }
    }
}
