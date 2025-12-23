@extends('admin.master')

@section('title', 'Departments')

@section('content')

@can('view_departments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Departments</h2>

                @can('create_departments')
                <div class="page-title-right">
                    <a href="{{ route('admin.major.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Department
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
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($majors->count() > 0)
                                @foreach ($majors as $index => $major)
                                    <tr>
                                        <td>{{ $majors->firstItem() + $loop->index }}</td>
                                        <td>{{ $major->title }}</td>
                                        <td>{{ $major->description }}</td>
                                        <td>
                                            <img src="{{ asset('images/majors/' . $major->image) }}" 
                                                 alt="Department image" width="60" height="60" 
                                                 class="rounded object-fit-cover">
                                        </td>
                                        <td>
                                            @can('edit_departments')
                                            <a href="{{ route('admin.major.edit', $major) }}" 
                                               class="btn btn-sm btn-success">
                                                <i class="fe fe-edit-2 fa-2x"></i>
                                            </a>
                                            @endcan

                                            @can('delete_departments')
                                            <form action="{{ route('admin.major.destroy', $major) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this major?')">
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
                                        No Department found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $majors->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection
