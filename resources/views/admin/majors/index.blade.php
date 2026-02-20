@extends('admin.master')

@section('title', 'Departments')

@section('content')

@can('view_departments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Departments Management</h2>
                    <p class="text-muted">Manage clinical departments and medical specializations</p>
                </div>
                <div class="col-auto">
                    @can('delete_departments')
                    <a href="{{ route('admin.major.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Departments
                    </a>
                    @endcan
                    
                    @can('create_departments')
                    <a href="{{ route('admin.major.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Department
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

            <!-- Search Card -->
<div class="card shadow mb-4">
    <div class="card-header">
        <strong class="card-title">Search Archived Departments</strong>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.major.trashed') }}" id="search-form">
            <div class="form-row align-items-end">
                {{-- خانة البحث --}}
                <div class="form-group col-md-7 mb-0">
                    <label for="search">Department Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0">
                                <i class="fe fe-search"></i>
                            </span>
                        </div>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               class="form-control border-left-0" 
                               value="{{ request('search') }}" 
                               placeholder="Search by department name...">
                    </div>
                </div>

                {{-- زراير التحكم --}}
                <div class="form-group col-md-5 mb-0">
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fe fe-search mr-1"></i> Search
                            </button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.major.index') }}" class="btn btn-secondary btn-block">
                                <i class="fe fe-rotate-ccw mr-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

            <!-- Departments Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Departments List</strong>
                        <span class="badge badge-primary badge-pill">{{ $majors->total() }} Total</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th style="width: 100px;">Image</th>
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Doctors</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($majors as $major)
                                    <tr>
                                        <td class="text-center">{{ $majors->firstItem() + $loop->index }}</td>
                                        
                                        <td>
                                            @if($major->image)
                                                <div class="avatar avatar-md">
                                                    <img src="{{ asset('images/majors/' . $major->image) }}" 
                                                         alt="{{ $major->title }}" 
                                                         class="avatar-img rounded shadow-sm"
                                                         onerror="this.src='{{ asset('images/majors/default.png') }}'">
                                                </div>
                                            @else
                                                <div class="avatar avatar-md">
                                                    <div class="avatar-img rounded bg-soft-primary d-flex align-items-center justify-content-center">
                                                        <i class="fe fe-briefcase text-primary"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $major->title }}</strong>
                                        </td>

                                        <td class="text-muted" style="max-width: 300px;">
                                            <p class="mb-0 text-truncate" title="{{ $major->description }}">
                                                {{ $major->description ? Str::limit($major->description, 60) : 'No description available' }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            @if($major->doctors->count() > 0)
                                                <span class="badge badge-info">{{ $major->doctors->count() }} doctors</span>
                                            @else
                                                <span class="text-muted small">No doctors</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">

                                                @can('edit_departments')
                                                <a href="{{ route('admin.major.edit', $major) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_departments')
                                                <form action="{{ route('admin.major.destroy', $major) }}" 
                                                      method="POST" 
                                                      id="delete-form-{{ $major->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDelete({{ $major->id }}, '{{ addslashes($major->title) }}', {{ $major->doctors->count() ?? 0 }})"
                                                            class="btn btn-sm btn-outline-danger" 
                                                            data-toggle="tooltip" 
                                                            title="Archive">
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
                                                <i class="fe fe-folder fe-24 mb-3"></i>
                                                <p class="mb-0">No departments found.</p>
                                                @can('create_departments')
                                                <a href="{{ route('admin.major.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First Department
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
                
                @if($majors->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $majors->firstItem() }} to {{ $majors->lastItem() }} of {{ $majors->total() }} departments
                        </div>
                        <div>
                            {{ $majors->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                        </div>
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
        You don't have permission to view departments.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md {
        width: 60px;
        height: 60px;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bg-soft-primary {
        background-color: rgba(27, 104, 255, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    thead.thead-light th {
        color: #6c757d;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // SweetAlert Delete Confirmation
    function confirmDelete(id, name, doctorsCount) {
        let warningText = "Department '" + name + "' will be moved to the archives!";
        
        if (doctorsCount > 0) {
            warningText = "This department has " + doctorsCount + " doctor(s) assigned to it. Are you sure you want to archive it?";
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: warningText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Archive it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush