@extends('admin.master')

@section('title', 'Archived Visits')

@section('content')

@can('delete_patients')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Visits</h2>
                    <p class="text-muted">View and manage archived visit records</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.visit.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Visits
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

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
                    <form method="GET" action="{{ route('admin.visit.trashed') }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Search</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ request('search') }}" placeholder="Patient or Doctor name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                                    <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                                <a href="{{ route('admin.visit.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Visits Table -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Visits List</strong>
                        <span class="badge badge-warning badge-pill px-3">{{ $visits->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Archived Date</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($visits as $visit)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $visits->firstItem() + $loop->index }}</td>

                                        <!-- Patient -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-soft-warning d-flex align-items-center justify-content-center">
                                                        <span class="h6 mb-0 text-warning">{{ substr($visit->patient->name ?? '?', 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong>{{ $visit->patient->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $visit->patient->phone ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Doctor -->
                                        <td>
                                            <strong class="d-block small">Dr. {{ $visit->doctor->user->name ?? 'N/A' }}</strong>
                                            <small class="text-muted">{{ $visit->doctor->major->name ?? 'General' }}</small>
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @php
                                                $statusColor = match($visit->status) {
                                                    'done' => 'success',
                                                    'in_progress'    =>'info',
                                                    'cancelled' => 'danger',
                                                    default     => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $statusColor }} px-2">
                                                {{ ucfirst($visit->status) }}
                                            </span>
                                        </td>

                                        <!-- Notes -->
                                        <td style="max-width: 180px;">
                                            <p class="small text-truncate mb-0" title="{{ $visit->notes ?? 'No notes' }}">
                                                {{ $visit->notes ?? 'No notes' }}
                                            </p>
                                        </td>

                                        <!-- Archived Date -->
                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $visit->deleted_at ? $visit->deleted_at->format('d M, Y') : 'N/A' }}<br>
                                                <span style="font-size: 0.7rem;">
                                                    {{ $visit->deleted_at ? $visit->deleted_at->diffForHumans() : '' }}
                                                </span>
                                            </small>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('admin.visit.restore', $visit->id) }}"
                                                      method="POST"
                                                      id="restore-form-{{ $visit->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmRestore({{ $visit->id }}, '{{ addslashes($visit->patient->name ?? 'this visit') }}')"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-toggle="tooltip"
                                                            title="Restore Visit">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived visits found.</p>
                                                <a href="{{ route('admin.visit.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Visits
                                                </a>
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
                        <span class="text-muted small">
                            Showing {{ $visits->firstItem() }} to {{ $visits->lastItem() }} of {{ $visits->total() }} archived records
                        </span>
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
        You don't have permission to view archived visits.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm { width: 32px; height: 32px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-warning  { background-color: rgba(255, 193, 7, 0.1); }
    .badge-soft-success  { color: #28a745; background-color: rgba(40, 167, 69, 0.1); }
    .badge-soft-info     { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    .badge-soft-warning  { color: #ffc107; background-color: rgba(255, 193, 7, 0.1); }
    .badge-soft-danger   { color: #dc3545; background-color: rgba(220, 53, 69, 0.1); }
    .badge-soft-secondary{ color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    thead.thead-light th { text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.05em; }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        if ($.fn.select2) {
            $('.select2').select2({ theme: 'bootstrap4' });
        }
    });

    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Visit?',
            text: "Visit for '" + name + "' will be restored to active visits!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Restore!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restore-form-' + id).submit();
            }
        });
    }

    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush