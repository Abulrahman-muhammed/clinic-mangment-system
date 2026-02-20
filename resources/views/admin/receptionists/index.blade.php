@extends('admin.master')

@section('title', 'Receptionists')

@section('content')

@can('view_receptionists')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Receptionists Management</h2>
                    <p class="text-muted">Manage all front-desk staff and their shifts</p>
                </div>
                <div class="col-auto">
                    @can('delete_receptionists')
                    <a href="{{ route('admin.receptionist.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Receptionists
                    </a>
                    @endcan

                    @can('create_receptionists')
                    <a href="{{ route('admin.receptionist.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Receptionist
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
                    <form method="GET" action="{{ route('admin.receptionist.index') }}" id="filter-form">
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
                                <a href="{{ route('admin.receptionist.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Receptionists Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Receptionists List</strong>
                        <span class="badge badge-primary badge-pill">{{ $receptionists->count() }} Total</span>
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
                                    <th class="text-center" style="width: 150px;">Actions</th>
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
                                                         alt="{{ $receptionist->user->name ?? 'Receptionist' }}"
                                                         class="avatar-img rounded-circle border shadow-sm">
                                                @else
                                                    <div class="avatar-img rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                                        <span class="font-weight-bold text-primary">
                                                            {{ strtoupper(substr($receptionist->user->name ?? 'R', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <strong>{{ $receptionist->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fe fe-map-pin mr-1"></i>{{ $receptionist->address ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            <div class="small">
                                                <i class="fe fe-mail mr-1 text-muted"></i>{{ $receptionist->user->email ?? '-' }}
                                            </div>
                                            <div class="small">
                                                <i class="fe fe-phone mr-1 text-muted"></i>{{ $receptionist->user->phone ?? '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            @php
                                                $shiftConfig = [
                                                    'morning' => ['color' => 'success',   'icon' => 'fe-sun'],
                                                    'evening' => ['color' => 'warning',   'icon' => 'fe-sunset'],
                                                    'night'   => ['color' => 'secondary', 'icon' => 'fe-moon'],
                                                ];
                                                $cfg = $shiftConfig[$receptionist->shift] ?? ['color' => 'primary', 'icon' => 'fe-clock'];
                                            @endphp
                                            <span class="badge badge-soft-{{ $cfg['color'] }} px-3">
                                                <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                                {{ ucfirst($receptionist->shift ?? 'N/A') }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('edit_receptionists')
                                                <a href="{{ route('admin.receptionist.edit', $receptionist) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_receptionists')
                                                <form action="{{ route('admin.receptionist.destroy', $receptionist) }}"
                                                      method="POST"
                                                      id="delete-form-{{ $receptionist->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete({{ $receptionist->id }}, '{{ addslashes($receptionist->user->name ?? 'this receptionist') }}', '{{ $receptionist->shift ?? '' }}')"
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
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-users fe-24 mb-3"></i>
                                                <p class="mb-0">No receptionists found.</p>
                                                @can('create_receptionists')
                                                <a href="{{ route('admin.receptionist.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First Receptionist
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

                @if($receptionists->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $receptionists->firstItem() }} to {{ $receptionists->lastItem() }} of {{ $receptionists->total() }} entries
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
        You don't have permission to view receptionists.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md { width: 42px; height: 42px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-primary   { background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-primary   { color: #1b68ff; background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-success   { color: #28a745; background-color: rgba(40,  167,  69, 0.1); }
    .badge-soft-warning   { color: #ffc107; background-color: rgba(255, 193,   7, 0.1); }
    .badge-soft-secondary { color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
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

    function confirmDelete(id, name, shift) {
        Swal.fire({
            title: 'Archive Receptionist?',
            html:  "<strong>" + name + "</strong> will be moved to archives!" +
                   (shift ? "<br><small class='text-muted'>Shift: " + shift.charAt(0).toUpperCase() + shift.slice(1) + "</small>" : ""),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Archive!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush