@extends('admin.master')

@section('title', 'Archived Doctors')

@section('content')

@can('view_doctors')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Doctors</h2>
                    <p class="text-muted">View and restore archived doctors</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-arrow-left"></i> Back to Active Doctors
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

            <!-- Filters Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.doctor.trashed') }}">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search by name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control select2">
                                    <option value="">All Departments</option>
                                    @foreach($majors as $department)
                                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                            {{ $department->title }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ route('admin.doctor.trashed') }}'">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Doctors Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Doctors List</strong>
                        <span class="badge badge-warning badge-pill">{{ $doctors->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th style="width: 80px;">Image</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Department</th>
                                    <th class="text-center">Experience</th>
                                    <th class="text-center">Deleted At</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($doctors as $index => $doctor)
                                    <tr>
                                        <td class="text-center">{{ $doctors->firstItem() + $loop->index }}</td>

                                        <td>
                                            @if($doctor->image)
                                                <div class="avatar avatar-md">
                                                    <img src="{{ asset('images/doctors/' . $doctor->image) }}" alt="{{ $doctor->user->name }}" class="avatar-img rounded-circle">
                                                </div>
                                            @else
                                                <div class="avatar avatar-md">
                                                    <img src="{{ asset('admin-assets/img/default-doctor.png') }}" alt="Default" class="avatar-img rounded-circle">
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $doctor->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $doctor->user->email }}</small>
                                        </td>

                                        <td>
                                            @if($doctor->gender == 'male')
                                                <span class="text-info"><i class="fe fe-user mr-1"></i>Male</span>
                                            @elseif($doctor->gender == 'female')
                                                <span class="text-danger"><i class="fe fe-user mr-1"></i>Female</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($doctor->major)
                                                <span class="badge badge-soft-primary">{{ $doctor->major->title }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-light">{{ $doctor->years_of_experience ?? 0 }} years</span>
                                        </td>

                                        <td class="text-center">
                                            <small class="text-muted">
                                                {{ $doctor->deleted_at ? $doctor->deleted_at->format('Y-m-d') : '-' }}
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('edit_doctors')
                                                <form action="{{ route('admin.doctor.restore', $doctor->id) }}" 
                                                        method="POST" 
                                                        class="d-inline">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-success" 
                                                            data-toggle="tooltip" 
                                                            title="Restore"
                                                            onclick="return confirm('Are you sure you want to restore Dr. {{ $doctor->user->name }}?')">
                                                        <i class="fe fe-refresh-cw"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived doctors found.</p>
                                                <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                                                    <i class="fe fe-arrow-left"></i> Back to Active Doctors
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($doctors->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $doctors->firstItem() }} to {{ $doctors->lastItem() }} of {{ $doctors->total() }} entries
                        </div>
                        <div>
                            {{ $doctors->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md {
        width: 48px;
        height: 48px;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }
    .badge-soft-primary {
        color: #1b68ff;
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
    /* Archived items style */
    tbody tr {
        opacity: 0.85;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush