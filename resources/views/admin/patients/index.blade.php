@extends('admin.master')

@section('title', 'Patients')

@section('content')

@can('view_patients')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Patients Management</h2>
                    <p class="text-muted">View and manage patient records and medical history</p>
                </div>

                <div class="col-auto">
                    {{-- زرار الأرشيف --}}
                    <a href="{{ route('admin.patient.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Patients
                    </a>
                    
                    @can('create_patients')
                    <a href="{{ route('admin.patient.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Patient
                    </a>
                    @endcan
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Filter Card (كما هي بدون تغيير) --}}
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    @php
                        $action = route('admin.patient.index');
                        if(auth()->user()->hasRole('doctor')) {
                            $action = route('admin.doctor.myPatients');
                        }
                    @endphp
                    <form method="GET" action="{{ $action }}">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="search">Patient Info</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Name, Email or Phone">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">All Genders</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
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
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ $action }}'">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Patients List</strong>
                        <span class="badge badge-primary badge-pill px-3">{{ $patients->total() }} Records</span>
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
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $patients->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                                        <span class="h6 mb-0 text-primary">{{ substr($patient->name, 0, 1) }}</span>
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
                                        <td style="max-width: 250px;">
                                            <p class="small text-truncate mb-0" title="{{ $patient->medical_history ?? 'No recorded history' }}">
                                                {{ $patient->medical_history ?? 'No recorded history' }}
                                            </p>
                                            <small class="d-block text-muted text-truncate italic"><i class="fe fe-map-pin mr-1"></i>{{ $patient->address ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                @can('view_patients')
                                                <a href="{{ route('admin.patient.show', $patient) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" title="View">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                @endcan
                                                @can('edit_patients')
                                                <a href="{{ route('admin.patient.edit', $patient) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan
                                                @can('delete_patients')
                                                {{-- تعديل فورم الحذف --}}
                                                <form action="{{ route('admin.patient.destroy', $patient) }}" method="POST" id="delete-form-{{ $patient->id }}" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmDelete({{ $patient->id }}, '{{ $patient->name }}')"
                                                            data-toggle="tooltip" title="Delete">
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
                                            <i class="fe fe-folder-minus fe-24 text-muted mb-2"></i>
                                            <p class="text-muted">No patient records found.</p>
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
                        <span class="text-muted small">Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }}</span>
                        {{ $patients->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endcan

@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Patient '" + name + "' will be moved to the trash!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush

@push('styles')
<style>
    .avatar-sm { width: 32px; height: 32px; }
    .bg-soft-primary { background-color: rgba(27, 104, 255, 0.1); }
    .badge-soft-info { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    .badge-soft-danger { color: #dc3545; background-color: rgba(220, 53, 69, 0.1); }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    thead.thead-light th { text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.05em; }
</style>
@endpush