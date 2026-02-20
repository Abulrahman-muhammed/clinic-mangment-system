@extends('admin.master')

@section('title', 'Archived Receptionists')

@section('content')

@can('delete_receptionists')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Receptionists</h2>
                    <p class="text-muted">View and manage archived front-desk staff</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.receptionist.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Receptionists
                    </a>
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
                    <form method="GET" action="{{ route('admin.receptionist.trashed') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="search">Name / Email</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ request('search') }}" placeholder="Search by name or email...">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="shift">Shift</label>
                                <select name="shift" id="shift" class="form-control select2">
                                    <option value="">All Shifts</option>
                                    <option value="morning" {{ request('shift') == 'morning' ? 'selected' : '' }}> Morning</option>
                                    <option value="evening" {{ request('shift') == 'evening' ? 'selected' : '' }}> Evening</option>
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
                                <a href="{{ route('admin.receptionist.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Receptionists Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Receptionists List</strong>
                        <span class="badge badge-warning badge-pill">{{ $receptionists->count() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th style="width: 70px;">Photo</th>
                                    <th>Receptionist</th>
                                    <th>Contact Info</th>
                                    <th>Shift</th>
                                    <th>Archived On</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($receptionists as $receptionist)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $receptionists->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="avatar avatar-md">
                                                @if($receptionist->image)
                                                    <img src="{{ asset('images/receptionists/' . $receptionist->image) }}"
                                                         alt="{{ $receptionist->name ?? 'Receptionist' }}"
                                                         class="avatar-img rounded-circle border shadow-sm opacity-50">
                                                @else
                                                    <div class="avatar-img rounded-circle bg-soft-warning d-flex align-items-center justify-content-center">
                                                        <span class="font-weight-bold text-warning">
                                                            {{ strtoupper(substr($receptionist->user->name ?? 'R', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <strong class="text-muted">{{ $receptionist->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fe fe-map-pin mr-1"></i>{{ $receptionist->address ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            <div class="small text-muted">
                                                <i class="fe fe-mail mr-1"></i>{{ $receptionist->user->email ?? '-' }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="fe fe-phone mr-1"></i>{{ $receptionist->user->phone ?? '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            @php
                                                $shiftConfig = [
                                                    'morning' => ['color' => 'success',   'icon' => 'fe-sun'],
                                                    'evening' => ['color' => 'warning',   'icon' => 'fe-sunset'],
                                                    'night'   => ['color' => 'secondary', 'icon' => 'fe-moon'],
                                                ];
                                                $cfg = $shiftConfig[$receptionist->shift] ?? ['color' => 'secondary', 'icon' => 'fe-clock'];
                                            @endphp
                                            <span class="badge badge-soft-{{ $cfg['color'] }} px-3" style="opacity: 0.75;">
                                                <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                                {{ ucfirst($receptionist->shift ?? 'N/A') }}
                                            </span>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $receptionist->deleted_at->format('d M, Y') }}<br>
                                                <span style="font-size: 0.7rem;">
                                                    {{ $receptionist->deleted_at->diffForHumans() }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore -->
                                                <form action="{{ route('admin.receptionist.restore', $receptionist->id) }}"
                                                      method="POST"
                                                      id="restore-form-{{ $receptionist->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmRestore({{ $receptionist->id }}, '{{ addslashes($receptionist->user->name ?? 'this receptionist') }}')"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-toggle="tooltip" title="Restore">
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
                                                <p class="mb-0">No archived receptionists found.</p>
                                                <a href="{{ route('admin.receptionist.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Receptionists
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($receptionists->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $receptionists->firstItem() }} to {{ $receptionists->lastItem() }} of {{ $receptionists->total() }} archived entries
                        </div>
                        {{ $receptionists->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
        You don't have permission to view archived receptionists.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md { width: 42px; height: 42px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-warning   { background-color: rgba(255, 193,   7, 0.1); }
    .bg-soft-primary   { background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-primary   { color: #1b68ff; background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-success   { color: #28a745; background-color: rgba(40,  167,  69, 0.1); }
    .badge-soft-warning   { color: #ffc107; background-color: rgba(255, 193,   7, 0.1); }
    .badge-soft-secondary { color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
    .opacity-50 { opacity: 0.5; }
    .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.02); }
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

    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Receptionist?',
            html:  "<strong>" + name + "</strong> will be moved back to active staff!",
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

    function confirmPermanentDelete(id, name) {
        Swal.fire({
            title: 'Permanently Delete?',
            html:  "<strong class='text-danger'>" + name + "</strong> will be permanently deleted!<br><br>" +
                   "<small class='text-muted'>This action cannot be undone!</small>",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Delete Forever!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            input: 'checkbox',
            inputPlaceholder: 'I understand this cannot be undone',
            inputValidator: (result) => {
                return !result && 'You must confirm to proceed'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('force-delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush