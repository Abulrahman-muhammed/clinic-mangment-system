@extends('admin.master')

@section('title', 'Roles')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Roles</h2>

                @can('create_roles')
                    <div class="page-title-right">
                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Role
                        </a>
                    </div>
                @endcan
            </div>

            <!-- Main Card -->
            <div class="card shadow">
                <div class="card-body">

                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <table class="table table-hover align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Permissions Count</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->count() > 0)
                                @foreach ($roles as $index => $role)
                                    <tr>
                                        <td>{{ $roles->firstItem() + $loop->index }}</td>
                                        <td class="fw-semibold">{{ ucfirst($role->name) }}</td>
                                        <td>{{ $role->permissions->count() }}</td>
                                        <td>
                                            @can('view_roles')
                                                <a href="{{ route('admin.role.show', $role->id) }}" 
                                                   class="btn btn-sm btn-info text-white">
                                                    <i class="fe fe-eye fa-2x"></i>
                                                </a>
                                            @endcan

                                            @can('edit_roles')
                                                <a href="{{ route('admin.role.edit', $role->id) }}" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="fe fe-edit-2 fa-2x"></i>
                                                </a>
                                            @endcan

                                            @can('delete_roles')
                                                <form action="{{ route('admin.role.destroy', $role->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                                        <i class="fe fe-trash-2 fa-2x"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No roles found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $roles->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
