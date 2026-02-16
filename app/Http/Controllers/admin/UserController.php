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
    $query = User::where('role', '=', 'admin');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

    return view('admin.users.index', compact('users'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete related doctor/receptionist if exist
        if ($user->doctor) {
            $user->doctor->delete();
        }

        if ($user->receptionist) {
            $user->receptionist->delete();
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', ' User deleted successfully.');
    }
}
