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
   /**
 * Soft delete a schedule
 */
public function destroy(string $id)
{
    $schedule = DoctorSchedule::with(['doctor.user'])->findOrFail($id);
    $doctorName = $schedule->doctor->user->name ?? 'Doctor';
    $day = $schedule->day_of_week;
    
    $schedule->delete();
    
    return redirect()->route('admin.schedule.index')
        ->with('success', "Schedule for Dr. {$doctorName} on {$day} has been moved to archives!");
}

/**
 * Display trashed schedules
 */
public function trashed(Request $request)
{
    // ✅ onlyTrashed أول حاجة
    $query = DoctorSchedule::onlyTrashed()->with([
        'doctor' => fn($q) => $q->withTrashed(),
        'doctor.user' => fn($q) => $q->withTrashed()
    ]);

    // Filter by doctor name
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('doctor.user', function($q) use ($search) {
            $q->withTrashed()->where('name', 'LIKE', "%{$search}%");
            //  ↑ لازم withTrashed هنا كمان
        });
    }

    // Filter by day
    if ($request->filled('day')) {
        $query->where('day_of_week', $request->day);
    }

    $schedules = $query->latest('deleted_at')->paginate(10);

    return view('admin.schedules.trashed', compact('schedules'));
}

/**
 * Restore a trashed schedule
 */
public function restore($id)
{
    $schedule = DoctorSchedule::onlyTrashed()->with([
        'doctor' => fn($q) => $q->withTrashed(),
        'doctor.user' => fn($q) => $q->withTrashed()
    ])->findOrFail($id);
    
    $doctorName = $schedule->doctor?->user?->name ?? 'Doctor';
    $day = $schedule->day_of_week;
    
    $schedule->restore();

    return redirect()->route('admin.schedule.trashed')
        ->with('success', "Schedule for Dr. {$doctorName} on {$day} has been restored successfully!");
}


}
