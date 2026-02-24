@extends('admin.master')

@section('title', 'Archived Appointments')

@section('content')

@can('delete_appointments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Appointments</h2>
                    <p class="text-muted">View and manage archived patient appointments</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Appointments
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <!-- Filters -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filter Archived Appointments</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.booking.trashed') }}">
                        <div class="form-row">

                            <div class="form-group col-md-3">
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

                            <div class="form-group col-md-2">
                                <label for="date">Appointment Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <a href="{{ route('admin.booking.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Clear
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Appointments List</strong>
                        <span class="badge badge-warning badge-pill">{{ $bookings->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width:50px">#</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Date & Time</th>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <th>Doctor</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Archived On</th>
                                    <th class="text-center" style="width:90px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                @php
                                    $patient      = $booking->patient;
                                    $patientName  = $patient->name  ?? '—';
                                    $patientEmail = $patient->email ?? '—';
                                    $patientPhone = $patient->phone ?? '—';
                                @endphp
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ $bookings->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Patient --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-3">
                                                <div class="avatar-img rounded-circle bg-soft-warning d-flex align-items-center justify-content-center">
                                                    <span class="h6 mb-0 text-warning">
                                                        {{ strtoupper(substr($patientName, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $patientName }}</strong>
                                                <br><small class="text-muted">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Contact --}}
                                    <td>
                                        <div class="small"><i class="fe fe-mail mr-1 text-muted"></i>{{ $patientEmail }}</div>
                                        <div class="small"><i class="fe fe-phone mr-1 text-muted"></i>{{ $patientPhone }}</div>
                                    </td>

                                    {{-- Date & Time --}}
                                    <td>
                                        <span class="badge badge-soft-secondary px-2 py-1">
                                            <i class="fe fe-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($booking->appointment_date)->format('d M, Y') }}
                                        </span>
                                        <div class="small mt-1 text-muted">
                                            <i class="fe fe-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
                                        </div>
                                    </td>

                                    {{-- Doctor --}}
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-2">
                                                @if($booking->doctor && $booking->doctor->image)
                                                    <img src="{{ asset('images/doctors/' . $booking->doctor->image) }}"
                                                         alt="{{ $booking->doctor->user->name }}"
                                                         class="avatar-img rounded-circle opacity-50">
                                                @else
                                                    <div class="avatar-img rounded-circle bg-soft-secondary d-flex align-items-center justify-content-center">
                                                        <span class="small text-muted font-weight-bold">
                                                            {{ strtoupper(substr($booking->doctor->user->name ?? 'D', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="small font-weight-bold text-muted">
                                                    {{ $booking->doctor->user->name ?? 'N/A' }}
                                                </span>
                                                @if($booking->doctor && $booking->doctor->major)
                                                    <br><span class="badge badge-soft-secondary" style="font-size:0.65rem">
                                                        {{ $booking->doctor->major->title }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endif

                                    {{-- Status --}}
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending'   => ['class' => 'badge-warning',  'icon' => 'fe-clock'],
                                                'confirmed' => ['class' => 'badge-primary',  'icon' => 'fe-check'],
                                                'completed' => ['class' => 'badge-success',  'icon' => 'fe-check-circle'],
                                                'cancelled' => ['class' => 'badge-danger',   'icon' => 'fe-x-circle'],
                                            ];
                                            $cfg = $statusConfig[$booking->status] ?? ['class' => 'badge-secondary', 'icon' => 'fe-help-circle'];
                                        @endphp
                                        <span class="badge {{ $cfg['class'] }} px-2 py-1" style="opacity:.75">
                                            <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    {{-- Archived On --}}
                                    <td>
                                        <small class="text-muted">
                                            <i class="fe fe-clock mr-1"></i>
                                            {{ $booking->deleted_at->format('d M, Y') }}<br>
                                            <span style="font-size:.7rem">{{ $booking->deleted_at->diffForHumans() }}</span>
                                        </small>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <form action="{{ route('admin.booking.restore', $booking->id) }}"
                                              method="POST"
                                              id="restore-form-{{ $booking->id }}"
                                              class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="button"
                                                    onclick="confirmRestore({{ $booking->id }}, '{{ addslashes($patientName) }}', '{{ \Carbon\Carbon::parse($booking->appointment_date)->format('d M, Y') }}')"
                                                    class="btn btn-sm btn-outline-success"
                                                    data-toggle="tooltip" title="Restore">
                                                <i class="fe fe-rotate-ccw"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist')) ? '8' : '7' }}"
                                        class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fe fe-archive fe-24 mb-3"></i>
                                            <p class="mb-0">No archived appointments found.</p>
                                            <a href="{{ route('admin.booking.index') }}" class="btn btn-primary mt-3">
                                                <i class="fe fe-arrow-left"></i> Go to Active Appointments
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($bookings->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }}
                            of {{ $bookings->total() }} archived records
                        </small>
                        {{ $bookings->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@else
    <div class="alert alert-warning text-center">
        <i class="fe fe-alert-triangle mr-2"></i>
        You don't have permission to view archived appointments.
    </div>
@endcan

@endsection

@push('styles')
<style>
.avatar-sm            { width: 36px; height: 36px; }
.avatar-img           { width: 100%; height: 100%; object-fit: cover; }
.bg-soft-warning      { background-color: rgba(255,193,  7,0.1); }
.bg-soft-secondary    { background-color: rgba(108,117,125,0.1); }
.badge-soft-secondary { color: #6c757d; background-color: rgba(108,117,125,0.1); }
.opacity-50           { opacity: 0.5; }
.table-hover tbody tr:hover { background-color: rgba(0,0,0,0.02); }
thead.thead-light th {
    color: #6c757d;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
</style>
@endpush

@push('scripts')
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    if ($.fn.select2) {
        $('.select2').select2({ theme: 'bootstrap4', allowClear: true });
    }
});

function confirmRestore(id, patientName, date) {
    Swal.fire({
        title: 'Restore Appointment?',
        html: 'This appointment will be moved back to active!<br><br>' +
              '<strong>Patient:</strong> ' + patientName + '<br>' +
              '<strong>Date:</strong> ' + date,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6e7881',
        confirmButtonText: 'Yes, Restore!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('restore-form-' + id).submit();
        }
    });
}

setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush