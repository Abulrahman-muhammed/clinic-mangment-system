@extends('admin.master')

@section('title', 'Doctor Details | ' . $doctor->user->name)

@push('styles')
<style>
    /* تحسين شكل التسميات والحقول */
    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #8898aa;
        letter-spacing: 0.5px;
        font-weight: bold;
        margin-bottom: 0.3rem;
        display: block;
    }
    .form-control[readonly] {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
        color: #2d3748;
        font-weight: 500;
        cursor: default;
    }
    /* تأثيرات الصورة */
    .doctor-profile-img {
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    /* تنسيق جدول المواعيد */
    .schedule-table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        border-bottom: 2px solid #e2e8f0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0 page-title">Doctor Profile</h2>
                    <p class="text-muted">Detailed overview of professional and personal information.</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn btn-primary px-4">
                        <i class="fe fe-edit mr-1"></i> Edit Doctor
                    </a>
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fe fe-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if($doctor->image)
                                    <img src="{{ asset('images/doctors/' . $doctor->image) }}" 
                                         class="rounded-circle doctor-profile-img" 
                                         width="150" height="150" style="object-fit: cover;" alt="Doctor">
                                @else
                                    <img src="{{ asset('admin-assets/img/default-doctor.png') }}" 
                                         class="rounded-circle doctor-profile-img" 
                                         width="150" height="150" alt="Default">
                                @endif
                            </div>
                            <h4 class="mb-1 text-dark">{{ $doctor->user->name }}</h4>
                            <p class="text-muted small mb-3">{{ $doctor->major?->title ?? 'Unassigned' }}</p>
                            
                            <hr>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <strong class="card-title text-primary"><i class="fe fe-user mr-2"></i> Professional Information</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="detail-label">Email Address</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->email }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="detail-label">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->phone }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="detail-label">Gender</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($doctor->gender) }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="detail-label">Experience</label>
                                    <input type="text" class="form-control" value="{{ $doctor->years_of_experience ?? 0 }} Years" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="detail-label">Consultation Fee</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ number_format($doctor->consultation_fee, 2) }}" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-light">EGP</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="detail-label">Address</label>
                                    <input type="text" class="form-control" value="{{ $doctor->address ?? 'Not provided' }}" readonly>
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label class="detail-label">Short Biography</label>
                                    <textarea class="form-control" rows="3" readonly>{{ $doctor->bio ?? 'No biography available for this doctor.' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <strong class="card-title text-primary"><i class="fe fe-calendar mr-2"></i> Availability Schedule</strong>
                        </div>
                        <div class="card-body">
                            @if($doctor->schedules->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover schedule-table text-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Day</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($doctor->schedules as $schedule)
                                                <tr>
                                                    <td><span class="font-weight-bold">{{ $schedule->day_of_week }}</span></td>
                                                    <td><i class="fe fe-clock text-success mr-1"></i> {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                                    <td><i class="fe fe-clock text-danger mr-1"></i> {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                                    <td><span class="dot dot-sm bg-success mr-2"></span> Available</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fe fe-calendar text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0">No working hours have been set for this doctor yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection