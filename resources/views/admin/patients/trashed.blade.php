@extends('admin.master')

@section('title', 'Archived Patients')

@section('content')

@can('delete_patients')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Patients</h2>
                    <p class="text-muted">View and manage archived patient records</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Patients
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
                    <form method="GET" action="{{ route('admin.patient.trashed') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Patient Info</label>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       class="form-control" 
                                       value="{{ request('search') }}" 
                                       placeholder="Name, Email or Phone">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">All Genders</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="blood_type">Blood Type</label>
                                <select name="blood_type" id="blood_type" class="form-control select2">
                                    <option value="">All Types</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                        <option value="{{ $type }}" {{ request('blood_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
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
                                <a href="{{ route('admin.patient.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Patients Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Patients List</strong>
                        <span class="badge badge-warning badge-pill px-3">{{ $patients->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Info</th>
                                    <th>Medical History</th>
                                    <th>Archived Date</th>
                                    <th class="text-center" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $patients->firstItem() + $loop->index }}</td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-soft-warning d-flex align-items-center justify-content-center">
                                                        <span class="h6 mb-0 text-warning">{{ substr($patient->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong>{{ $patient->name }}</strong><br>
                                                    <small class="text-muted">DOB: {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M, Y') : 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="small"><i class="fe fe-mail mr-1 text-muted"></i> {{ $patient->email }}</div>
                                            <div class="small"><i class="fe fe-phone mr-1 text-muted"></i> {{ $patient->phone }}</div>
                                        </td>

                                        <td>
                                            <span class="badge badge-soft-{{ $patient->gender == 'male' ? 'info' : 'danger' }} px-2 mb-1">
                                                {{ ucfirst($patient->gender) }}
                                            </span><br>
                                            <span class="text-muted small fw-bold">Type: <span class="text-dark">{{ $patient->blood_type ?? '??' }}</span></span>
                                        </td>

                                        <td style="max-width: 200px;">
                                            <p class="small text-truncate mb-0" title="{{ $patient->medical_history ?? 'No recorded history' }}">
                                                {{ $patient->medical_history ?? 'No recorded history' }}
                                            </p>
                                            <small class="d-block text-muted text-truncate italic"><i class="fe fe-map-pin mr-1"></i>{{ $patient->address ?? '-' }}</small>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $patient->deleted_at ? $patient->deleted_at->format('d M, Y') : 'N/A' }}<br>
                                                <span class="text-muted" style="font-size: 0.7rem;">
                                                    {{ $patient->deleted_at ? $patient->deleted_at->diffForHumans() : '' }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore Button -->
                                                <form action="{{ route('admin.patient.restore', $patient->id) }}" 
                                                      method="POST" 
                                                      id="restore-form-{{ $patient->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" 
                                                            onclick="confirmRestore({{ $patient->id }}, '{{ addslashes($patient->name) }}')"
                                                            class="btn btn-sm btn-outline-success" 
                                                            data-toggle="tooltip" 
                                                            title="Restore Patient">
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
                                                <p class="mb-0">No archived patients found.</p>
                                                <a href="{{ route('admin.patient.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Patients
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($patients->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} archived records
                        </span>
                        <div>
                            {{ $patients->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
        You don't have permission to view archived patients.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bg-soft-primary {
        background-color: rgba(27, 104, 255, 0.1);
    }
    .bg-soft-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .badge-soft-info {
        color: #17a2b8;
        background-color: rgba(23, 162, 184, 0.1);
    }
    .badge-soft-danger {
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    thead.thead-light th {
        color: #6c757d;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize Select2 if available
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select Blood Type',
                allowClear: true
            });
        }
    });

    // SweetAlert Restore Confirmation
    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Patient?',
            text: "Patient '" + name + "' will be restored to active patients!",
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
    function confirmPermanentDelete(id, name) {
        Swal.fire({
            title: 'Permanently Delete?',
            html: "Patient '<strong>" + name + "</strong>' will be <strong class='text-danger'>permanently deleted</strong>!<br><small class='text-muted'>This action cannot be undone!</small>",
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