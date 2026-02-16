@extends('admin.master')

@section('title', 'Departments')

@section('content')

@can('view_departments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Departments</h2>
                    <p class="text-muted">Manage clinical departments and medical specializations.</p>
                </div>
                <div class="col-auto">
                    @can('create_departments')
                    <a href="{{ route('admin.major.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Department
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.major.index') }}">
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
                                           value="{{ request('search') }}" placeholder="Search by name or description...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary px-4">Search</button>
                                <a href="{{ route('admin.major.index') }}" class="btn btn-secondary">Reset</a>
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
                                    <th class="pl-4">#</th>
                                    <th>Image</th>
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th class="text-right pr-4"> 
                                        @can('delete_departments' || 'edit_departments')
                                            Actions
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($majors as $major)
                                    <tr class="align-middle">
                                        <td class="pl-4">{{ $majors->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('images/majors/' . $major->image) }}" 
                                                     alt="{{ $major->title }}" 
                                                     class="avatar-img rounded shadow-sm"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="h6">{{ $major->title }}</span>
                                        </td>
                                        <td class="text-muted">
                                            {{ Str::limit($major->description, 50) }}
                                        </td>
                                        <td class="text-right pr-4">
                                            <div class="btn-group">
                                                @can('edit_departments')
                                                <a href="{{ route('admin.major.edit', $major) }}" class="btn btn-sm btn-outline-success mr-2">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_departments')
                                                <form action="{{ route('admin.major.destroy', $major) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this department?')">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-folder fe-32 mb-3"></i>
                                                <p>No departments found matching your criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> @if($majors->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $majors->firstItem() }} to {{ $majors->lastItem() }} of {{ $majors->total() }} departments
                        </small>
                        {{ $majors->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div> </div>
    </div>
</div>
@endcan

@endsection