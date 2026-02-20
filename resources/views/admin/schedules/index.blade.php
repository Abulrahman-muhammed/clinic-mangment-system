@extends('admin.master')

@section('title', 'Doctor Schedules')

@section('content')

@can('view_schedules')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Doctor Schedules Management</h2>
                    <p class="text-muted">Manage weekly availability and shifts for clinic doctors</p>
                </div>
                <div class="col-auto">
                   <!-- Trashed button -->
                   @can('delete_schedules')
                   <a href="{{ route('admin.schedule.trashed') }}" class="btn btn-outline-secondary">
                       <i class="fe fe-trash mr-1"></i> Trashed Schedules
                   </a>
                   @endcan
                    @can('create_schedules')
                    <a href="{{ route('admin.schedule.create') }}" class="btn btn-outline-primary">
                        <i class="fe fe-plus mr-1"></i> Add New Schedule
                    </a>
                    @endcan

                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Filters Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    @php
                        $action = auth()->user()->hasRole('doctor') 
                            ? route('admin.doctor.mySchedule') 
                            : route('admin.schedule.index');
                    @endphp
                    <form method="GET" action="{{ $action }}" id="filter-form">
                        <div class="form-row">
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                            <div class="form-group col-md-4">
                                <label for="search">Doctor Name</label>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       class="form-control" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search by doctor name...">
                            </div>
                            @endif

                            <div class="form-group col-md-{{ auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist') ? '4' : '6' }}">
                                <label for="day">Day of Week</label>
                                <select name="day" id="day" class="form-control select2">
                                    <option value="">All Days</option>
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <a href="{{ $action }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Schedules Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Schedules List</strong>
                        <span class="badge badge-primary badge-pill">{{ $schedules->total() }} Total Shifts</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                    <th>Doctor</th>
                                    <th>Department</th>
                                    @endif
                                    <th>Working Day</th>
                                    <th>Shift Hours</th>
                                    <th class="text-center">Duration</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $schedules->firstItem() + $loop->index }}</td>
                                        
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    @if($schedule->doctor && $schedule->doctor->image)
                                                        <img src="{{ asset('images/doctors/' . $schedule->doctor->image) }}" 
                                                             alt="{{ $schedule->doctor->user->name ?? 'Doctor' }}" 
                                                             class="avatar-img rounded-circle">
                                                    @else
                                                        <div class="avatar-img rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                                            <i class="fe fe-user text-primary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong>{{ $schedule->doctor->user->name ?? 'N/A' }}</strong>
                                                    @if($schedule->doctor && $schedule->doctor->user)
                                                        <br><small class="text-muted">{{ $schedule->doctor->user->email }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if($schedule->doctor && $schedule->doctor->major)
                                                <span class="badge badge-soft-primary">{{ $schedule->doctor->major->title }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        @endif

                                        <td>
                                            <span class="badge badge-soft-info px-3">
                                                <i class="fe fe-calendar mr-1"></i>{{ $schedule->day_of_week }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-success mr-1">{{ $schedule->start_time }}</span>
                                                <i class="fe fe-arrow-right text-muted mx-1"></i>
                                                <span class="badge badge-danger">{{ $schedule->end_time }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            @php
                                                $start = \Carbon\Carbon::parse($schedule->start_time);
                                                $end = \Carbon\Carbon::parse($schedule->end_time);
                                                $duration = $start->diffInHours($end);
                                            @endphp
                                            <span class="badge badge-light">{{ $duration }} hrs</span>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('edit_schedules')
                                                <a href="{{ route('admin.schedule.edit', $schedule->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" 
                                                   title="Edit Schedule">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_schedules')
                                                <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" 
                                                      method="POST" 
                                                      id="delete-form-{{ $schedule->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDelete({{ $schedule->id }}, '{{ addslashes($schedule->doctor->user->name ?? 'this schedule') }}', '{{ $schedule->day_of_week }}', '{{ $schedule->start_time }}', '{{ $schedule->end_time }}')"
                                                            class="btn btn-sm btn-outline-danger" 
                                                            data-toggle="tooltip" 
                                                            title="Delete">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist') ? '7' : '5' }}" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-calendar fe-24 mb-3"></i>
                                                <p class="mb-0">No schedules found for the selected filters.</p>
                                                @can('create_schedules')
                                                <a href="{{ route('admin.schedule.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First Schedule
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($schedules->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $schedules->firstItem() }} to {{ $schedules->lastItem() }} of {{ $schedules->total() }} schedules
                        </div>
                        <div>
                            {{ $schedules->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                        </div>
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
        You don't have permission to view schedules.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bg-soft-primary {
        background-color: rgba(27, 104, 255, 0.1);
    }
    .bg-soft-info {
        color: #17a2b8;
        background-color: rgba(23, 162, 184, 0.1);
    }
    .badge-soft-info {
        color: #17a2b8;
        background-color: rgba(23, 162, 184, 0.1);
    }
    .badge-soft-primary {
        color: #1b68ff;
        background-color: rgba(27, 104, 255, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
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
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize Select2 if available
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select Day',
                allowClear: true
            });
        }
    });

    // SweetAlert Delete Confirmation
    function confirmDelete(id, doctorName, day, startTime, endTime) {
        Swal.fire({
            title: 'Delete Schedule?',
            html: "Are you sure you want to delete this schedule?<br><br>" +
                  "<strong>Doctor:</strong> " + doctorName + "<br>" +
                  "<strong>Day:</strong> " + day + "<br>" +
                  "<strong>Time:</strong> " + startTime + " - " + endTime,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush