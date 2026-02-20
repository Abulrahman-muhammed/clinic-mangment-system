@extends('admin.master')

@section('title', 'Archived Schedules')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title text-primary">Archived Schedules</h2>
                    <p class="text-muted">Manage doctor schedules that have been soft-deleted.</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Schedules
                    </a>
                </div>
            </div>
            <!-- success message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- error message -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Search Archive</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.schedule.trashed') }}">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-5 mb-0">
                                <label for="search">Doctor Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i class="fe fe-search"></i></span>
                                    </div>
                                    <input type="text" name="search" id="search" class="form-control border-left-0" 
                                           value="{{ request('search') }}" placeholder="Search by doctor...">
                                </div>
                            </div>

                            <div class="form-group col-md-3 mb-0">
                                <label for="day">Day of Week</label>
                                <select name="day" id="day" class="form-control select2">
                                    <option value="">All Days</option>
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4 mb-0">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fe fe-filter mr-1"></i> Filter</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('admin.schedule.trashed') }}" class="btn btn-secondary btn-block"><i class="fe fe-rotate-ccw mr-1"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived List</strong>
                        <span class="badge badge-warning badge-pill px-3">{{ $schedules->total() }} Schedules Found</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Doctor</th>
                                    <th>Department</th>
                                    <th>Schedule Details</th>
                                    <th>Archived At</th>
                                    <th class="text-right pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr class="align-middle">
                                        <td class="text-center text-muted small">{{ $schedules->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <img src="{{ asset('images/doctors/' . ($schedule->doctor->image ?? 'default.png')) }}" 
                                                         class="avatar-img rounded-circle grayscale" style="width: 40px; height: 40px; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <strong class="d-block text-dark">{{ $schedule->doctor->user->name ?? 'N/A' }}</strong>
                                                    <small class="text-muted">{{ $schedule->doctor->user->email ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary">{{ $schedule->doctor->major->title ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <span class="badge badge-soft-info"><i class="fe fe-calendar mr-1"></i>{{ $schedule->day_of_week }}</span>
                                            </div>
                                            <small class="text-dark font-weight-bold">{{ $schedule->formatted_start_time ?? $schedule->start_time }}</small>
                                            <i class="fe fe-arrow-right text-muted mx-1"></i>
                                            <small class="text-dark font-weight-bold">{{ $schedule->formatted_end_time ?? $schedule->end_time }}</small>
                                        </td>
                                        <td>
                                            <span class="small text-muted">{{ $schedule->deleted_at->format('d M, Y') }}</span><br>
                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $schedule->deleted_at->diffForHumans() }}</small>
                                        </td>
                                        <td class="text-right pr-4">
                                            <div class="btn-group">
                                                {{-- Restore --}}
                                                <form action="{{ route('admin.schedule.restore', $schedule->id) }}" method="POST" id="restore-form-{{ $schedule->id }}" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <button type="button" class="btn btn-sm btn-outline-success mr-1" 
                                                            onclick="confirmRestore({{ $schedule->id }}, '{{ addslashes($schedule->doctor->user->name ?? 'Doctor') }}')"
                                                            data-toggle="tooltip" title="Restore">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fe fe-archive fe-32 text-muted mb-3 d-block"></i>
                                            <p class="text-muted">No archived schedules found matching your filters.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($schedules->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Showing {{ $schedules->firstItem() }} to {{ $schedules->lastItem() }}</span>
                        {{ $schedules->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    .grayscale { filter: grayscale(100%); opacity: 0.6; transition: 0.3s; }
    tr:hover .grayscale { filter: grayscale(0%); opacity: 1; }
    .badge-soft-primary { color: #1b68ff; background-color: rgba(27, 104, 255, 0.1); }
    .badge-soft-info { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    .thead-light th { text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; font-weight: 700; color: #6c757d; }
</style>
@endpush

@push('scripts')
<script>
    $(function () { 
        $('[data-toggle="tooltip"]').tooltip();
        if ($.fn.select2) { $('.select2').select2({ theme: 'bootstrap4' }); }
    });

    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Schedule?',
            text: `Are you sure you want to restore the schedule for Dr. ${name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, Restore'
        }).then((result) => { if (result.isConfirmed) document.getElementById(`restore-form-${id}`).submit(); });
    }

    function confirmPermanentDelete(id, name) {
        Swal.fire({
            title: 'Permanent Delete?',
            text: `This will permanently delete the schedule for Dr. ${name}. You cannot undo this!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete Forever'
        }).then((result) => { if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit(); });
    }
</script>
@endpush