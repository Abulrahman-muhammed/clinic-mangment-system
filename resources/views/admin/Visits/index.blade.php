@extends('admin.master')

@section('title', 'Visits')

@section('content')

@can('edit_patients')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Visits Management</h2>
                    <p class="text-muted">View and manage patient visit records</p>
                </div>
                <div class="col-auto">
                    @can('delete_patients')
                    <a href="{{ route('admin.visit.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Visits
                    </a>
                    @endcan
                    @can('create_patients')
                    <a href="{{ route('admin.visit.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Visit
                    </a>
                    @endcan
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
                    <strong class="card-title">Filter Visits</strong>
                </div>
                <div class="card-body">
                    @php
                        $action = auth()->user()->hasRole('doctor')
                            ? route('admin.doctor.myVisits')
                            : route('admin.visit.index');
                    @endphp
                    <form method="GET" action="{{ $action }}">
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
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="waiting"     {{ request('status') === 'waiting'     ? 'selected' : '' }}>Waiting</option>
                                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Done</option>
                                    <option value="cancelled"   {{ request('status') === 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>

                            <div class="form-group col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-end">
                                <a href="{{ $action }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i>
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
                        <strong class="card-title">Visits List</strong>
                        <span class="badge badge-primary badge-pill">{{ $visits->total() }} Total</span>
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
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <th>Doctor</th>
                                    @endif
                                    <th>Receptionist</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th class="text-center" style="width:110px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($visits as $visit)
                                @php
                                    $patient = $visit->patient;
                                    $patientName  = $patient->name  ?? '—';
                                    $patientEmail = $patient->email ?? '—';
                                    $patientPhone = $patient->phone ?? '—';
                                @endphp
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ $visits->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Patient --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-3">
                                                <div class="avatar-img rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                                    <span class="h6 mb-0 text-primary">
                                                        {{ strtoupper(substr($patientName, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $patientName }}</strong>
                                                <br><small class="text-muted">#{{ str_pad($visit->id, 6, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Contact --}}
                                    <td>
                                        <div class="small"><i class="fe fe-mail mr-1 text-muted"></i>{{ $patientEmail }}</div>
                                        <div class="small"><i class="fe fe-phone mr-1 text-muted"></i>{{ $patientPhone }}</div>
                                    </td>

                                    {{-- Doctor --}}
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-2">
                                                @if($visit->doctor && $visit->doctor->image)
                                                    <img src="{{ asset('images/doctors/' . $visit->doctor->image) }}"
                                                         alt="{{ $visit->doctor->user->name }}"
                                                         class="avatar-img rounded-circle">
                                                @else
                                                    <div class="avatar-img rounded-circle bg-soft-info d-flex align-items-center justify-content-center">
                                                        <span class="small text-info font-weight-bold">
                                                            {{ strtoupper(substr($visit->doctor->user->name ?? 'D', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="small font-weight-bold">Dr. {{ $visit->doctor->user->name ?? 'N/A' }}</span>
                                                @if($visit->doctor && $visit->doctor->major)
                                                    <br><span class="badge badge-soft-primary" style="font-size:0.65rem">
                                                        {{ $visit->doctor->major->title }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endif

                                    {{-- Receptionist --}}
                                    <td>
                                        <span class="small">{{ $visit->receptionist->name ?? 'N/A' }}</span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'waiting'     => ['class' => 'badge-secondary', 'icon' => 'fe-clock'],
                                                'in_progress' => ['class' => 'badge-warning',   'icon' => 'fe-loader'],
                                                'done'        => ['class' => 'badge-success',   'icon' => 'fe-check-circle'],
                                                'cancelled'   => ['class' => 'badge-danger',    'icon' => 'fe-x-circle'],
                                            ];
                                            $cfg = $statusConfig[$visit->status] ?? ['class' => 'badge-secondary', 'icon' => 'fe-help-circle'];
                                        @endphp
                                        <span class="badge {{ $cfg['class'] }} px-2 py-1">
                                            <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $visit->status)) }}
                                        </span>
                                    </td>

                                    {{-- Notes --}}
                                    <td style="max-width: 180px;">
                                        <p class="small text-truncate mb-0" title="{{ $visit->notes ?? 'No notes' }}">
                                            {{ $visit->notes ?? 'No notes' }}
                                        </p>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @can('view_patients')
                                            <a href="{{ route('admin.visit.show', $visit) }}"
                                               class="btn btn-sm btn-outline-info"
                                               data-toggle="tooltip" title="View">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            @endcan

                                            @can('edit_patients')
                                            <a href="{{ route('admin.visit.edit', $visit) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               data-toggle="tooltip" title="Edit">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            @endcan

                                            @can('delete_patients')
                                            <form action="{{ route('admin.visit.destroy', $visit) }}"
                                                  method="POST"
                                                  id="delete-form-{{ $visit->id }}"
                                                  class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                        onclick="confirmDelete({{ $visit->id }}, '{{ addslashes($patientName) }}')"
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-toggle="tooltip" title="Archive">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist')) ? '8' : '7' }}"
                                        class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fe fe-folder-minus fe-24 mb-3"></i>
                                            <p class="mb-0">No visit records found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($visits->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $visits->firstItem() }} to {{ $visits->lastItem() }}
                            of {{ $visits->total() }} records
                        </small>
                        {{ $visits->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
        You don't have permission to view visits.
    </div>
@endcan

@endsection

@push('styles')
<style>
.avatar-sm { width: 36px; height: 36px; }
.avatar-img { width: 100%; height: 100%; object-fit: cover; }
.bg-soft-primary { background-color: rgba(27,104,255,0.1); }
.bg-soft-info    { background-color: rgba(23,162,184,0.1); }
.badge-soft-primary { color: #1b68ff; background-color: rgba(27,104,255,0.1); }
.table-hover tbody tr:hover { background-color: rgba(0,0,0,0.02); }
.text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
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

function confirmDelete(id, patientName) {
    Swal.fire({
        title: 'Archive Visit?',
        html: 'Visit will be moved to archives!<br><br><strong>Patient:</strong> ' + patientName,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6e7881',
        confirmButtonText: 'Yes, Archive it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then(function (result) {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush