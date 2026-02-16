@extends('admin.master')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Users Management</h2>
                    <p class="text-muted">Manage system administrators, doctors, and staff members.</p>
                </div>
                <div class="col-auto">
                    @can('create_users')
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus mr-1"></i> Add New User
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.user.index') }}">
                        <div class="form-row align-items-end">
                            <div class="col">
                                <label for="search" class="sr-only">Search</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fe fe-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="search" id="search" class="form-control border-left-0" 
                                           value="{{ request('search') }}" placeholder="Search by name, email, or phone number...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary px-4">Search</button>
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body p-0">

                    @if(session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4" width="5%">#</th>
                                    <th>User Info</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th class="text-right pr-4" width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="align-middle">
                                        <td class="pl-4 text-muted">{{ $users->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="h6 mb-0">{{ $user->name }}</span><br>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="small"><i class="fe fe-phone mr-1"></i> {{ $user->phone ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @php $role = $user->roles->pluck('name')->first(); @endphp
                                            <span class="badge badge-pill {{ $role == 'admin' ? 'badge-soft-danger' : 'badge-soft-info' }} px-3">
                                                {{ Str::ucfirst($role ?? 'No Role') }}
                                            </span>
                                        </td>
                                        <td class="text-right pr-4">
                                            <div class="btn-group">
                                                @can('edit_users')
                                                    <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-outline-success mr-2">
                                                        <i class="fe fe-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('delete_users')
                                                    @if (auth()->user()->id != $user->id)
                                                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="fe fe-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-users fe-32 mb-3"></i>
                                                <p>No users found matching your search.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($users->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</small>
                            {{ $users->links('pagination::bootstrap-5') }}
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
    .badge-soft-danger { background-color: rgba(233, 30, 99, 0.1); color: #e91e63; }
    .badge-soft-info { background-color: rgba(0, 188, 212, 0.1); color: #00bcd4; }
    .badge-soft-primary { background-color: rgba(60, 114, 252, 0.1); color: #3c72fc; }
    .avatar-sm { width: 32px; height: 32px; line-height: 32px; font-size: 12px; }
</style>
@endpush