<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Role;
use App\Models\Receptionist;
use  Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // spatiee middleware
    


    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search by name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->role($request->role); // Spatie helper
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all(); // For the filter dropdown

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
            'role'     => 'admin',
        ]);

        // Assign Role
        if ($request->role) {
            $roleName = strtolower($request->role);
            $user->assignRole($roleName);

            // Create related profile if Doctor or Receptionist
            if ($roleName === 'doctor') {
                Doctor::create([
                    'user_id' => $user->id,
                    'major_id' => 1,
                ]);
            } elseif ($roleName === 'receptionist') {
                Receptionist::create([
                    'user_id' => $user->id,
                ]);
            }
        }
        });

        return redirect()->route('admin.user.index')
            ->with('success', ' User created successfully.');
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
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        $userRole = $user->roles->pluck('name')->first();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role'  => 'admin',
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // Sync Role
        if ($request->role) {
            $roleName = strtolower($request->role);
            $user->syncRoles([$roleName]);

            // Ensure profile exists
            if ($roleName === 'doctor' && !$user->doctor) {
                Doctor::create([
                    'user_id' => $user->id,
                    'major_id' => 1,
                ]);
            } elseif ($roleName === 'receptionist' && !$user->receptionist) {
                Receptionist::create([
                    'user_id' => $user->id,
                ]);
            }
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('admin.user.index')
            ->with('success', '✅ User updated successfully.');
    }


/**
 * Soft delete a user
 */

public function destroy(User $user)
{
    if ($user->id === auth()->id()) {
        return redirect()->route('admin.user.index')
            ->with('error', 'You cannot delete your own account!');
    }

    $name = $user->name;

    DB::transaction(function () use ($user) {
        
        if ($user->doctor) {
            // ✅ soft delete schedules/invoices/bookings BEFORE deleting doctor
            $user->doctor->schedules()->delete();
            $user->doctor->invoices()->delete();
            $user->doctor->bookings()->delete();
            
            // Now soft delete the doctor
            $user->doctor->delete();
        }

        if ($user->receptionist) {
            $user->receptionist->delete();
        }

        $user->delete();
    });

    return redirect()->route('admin.user.index')
        ->with('success', "{$name} has been moved to archives!");
}
/**
 * Display trashed users
 */
public function trashed(Request $request)
{
    $query = User::onlyTrashed()->with('roles'); // FIX: onlyTrashed بدل with trashed

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name',  'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    if ($request->filled('role')) {
        $query->whereHas('roles', function ($q) use ($request) {
            $q->where('name', $request->role);
        });
    }

    $users = $query->latest('deleted_at')->paginate(10);
    $roles = Role::all();

    return view('admin.users.trashed', compact('users', 'roles'));
}


/**
 * Restore a soft-deleted user
 */
public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);

    DB::transaction(function () use ($user) {
        $user->restore();

        if ($user->doctor()->withTrashed()->exists()) {
            $doctor = $user->doctor()->withTrashed()->first();
            
            // Restore doctor first
            $doctor->restore();
            
            // Then restore related records using whereHas or direct query
            \App\Models\DoctorSchedule::onlyTrashed()
                ->where('doctor_id', $doctor->id)
                ->restore();
            
            \App\Models\Invoice::onlyTrashed()
                ->where('doctor_id', $doctor->id)
                ->restore();
            
            \App\Models\Booking::onlyTrashed()
                ->where('doctor_id', $doctor->id)
                ->restore();
        }

        if ($user->receptionist()->withTrashed()->exists()) {
            $user->receptionist()->withTrashed()->first()->restore();
        }
    });

    return redirect()->route('admin.user.trashed')
        ->with('success', "{$user->name} has been restored successfully!");
}

/**
 * Permanently delete a user
 */
public function forceDelete($id)
{
    $user = User::onlyTrashed()->with('roles')->findOrFail($id);
    $name = $user->name;
    $role = $user->roles->pluck('name')->first();

    // ✅ Check if doctor has related data
    if ($role === 'doctor' && $user->doctor()->withTrashed()->exists()) {
        $doctor = $user->doctor()->withTrashed()->first();
        
        $relatedData = [];
        
        $bookingsCount  = \App\Models\Booking::withTrashed()->where('doctor_id', $doctor->id)->count();
        $invoicesCount  = \App\Models\Invoice::withTrashed()->where('doctor_id', $doctor->id)->count();
        $schedulesCount = \App\Models\DoctorSchedule::withTrashed()->where('doctor_id', $doctor->id)->count();
        
        if ($bookingsCount > 0)  $relatedData[] = "{$bookingsCount} appointment(s)";
        if ($invoicesCount > 0)  $relatedData[] = "{$invoicesCount} invoice(s)";
        if ($schedulesCount > 0) $relatedData[] = "{$schedulesCount} schedule(s)";

        if (!empty($relatedData)) {
            return redirect()->route('admin.user.trashed')
                ->with('error', "Cannot delete {$name} because they have: " . implode(', ', $relatedData) . ". Please delete these first from their respective pages.");
        }
    }

    // ✅ Safe to delete — لو وصلنا هنا يبقى مفيش بيانات
    DB::transaction(function () use ($user, $role) {
        
        if ($role === 'doctor' && $user->doctor()->withTrashed()->exists()) {
            $doctor = $user->doctor()->withTrashed()->first();
            
            // Delete image only
            if ($doctor->image) {
                $path = public_path('images/doctors/' . $doctor->image);
                if (file_exists($path)) unlink($path);
            }
            
            $doctor->forceDelete();
        }

        if ($role === 'receptionist' && $user->receptionist()->withTrashed()->exists()) {
            $receptionist = $user->receptionist()->withTrashed()->first();
            
            if ($receptionist->image) {
                $path = public_path('images/receptionists/' . $receptionist->image);
                if (file_exists($path)) unlink($path);
            }
            
            $receptionist->forceDelete();
        }

        $user->forceDelete();
    });

    return redirect()->route('admin.user.trashed')
        ->with('success', "{$name} has been permanently deleted!");
}
}
