@extends('admin.master')

@section('title', 'Appointments')

@section('content')

@can('view_appointments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Appointments</h2>
                    <p class="text-muted">Review and manage patient bookings and schedules.</p>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filter Appointments</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.booking.index') }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Patient Info</label>
                                <input type="text" name="search" id="search" class="form-control" 
                                       value="{{ request('search') }}" placeholder="Name, Email or Phone">
                            </div>

                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                            <div class="form-group col-md-3">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-control select2">
                                    <option value="">All Doctors</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="form-group col-md-3">
                                <label for="date">Appointment Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body p-0">
                    
                    @if(session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">#</th>
                                    <th>Patient</th>
                                    <th>Contact Info</th>
                                    <th>Date & Time</th>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <th>Assigned Doctor</th>
                                    @endif
                                    <th>Status</th>
                                    <th class="text-right pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr class="align-middle">
                                        <td class="pl-4 text-muted">{{ $bookings->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $booking->name }}</div>
                                            <small class="text-muted">ID: #{{ $booking->id }}</small>
                                        </td>
                                        <td>
                                            <div class="small"><i class="fe fe-mail mr-1"></i> {{ $booking->email }}</div>
                                            <div class="small"><i class="fe fe-phone mr-1"></i> {{ $booking->phone }}</div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary px-2 py-1">
                                                <i class="fe fe-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($booking->date)->format('d M, Y') }}
                                            </span>
                                            <div class="small mt-1 text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ \Carbon\Carbon::parse($booking->date)->format('h:i A') }}
                                            </div>
                                        </td>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light text-primary small">
                                                        {{ strtoupper(substr($booking->doctor->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span>{{ $booking->doctor->user->name }}</span>
                                            </div>
                                        </td>
                                        @endif
                                        <td class="align-middle">
                                            <span class="badge booking-status-{{ $booking->id }} {{ 
                                                $booking->status == 'pending' ? 'badge-warning' : 
                                                ($booking->status == 'confirmed' ? 'badge-primary' : 
                                                ($booking->status == 'completed' ? 'badge-success' : 'badge-danger')) 
                                            }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="text-right pr-4">
                                            @can('edit_appointments')
                                            <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete_appointments')
                                            <form action="{{ route('admin.booking.destroy', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Remove this appointment?')">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fe fe-calendar fe-32 mb-3"></i>
                                            <p>No appointments found for the selected filters.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($bookings->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} records</small>
                        {{ $bookings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endcan

@endsection

@push('styles')
<style>
    .badge-soft-primary { background-color: rgba(60, 114, 252, 0.1); color: #3c72fc; }
    .avatar-xs { width: 24px; height: 24px; line-height: 24px; font-size: 10px; }
    .badge { padding: 0.5em 0.75em; text-transform: capitalize; }
</style>
@endpush

