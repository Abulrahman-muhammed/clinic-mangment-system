@extends('admin.master')

@section('title', 'Archived Users')

@section('content')

@can('delete_users')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Users</h2>
                    <p class="text-muted">View and manage archived system users</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Users
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
                    <form method="GET" action="{{ route('admin.user.trashed') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="search">Name / Email / Phone</label>
                                <input type="text" name="search" id="search"
                                       class="form-control"
                                       value="{{ request('search') }}"
                                       placeholder="Search by name, email, or phone...">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">All Roles</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ Str::ucfirst($role->name) }}
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
                                <a href="{{ route('admin.user.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Users Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Users List</strong>
                        <span class="badge badge-warning badge-pill">{{ $users->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>User Info</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Archived On</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    @php
                                        $role = $user->roles->pluck('name')->first();
                                        $roleConfig = [
                                            'admin'        => ['class' => 'badge-soft-danger',  'icon' => 'fe-shield'],
                                            'doctor'       => ['class' => 'badge-soft-success', 'icon' => 'fe-activity'],
                                            'receptionist' => ['class' => 'badge-soft-info',    'icon' => 'fe-headphones'],
                                        ];
                                        $cfg = $roleConfig[$role] ?? ['class' => 'badge-soft-secondary', 'icon' => 'fe-user'];
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted small">{{ $users->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <span class="avatar-title rounded-circle bg-soft-warning text-warning font-weight-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="font-weight-bold text-muted">{{ $user->name }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-phone mr-1"></i>
                                                {{ $user->phone ?? 'N/A' }}
                                            </small>
                                        </td>

                                        <td>
                                            <span class="badge badge-pill {{ $cfg['class'] }} px-3" style="opacity: 0.75;">
                                                <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                                {{ Str::ucfirst($role ?? 'No Role') }}
                                            </span>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $user->deleted_at->format('d M, Y') }}<br>
                                                <span style="font-size: 0.7rem;">
                                                    {{ $user->deleted_at->diffForHumans() }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore -->
                                                <form action="{{ route('admin.user.restore', $user->id) }}"
                                                      method="POST"
                                                      id="restore-form-{{ $user->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmRestore({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ Str::ucfirst($role ?? 'No Role') }}')"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-toggle="tooltip" title="Restore User">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                                <!-- Permanent Delete -->
                                                <form action="{{ route('admin.user.forceDelete', $user->id) }}"
                                                      method="POST"
                                                      id="force-delete-form-{{ $user->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmPermanentDelete({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ Str::ucfirst($role ?? 'No Role') }}')"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" title="Delete Permanently">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived users found.</p>
                                                <a href="{{ route('admin.user.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Users
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($users->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} archived users
                        </small>
                        {{ $users->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
        You don't have permission to view archived users.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm { width: 36px; height: 36px; line-height: 36px; font-size: 13px; }
    .avatar-title { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .bg-soft-warning   { background-color: rgba(255, 193,   7, 0.1); }
    .badge-soft-danger    { background-color: rgba(220,  53,  69, 0.1); color: #dc3545; }
    .badge-soft-success   { background-color: rgba(40,  167,  69, 0.1); color: #28a745; }
    .badge-soft-info      { background-color: rgba(23,  162, 184, 0.1); color: #17a2b8; }
    .badge-soft-secondary { background-color: rgba(108, 117, 125, 0.1); color: #6c757d; }
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
    });

    function confirmRestore(id, name, role) {
        Swal.fire({
            title: 'Restore User?',
            html:  "<strong>" + name + "</strong> will be restored!<br>" +
                   "<small class='text-muted'>Role: " + role + "</small>",
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

    function confirmPermanentDelete(id, name, role) {
        Swal.fire({
            title: 'Permanently Delete?',
            html:  "<strong class='text-danger'>" + name + "</strong> will be permanently deleted!<br>" +
                   "<small class='text-muted'>Role: " + role + "</small><br><br>" +
                   "<small class='text-danger'>This action cannot be undone!</small>",
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