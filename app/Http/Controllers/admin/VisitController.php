<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Major;
use App\Http\Traits\UploadFile;
use App\Notifications\NewVisitNotification;
class VisitController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $visits = Visit::with(['patient', 'doctor.user', 'doctor.major', 'receptionist'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('patient', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->orWhereHas('doctor.user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            })
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date,   fn($q) => $q->whereDate('created_at', $request->date))
            ->latest()
            ->paginate(15);
            $doctors = Doctor::with('user')->get();
            return view('admin.visits.index', compact('visits', 'doctors'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients      = Patient::orderBy('name')->get();
        $doctors       = Doctor::with(['user', 'major'])->get();
        $receptionists = User::role('receptionist')->orderBy('name')->get();

        return view('admin.visits.create', compact('patients', 'doctors', 'receptionists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'receptionist_id'  => 'nullable|exists:users,id',
            'status'           => 'required|in:in_progress,done,cancelled',
            'notes'            => 'nullable|string|max:2000',
        ]);

        $visit = Visit::create($validated);
        $doctorUser = $visit->doctor->user;
        // Notify the doctor about the new visit
        $doctorUser->notify(new NewVisitNotification($visit));



        return redirect()->route('admin.visit.index')
                            ->with('success', 'Visit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->load(['patient', 'doctor.user', 'doctor.major', 'receptionist', 'invoice']);
 
        return view('admin.visits.show', compact('visit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $visit = Visit::findOrFail($id);
        $patients      = Patient::orderBy('name')->get();
        $doctors       = Doctor::with(['user', 'major'])->get();
        $receptionists = User::role('receptionist')->orderBy('name')->get();
 
        return view('admin.visits.edit', compact('visit', 'patients', 'doctors', 'receptionists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $visit = Visit::findOrFail($id);
        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'receptionist_id'  => 'nullable|exists:users,id',
            'status'           => 'required|in:in_progress,done,cancelled',
            'notes'            => 'nullable|string|max:2000',
        ]);
 
        $visit->update($validated);
 
        return redirect()->route('admin.visit.index')
                         ->with('success', 'Visit updated successfully.');
    }


    public function destroy(Visit $visit)
    {
 
        $visit->delete();
 
        return redirect()->route('admin.visit.index')
                         ->with('success', 'Visit archived successfully.');
    }
 
    /**
     * Display archived (soft-deleted) visits.
     */
    public function trashed(Request $request)
    {
 
        $visits = Visit::onlyTrashed()
            ->with(['patient', 'doctor.user', 'doctor.major', 'receptionist'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('patient', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('doctor.user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            })
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('deleted_at')
            ->paginate(15);
 
        return view('admin.visits.trashed', compact('visits'));
    }
 
    /**
     * Restore a soft-deleted visit.
     */
    public function restore($id)
    {
 
        $visit = Visit::onlyTrashed()->findOrFail($id);
        $visit->restore();
 
        return redirect()->route('admin.visit.trashed')
                         ->with('success', 'Visit restored successfully.');
    }

    /**
     * Update visit status.
     */
    public function updateStatus(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->update(['status' => $request->status]);
 
        return redirect()->route('admin.visit.show', $visit)
                         ->with('success', 'Visit status updated successfully.');
    }
}
