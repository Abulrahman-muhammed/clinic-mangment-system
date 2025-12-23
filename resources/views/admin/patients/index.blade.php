@extends('admin.master')

@section('title', 'Patients')

@section('content')

@can('view_patients')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Patients</h2>

                @can('create_patients')
                <div class="page-title-right">
                    <a href="{{ route('admin.patient.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Patient
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Blood Type</th>
                                <th>Date of Birth</th>
                                <th>Address</th>
                                <th>Medical History</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($patients->count() > 0)
                                @foreach ($patients as $index => $patient)
                                    <tr>
                                        <td>{{ $patients->firstItem() + $loop->index }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->email }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ ucfirst($patient->gender) }}</td>
                                        <td>{{ $patient->blood_type ?? 'Unknown' }}</td>
                                        <td>
                                            {{ $patient->date_of_birth
                                                ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d-m-Y')
                                                : '-' }}
                                        </td>
                                        <td>{{ $patient->address ?? '-' }}</td>
                                        <td>
                                            @if($patient->medical_history)
                                                <span title="{{ $patient->medical_history }}">
                                                    {{ \Illuminate\Support\Str::limit($patient->medical_history, 40) }}
                                                </span>
                                            @else
                                                <span class="text-muted">No history</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('edit_patients')
                                            <a href="{{ route('admin.patient.edit', $patient) }}" 
                                               class="btn btn-sm btn-success me-1">
                                                <i class="fe fe-edit-2 fa-2x"></i>
                                            </a>
                                            @endcan

                                            @can('delete_patients')
                                            <form action="{{ route('admin.patient.destroy', $patient) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this patient?')">
                                                    <i class="fe fe-trash-2 fa-2x"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        No Patients found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $patients->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection
