@extends('admin.master')

@section('title', 'Doctor Schedules')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Doctor Schedules</h2>
                    <p class="text-muted">Manage weekly availability and shifts for clinic doctors</p>
                </div>
                <div class="col-auto">
                    @can('create_schedules')
                    <a href="{{ route('admin.schedule.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add New Schedule
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    @php
                     $action  = auth()->user()->hasRole('doctor') ? route('admin.doctor.mySchedule') : route('admin.schedule.index');
                    @endphp
                    <form method="GET" action="{{ $action }}">

                        <div class="form-row">
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                            <div class="form-group col-md-4">
                                <label for="search">Doctor Name</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search by name...">
                            </div>
                            @endif
                            <div class="form-group col-md-4">
                                <label for="day">Day of Week</label>
                                <select name="day" id="day" class="form-control select2">
                                    <option value="">All Days</option>
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
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
                                @if(auth()->user()->hasRole('doctor'))
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ route('admin.doctor.mySchedule') }}'">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </button>
                                @else
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ route('admin.schedule.index') }}'">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Schedules List</strong>
                        <span class="badge badge-primary badge-pill">{{ $schedules->total() }} Total Shifts</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- success message -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Doctor Name</th>
                                    <th>Working Day</th>
                                    <th>Shift Hours</th>
                                    <th class="text-center" style="width: 150px;">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="text-center">{{ $schedules->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-light d-flex align-items-center justify-content-center border">
                                                        <i class="fe fe-user text-muted"></i>
                                                    </div>
                                                </div>
                                                <strong>{{ $schedule->doctor->user->name ?? 'N/A' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info px-3">{{ $schedule->day_of_week }}</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="fe fe-clock mr-1 text-success"></i> {{ $schedule->start_time }} 
                                                <span class="text-muted mx-1">to</span> 
                                                <i class="fe fe-clock mr-1 text-danger"></i> {{ $schedule->end_time }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('edit_schedules')
                                                <a href="{{ route('admin.schedule.edit', $schedule->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_schedules')
                                                <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-calendar fe-24 mb-3"></i>
                                                <p class="mb-0">No schedules found for the selected filters.</p>
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
                            Showing {{ $schedules->firstItem() }} to {{ $schedules->lastItem() }} of {{ $schedules->total() }} entries
                        </div>
                        <div>
                            {{ $schedules->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-soft-info { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    thead.thead-light th {
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () { $('[data-toggle="tooltip"]').tooltip() })
</script>
@endpush