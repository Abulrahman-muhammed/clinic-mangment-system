<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Start the query
        $query = Service::query();
    
        // Apply search filter if the user typed something
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
    
        // Get paginated results while keeping the search query in the links
        $services = $query->latest()->paginate(10);
    
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->price = $request->price;
        $service->description = $request->description;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('services', $imageName, 'public');
            $service->image = $imageName;
        }

        $service->save();

        return redirect()->route('admin.service.index')->with('success', 'Service created successfully.');

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
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $service = Service::findOrFail($id);
        $data = $request->only(['name', 'price', 'description']);
    
        if ($request->hasFile('image')) {
            // Delete old image using Storage facade
            if ($service->image) {
                \Storage::disk('public')->delete('services/' . $service->image);
            }
    
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('services', $imageName, 'public');
            $data['image'] = $imageName;
        }
    
        $service->update($data);
    
        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && \Storage::disk('public')->exists('services/' . $service->image)) {
            \Storage::disk('public')->delete('services/' . $service->image);
        }

        $service->delete();

        return redirect()->route('admin.service.index')->with('success', 'Service deleted successfully.');
    }
}
