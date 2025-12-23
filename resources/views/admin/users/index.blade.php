@extends('admin.master')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Users</h2>

                @can('create_users')
                    <div class="page-title-right">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add User
                        </a>
                    </div>
                @endcan
            </div>

            <!-- Main Card -->
            <div class="card shadow">
                <div class="card-body">

                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count() > 0)
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $loop->index }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ Str::ucfirst($user->roles->pluck('name')->first()) }}</td>
                                        <td>
                                            @can('edit_users')
                                                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-sm btn-success">
                                                    <i class="fe fe-edit-2 fa-2x"></i>
                                                </a>
                                            @endcan

                                            @can('delete_users')
                                                @if (auth()->user()->id != $user->id)
                                                    <form action="{{ route('admin.user.destroy', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="fe fe-trash-2 fa-2x"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No users found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
