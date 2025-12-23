@extends('admin.master')

@section('title', 'Doctor Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 page-title">Doctor Details</h2>
                <a href="{{ route('admin.doctor.index') }}" class="btn btn-secondary">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            @if($doctor->image)
                                <img src="{{ asset('images/doctors/' . $doctor->image) }}" width="120" height="120" class="rounded-circle shadow-sm" alt="Doctor">
                            @else
                                <img src="{{ asset('admin-assets/img/default-doctor.png') }}" width="120" height="120" class="rounded-circle shadow-sm" alt="Default">
                            @endif
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->name }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->email }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->phone }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Gender</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($doctor->gender) }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Department</label>
                                    <input type="text" class="form-control" value="{{ $doctor->major?->title ?? '-' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Experience (Years)</label>
                                    <input type="text" class="form-control" value="{{ $doctor->years_of_experience ?? 0 }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Consultation Fee</label>
                                    <input type="text" class="form-control" value="{{ $doctor->consultation_fee ?? '—' }}" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $doctor->status ? 'Active' : 'Inactive' }}" readonly>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="{{ $doctor->address ?? '—' }}" readonly>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Bio</label>
                                    <textarea class="form-control" rows="3" readonly>{{ $doctor->bio ?? '—' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Doctor Schedules Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Doctor Schedules</h5>

                    @if($doctor->schedules->count() > 0)
                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctor->schedules as $index => $schedule)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $schedule->day_of_week }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center mb-0">No schedules found for this doctor.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
