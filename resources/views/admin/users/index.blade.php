@extends('admin.master')

@section('title', 'Users Management')

@section('content')

@can('view_users')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Users Management</h2>
                    <p class="text-muted">Manage system administrators, doctors, and staff members</p>
                </div>
                <div class="col-auto">
                    @can('create_users')
                    <a href="{{ route('admin.user.create') }}" class="btn btn-outline-primary">
                        <i class="fe fe-plus mr-1"></i> Add New User
                    </a>
                    @endcan
                    <a href="{{ route('admin.user.trashed') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-archive mr-1"></i> Archived Users
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
                    <form method="GET" action="{{ route('admin.user.index') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="search">Name / Email / Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fe fe-search text-muted"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="search" id="search"
                                           class="form-control border-left-0"
                                           value="{{ request('search') }}"
                                           placeholder="Search by name, email, or phone...">
                                </div>
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
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Users List</strong>
                        <span class="badge badge-primary badge-pill">{{ $users->total() }} Total</span>
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
                                    <th class="text-center" style="width: 130px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
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
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary font-weight-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="font-weight-bold text-dark">{{ $user->name }}</span>
                                                    @if($user->id === auth()->id())
                                                        <span class="badge badge-soft-warning ml-1" style="font-size: 0.6rem;">You</span>
                                                    @endif
                                                    <br>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <small>
                                                <i class="fe fe-phone mr-1 text-muted"></i>
                                                {{ $user->phone ?? 'N/A' }}
                                            </small>
                                        </td>

                                        <td>
                                            <span class="badge badge-pill {{ $cfg['class'] }} px-3">
                                                <i class="fe {{ $cfg['icon'] }} mr-1"></i>
                                                @if($user->role=='user')
                                                    {{"User"}}
                                                @else
                                                {{ Str::ucfirst($role ?? 'No Role') }}
                                                @endif
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            {{--if user has role not doctor or receptionist, disable edit and delete buttons --}}
                                            @if(!($user->hasRole('doctor') || $user->hasRole('receptionist')))

                                                <div class="btn-group" role="group">
                                                    @can('edit_users')
                                                    <a href="{{ route('admin.user.edit', $user) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-toggle="tooltip" title="Edit User">
                                                        <i class="fe fe-edit"></i>
                                                    </a>
                                                    @endcan

                                                    @can('delete_users')
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('admin.user.destroy', $user) }}"
                                                            method="POST"
                                                            id="delete-form-{{ $user->id }}"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                    onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ Str::ucfirst($role ?? 'No Role') }}')"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    data-toggle="tooltip" title="Delete User">
                                                                <i class="fe fe-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary"
                                                                disabled
                                                                data-toggle="tooltip"
                                                                title="You cannot delete your own account">
                                                            <i class="fe fe-lock"></i>
                                                        </button>
                                                    @endif
                                                    @endcan
                                                </div>

                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-users fe-24 mb-3"></i>
                                                <p class="mb-0">No users found matching your search.</p>
                                                @can('create_users')
                                                <a href="{{ route('admin.user.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First User
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

                @if($users->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
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
        You don't have permission to view users.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm       { width: 36px; height: 36px; line-height: 36px; font-size: 13px; }
    .avatar-title    { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
    .bg-soft-primary { background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-danger    { background-color: rgba(220,  53,  69, 0.1); color: #dc3545; }
    .badge-soft-success   { background-color: rgba(40,  167,  69, 0.1); color: #28a745; }
    .badge-soft-info      { background-color: rgba(23,  162, 184, 0.1); color: #17a2b8; }
    .badge-soft-warning   { background-color: rgba(255, 193,   7, 0.1); color: #d49a00; }
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

    function confirmDelete(id, name, role) {
        Swal.fire({
            title: 'Archive User?',
            html:  "<strong>" + name + "</strong> will be Archived!<br>" +
                   "<small class='text-muted'>Role: " + role + "</small><br><br>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Archive!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,

        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush