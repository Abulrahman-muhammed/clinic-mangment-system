@extends('admin.master')

@section('title', 'doctors')

@section('content')

@can('view_doctors')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 page-title">Doctors</h2>

                @can('create_doctors')
                <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Doctor
                </a>
                @endcan
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Experience</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doctors as $index => $doctor)
                                <tr>
                                    <td>{{ $doctors->firstItem() + $loop->index }}</td>

                                    <td>
                                        @if($doctor->image)
                                            <img src="{{ asset('images/doctors/' . $doctor->image) }}" width="50" height="50" class="rounded-circle" alt="Doctor">
                                        @else
                                            <img src="{{ asset('admin-assets/img/default-doctor.png') }}" width="50" height="50" class="rounded-circle" alt="Default">
                                        @endif
                                    </td>

                                    <td>{{ $doctor->user->name }}</td>
                                    <td>{{ ucfirst($doctor->gender ?? '-') }}</td>
                                    <td>{{ $doctor->major?->title ?? '-' }}</td>
                                    <td>{{ $doctor->years_of_experience ?? 0 }}</td>

                                    <td>
                                        @if($doctor->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        @can('edit_doctors')
                                        <a href="{{ route('admin.doctor.edit', $doctor) }}" class="btn btn-sm btn-success">
                                            <i class="fe fe-edit-2"></i>
                                        </a>
                                        @endcan

                                        @can('view_doctors')
                                        <a href="{{ route('admin.doctor.show', $doctor) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        @endcan

                                        @can('delete_doctors')
                                        <form action="{{ route('admin.doctor.destroy', $doctor) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this doctor?')">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted py-4">
                                        No doctors found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $doctors->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection
