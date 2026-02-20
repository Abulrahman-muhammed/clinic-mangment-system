@extends('admin.master')

@section('title', 'Archived Departments')

@section('content')

@can('delete_departments')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Departments</h2>
                    <p class="text-muted">View and manage archived departments</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.major.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Departments
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
                            <a href="{{ route('admin.major.trashed') }}" class="btn btn-secondary btn-block">
                                <i class="fe fe-rotate-ccw mr-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

            <!-- Archived Departments Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Departments List</strong>
                        <span class="badge badge-warning badge-pill">{{ $majors->total() }} Archived</span>
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
                                    <th>Archived Date</th>
                                    <th class="text-center" style="width: 140px;">Actions</th>
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
                                                         class="avatar-img rounded shadow-sm opacity-50"
                                                         onerror="this.src='{{ asset('admin-assets/img/default-department.png') }}'">
                                                </div>
                                            @else
                                                <div class="avatar avatar-md">
                                                    <div class="avatar-img rounded bg-soft-warning d-flex align-items-center justify-content-center">
                                                        <i class="fe fe-briefcase text-warning"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $major->title }}</strong>
                                        </td>

                                        <td class="text-muted" style="max-width: 250px;">
                                            <p class="mb-0 text-truncate small" title="{{ $major->description }}">
                                                {{ $major->description ? Str::limit($major->description, 50) : 'No description' }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            @if($major->doctors_count > 0)
                                                <span class="badge badge-warning">{{ $major->doctors_count }} doctors</span>
                                            @else
                                                <span class="text-muted small">No doctors</span>
                                            @endif
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $major->deleted_at ? $major->deleted_at->format('d M, Y') : 'N/A' }}<br>
                                                <span class="text-muted" style="font-size: 0.7rem;">
                                                    {{ $major->deleted_at ? $major->deleted_at->diffForHumans() : '' }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore Button -->
                                                <form action="{{ route('admin.major.restore', $major->id) }}" 
                                                      method="POST" 
                                                      id="restore-form-{{ $major->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" 
                                                            onclick="confirmRestore({{ $major->id }}, '{{ addslashes($major->title) }}')"
                                                            class="btn btn-sm btn-outline-success" 
                                                            data-toggle="tooltip" 
                                                            title="Restore Department">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived departments found.</p>
                                                <a href="{{ route('admin.major.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Departments
                                                </a>
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
                            Showing {{ $majors->firstItem() }} to {{ $majors->lastItem() }} of {{ $majors->total() }} archived departments
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
        You don't have permission to view archived departments.
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
    .bg-soft-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .opacity-50 {
        opacity: 0.5;
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

    // SweetAlert Restore Confirmation
    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Department?',
            text: "Department '" + name + "' will be restored to active departments!",
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

    // SweetAlert Permanent Delete Confirmation
    function confirmPermanentDelete(id, name, doctorsCount) {
        let warningHtml = "Department '<strong>" + name + "</strong>' will be <strong class='text-danger'>permanently deleted</strong>!";
        
        if (doctorsCount > 0) {
            warningHtml += "<br><br><span class='text-warning'><i class='fe fe-alert-triangle'></i> Warning: This department has <strong>" + doctorsCount + " doctor(s)</strong> assigned to it!</span>";
        }
        
        warningHtml += "<br><small class='text-muted'>This action cannot be undone!</small>";
        
        Swal.fire({
            title: 'Permanently Delete?',
            html: warningHtml,
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