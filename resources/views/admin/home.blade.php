@extends('admin.master')
@php
    $title = 'Admin Dashboard';
    if(auth()->user()->hasRole('admin')) {
        $title = 'Admin ';
    } elseif(auth()->user()->hasRole('doctor')) {
        $title = 'Doctor ';
    } elseif(auth()->user()->hasRole('receptionist')) {
        $title = 'Receptionist ';
    }
@endphp
@section('title', $title)
@section('content')

@role('admin')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h5 page-title">Admin Dashboard</h2>
                    <p class="text-muted">Welcome back, {{  ucfirst(auth()->user()->name) }}</p>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('admin.booking.index') }}'">
                        <span class="fe fe-calendar mr-2"></span>View All Appointments
                    </button>
                </div>
            </div>

            <!-- Main Stats Cards -->
            <div class="row my-4">
                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Departments</small>
                                    <h3 class="card-title mb-0">{{ $majors }}</h3>
                                    <p class="small text-muted mb-0">
                                        <span class="fe fe-briefcase fe-12 text-primary"></span>
                                        <span>Total Specializations</span>
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-briefcase fe-32 text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Doctors</small>
                                    <h3 class="card-title mb-0">{{ $doctors }}</h3>
                                    <p class="small text-muted mb-0">
                                        <span class="fe fe-user-check fe-12 text-success"></span>
                                        <span>Active Physicians</span>
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-user-check fe-32 text-success"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Total Appointments</small>
                                    <h3 class="card-title mb-0">{{ $bookings }}</h3>
                                    <p class="small text-muted mb-0">
                                        <span class="fe fe-calendar fe-12 text-info"></span>
                                        <span>All Time</span>
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-calendar fe-32 text-info"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Total Users</small>
                                    <h3 class="card-title mb-0">{{ $users }}</h3>
                                    <p class="small text-muted mb-0">
                                        <span class="fe fe-users fe-12 text-warning"></span>
                                        <span>Registered</span>
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-users fe-32 text-warning"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow border-0 text-white bg-warning mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Pending Appointments</small>
                                    <h3 class="card-title text-white mb-0">{{ $pendingBookings }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-clock fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-0 text-white bg-info mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Today's Appointments</small>
                                    <h3 class="card-title text-white mb-0">{{ $todayBookings }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-calendar fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow border-0 text-white bg-success mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Completed</small>
                                    <h3 class="card-title text-white mb-0">{{ $completedBookings }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-check-circle fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments & Top Doctors -->
            <div class="row">
                <!-- Recent Appointments -->
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Recent Appointments</strong>
                            <a class="float-right small text-primary" href="{{ route('admin.booking.index') }}">View all</a>
                        </div>
                        <div class="card-body p-0">
                            @if($recentBookings->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Patient</th>
                                                <th class="border-top-0">Doctor</th>
                                                <th class="border-top-0">Date & Time</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentBookings as $booking)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
  
                                                        <div>
                                                            <strong>{{ $booking->name ?? 'N/A' }}</strong><br>
                                                            <small class="text-muted">{{ $booking->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>Dr. {{ $booking->doctor->user->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $booking->doctor->major->name ?? '' }}</small>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</span><br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($booking->date)->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ 
                                                        $booking->status == 'completed' ? 'success' : 
                                                        ($booking->status == 'pending' ? 'warning' : 
                                                        ($booking->status == 'confirmed' ? 'info' : 'secondary')) 
                                                    }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-sm btn-outline-primary">
                                                        <span class="fe fe-eye"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <span class="fe fe-calendar fe-48 text-muted mb-3 d-block"></span>
                                    <p class="text-muted">No appointments yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Top Doctors -->
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Top Doctors</strong>
                            <span class="badge badge-soft-primary float-right">Most Bookings</span>
                        </div>
                        <div class="card-body">
                            @if($topDoctors->count() > 0)
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($topDoctors as $doctor)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill">
                                                <strong class="d-block">Dr. {{ $doctor->user->name }}</strong>
                                                <small class="text-muted">{{ $doctor->major->name ?? 'General' }}</small>
                                            </div>
                                            <div class="text-right">
                                                <span class="badge badge-primary">{{ $doctor->bookings_count }}</span>
                                                <small class="d-block text-muted">ِAppointments</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <span class="fe fe-users fe-48 text-muted mb-3 d-block"></span>
                                    <p class="text-muted">No data available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <strong class="card-title">Quick Actions</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-primary btn-block py-3">
                                        <span class="fe fe-calendar fe-24 mb-2 d-block"></span>
                                        Manage Appointments
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-success btn-block py-3">
                                        <span class="fe fe-user-check fe-24 mb-2 d-block"></span>
                                        Manage Doctors
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="{{ route('admin.major.index') }}" class="btn btn-outline-info btn-block py-3">
                                        <span class="fe fe-briefcase fe-24 mb-2 d-block"></span>
                                        Manage Departments
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-warning btn-block py-3">
                                        <span class="fe fe-users fe-24 mb-2 d-block"></span>
                                        Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole

@role('doctor')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h5 page-title">Doctor Dashboard</h2>
                    <p class="text-muted">Welcome back, Dr. {{ ucfirst(auth()->user()->name) }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row my-4">
                <div class="col-md-3">
                    <div class="card shadow border-0 text-white bg-primary mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Total Appointments</small>
                                    <h3 class="card-title text-white mb-0">{{ $data['bookings_count'] }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-calendar fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">My Patients</small>
                                    <h3 class="card-title mb-0">{{ $data['patients_count'] }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-users fe-32 text-success"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Working Days</small>
                                    <h3 class="card-title mb-0">{{ $data['schedules_count'] }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-clock fe-32 text-warning"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Total Invoices</small>
                                    <h3 class="card-title mb-0">{{ $data['invoices_count'] }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-file-text fe-32 text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Recent Appointments</strong>
                            <a class="float-right small text-primary" href="{{ route('admin.doctor.myBookings') }}">View all</a>
                        </div>
                        <div class="card-body p-0">
                            @if($data['recent_bookings']->count() > 0)
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Patient</th>
                                            <th class="border-top-0">Date</th>
                                            <th class="border-top-0">Status</th>
                                            <th class="border-top-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['recent_bookings'] as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->name ?? 'N/A' }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}</span><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($booking->date)->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $booking->status == 'completed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.doctor.myBookings') }}" class="btn btn-sm btn-outline-primary">
                                                    <span class="fe fe-eye"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5">
                                    <span class="fe fe-calendar fe-48 text-muted mb-3"></span>
                                    <p class="text-muted">No recent appointments</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Recent Patients</strong>
                            <a class="float-right small text-primary" href="{{ route('admin.doctor.myPatients') }}">View all</a>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($data['recent_patients']) && $data['recent_patients']->count() > 0)
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Patient Name</th>
                                            <th class="border-top-0">Last Visit</th>
                                            <th class="border-top-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['recent_patients'] as $patient)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $patient->patient->name ?? 'N/A' }}</strong><br>
                                                        <small class="text-muted">ID: #{{ $patient->patient_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ \Carbon\Carbon::parse($patient->last_visit)->format('M d, Y') }}</span><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($patient->last_visit)->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                  <a href="{{ route('admin.patient.show', $patient->patient_id) }}" class="btn btn-sm btn-outline-primary">
                                                    <span class="fe fe-eye"></span>
                                                  </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5">
                                    <span class="fe fe-users fe-48 text-muted mb-3"></span>
                                    <p class="text-muted">No patients yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Weekly Schedule</strong>
                            <a class="float-right small text-primary" href="{{ route('admin.doctor.mySchedule') }}">Manage Schedule</a>
                        </div>
                        <div class="card-body">
                            @if($data['schedules']->count() > 0)
                                <div class="row">
                                    @foreach($data['schedules']->take(7) as $sched)
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center py-3">
                                                <h6 class="mb-1">{{ $sched->day_of_week }}</h6>
                                                <span class="badge badge-primary">{{ $sched->start_time }} - {{ $sched->end_time }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <span class="fe fe-clock fe-48 text-muted mb-3"></span>
                                    <p class="text-muted">No schedule set</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole

@role('receptionist')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h5 page-title">Receptionist Dashboard</h2>
                    <p class="text-muted">Welcome back, {{ ucfirst(auth()->user()->name) }}</p>
                </div>

            </div>

            <!-- Stats Cards -->
            <div class="row my-4">
                <div class="col-md-3">
                    <div class="card shadow border-0 text-white bg-info mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Today's Appointments</small>
                                    <h3 class="card-title text-white mb-0">{{ $todayBookings }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-calendar fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 text-white bg-warning mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Pending</small>
                                    <h3 class="card-title text-white mb-0">{{ $pendingBookings }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-clock fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 text-white bg-success mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 mb-1">Completed Today</small>
                                    <h3 class="card-title text-white mb-0">{{ $completedToday }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-check-circle fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-muted mb-1">Total Patients</small>
                                    <h3 class="card-title mb-0">{{ $totalPatients }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="fe fe-users fe-32 text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Appointments Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Today's Appointments</strong>
                            <span class="badge badge-primary float-right">{{ \Carbon\Carbon::today()->format('l, M d, Y') }}</span>
                        </div>
                        <div class="card-body p-0">
                            @if($todayAppointments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">Patient</th>
                                                <th class="border-top-0">Doctor</th>
                                                <th class="border-top-0">Time</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0 text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($todayAppointments as $index => $appointment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <strong>{{ $appointment->name ?? 'N/A' }}</strong><br>
                                                            <small class="text-muted">{{ $appointment->phone ?? 'No phone' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $appointment->doctor->major->name ?? 'General' }}</small>
                                                </td>
                                                <td>
                                                    <span class="fe fe-clock text-muted mr-1"></span>
                                                    {{ \Carbon\Carbon::parse($appointment->date)->format('h:i A') }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ 
                                                        $appointment->status == 'completed' ? 'success' : 
                                                        ($appointment->status == 'pending' ? 'warning' : 
                                                        ($appointment->status == 'confirmed' ? 'info' : 'secondary')) 
                                                    }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                        <span class="fe fe-eye"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <span class="fe fe-calendar fe-48 text-muted mb-3 d-block"></span>
                                    <p class="text-muted mb-3">No appointments scheduled for today</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <strong class="card-title">Quick Actions</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('admin.patient.create') }}" class="btn btn-outline-info btn-block py-3">
                                        <span class="fe fe-user-plus fe-24 mb-2 d-block"></span>
                                        Register Patient
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-success btn-block py-3">
                                        <span class="fe fe-search fe-24 mb-2 d-block"></span>
                                        Search Records
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('admin.invoice.create') }}" class="btn btn-outline-warning btn-block py-3">
                                        <span class="fe fe-file-text fe-24 mb-2 d-block"></span>
                                        Generate Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole

@endsection

@push('styles')
<style>
.badge-soft-primary { 
    background-color: rgba(60, 114, 252, 0.1); 
    color: #3c72fc; 
}
.avatar-sm { 
    width: 32px; 
    height: 32px; 
    line-height: 32px; 
    font-size: 12px; 
}
.avatar-md { 
    width: 40px; 
    height: 40px; 
    line-height: 40px; 
    font-size: 14px; 
}
.bg-primary-light {
    background-color: rgba(60, 114, 252, 0.1);
}
.bg-success-light {
    background-color: rgba(40, 167, 69, 0.1);
}
</style>
@endpush