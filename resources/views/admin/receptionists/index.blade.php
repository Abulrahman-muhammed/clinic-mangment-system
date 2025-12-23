@extends('admin.master')

@section('title', 'Receptionists')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Receptionists</h2>
                
                <!-- Add Receptionist Button -->
                @can('create_receptionists')
                    <div class="page-title-right">
                        <a href="{{ route('admin.receptionist.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Receptionist
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
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($receptionists->count() > 0)
                                @foreach ($receptionists as $index => $receptionist)
                                    <tr>
                                        <td>{{ $receptionists->firstItem() + $loop->index }}</td>

                                        <!-- Image -->
                                        <td>
                                            @if($receptionist->image)
                                                <img src="{{ asset('images/receptionists/' . $receptionist->image) }}"
                                                     alt="Receptionist Image"
                                                     width="45" height="45"
                                                     class="rounded-circle border shadow-sm">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>

                                        <!-- User Info -->
                                        <td>{{ $receptionist->user->name ?? '-' }}</td>
                                        <td>{{ $receptionist->user->email ?? '-' }}</td>
                                        <td>{{ $receptionist->user->phone ?? '-' }}</td>

                                        <!-- Receptionist Details -->
                                        <td>{{ $receptionist->address ?? '-' }}</td>
                                        <td>{{ ucfirst($receptionist->shift) ?? '-' }}</td>
                                        <td>
                                            @if($receptionist->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            @can('edit_receptionists')
                                                <a href="{{ route('admin.receptionist.edit', $receptionist) }}" 
                                                   class="btn btn-sm btn-success me-1">
                                                    <i class="fe fe-edit-2"></i>
                                                </a>
                                            @endcan

                                            @can('delete_receptionists')
                                                <form action="{{ route('admin.receptionist.destroy', $receptionist) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this receptionist?')">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        No Receptionists found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $receptionists->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
