<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receptionist;
use App\Models\User;
class ReceptionistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receptionists = Receptionist::paginate();
        return view('admin.receptionists.index', compact('receptionists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.receptionists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shift' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
        ]); 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);
        $user->assignRole('receptionist');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/receptionists'), $imageName);
            $receptionistData['image'] = $imageName;
        }
        Receptionist::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'image' => $imageName ?? null,
            'shift' => $request->shift,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.receptionist.index')->with('success', 'Receptionist created successfully.');
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
        $receptionist = Receptionist::findOrFail($id);
        return view('admin.receptionists.edit', compact('receptionist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $receptionist = Receptionist::findOrFail($id);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . ($receptionist->user_id ?? 'NULL') . ',id',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . ($receptionist->user_id ?? 'NULL') . ',id',
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shift' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
        ]);
        if($receptionist->user){
            $userData = [];
            if ($request->filled('name')) {
                $userData['name'] = $request->name;
            }
            if ($request->filled('email')) {
                $userData['email'] = $request->email;
            }
            if ($request->filled('phone')) {
                $userData['phone'] = $request->phone;
            }
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            if (!empty($userData)) {
                $receptionist->user->update($userData);
            }
        }

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/receptionists'), $imageName);
            $receptionistData['image'] = $imageName;
        }
        $receptionist->update([
            'address' => $request->address ?? $receptionist->address,
            'image' => $imageName ?? $receptionist->image,
            'shift' => $request->shift ?? $receptionist->shift,
            'status' => $request->status ?? $receptionist->status,
        ]);
        return redirect()->route('admin.receptionist.index')->with('success', 'Receptionist updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receptionist = Receptionist::findOrFail($id);
        if($receptionist->image){
            $imagePath = public_path('images/receptionists/' . $receptionist->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if($receptionist->user){
            $receptionist->user->delete();
        }
        $receptionist->delete();
        return redirect()->route('admin.receptionist.index')->with('success', 'Receptionist deleted successfully.');
    }
}
