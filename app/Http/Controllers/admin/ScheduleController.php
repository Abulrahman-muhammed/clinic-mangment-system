<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = DoctorSchedule::with(['doctor.user']);
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('doctor.user', function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%");
        });
    }
    if ($request->filled('day')) {
        $query->where('day_of_week', $request->day);
    }
    $schedules = $query->orderBy('id', 'desc')->paginate(10);

    // نمرر النتائج للـ View
    return view('admin.schedules.index', compact('schedules'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::with('user','major')->get();
        return view('admin.schedules.create',compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        DoctorSchedule::create([
            'doctor_id' => $request->doctor_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Schedule added successfully');
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
        $doctors=Doctor::with('user','major')->get();
        $schedule=DoctorSchedule::findOrFail($id);
        return view('admin.schedules.edit',compact('doctors','schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->update([
            'doctor_id' => $request->doctor_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        if (auth()->user()->hasRole('doctor')) {
            return redirect()->route('admin.doctor.mySchedule')->with('success', 'Schedule updated successfully');
        }
        return redirect()->route('admin.schedule.index')->with('success', 'Schedule updated successfully');
        // resources\views\admin\schedules\index.blade.php
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('admin.schedule.index')->with('success', 'Schedule deleted successfully');
    }
}
