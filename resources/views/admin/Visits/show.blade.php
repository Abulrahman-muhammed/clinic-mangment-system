@extends('admin.master')

@section('title', 'Visit Details')

@section('content')
@can('view_patients')
<div class="container-fluid py-4">
    <div class="row align-items-end mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.visit.index') }}">Visits</a>
                    </li>
                    <li class="breadcrumb-item active">Visit #{{ $visit->id }}</li>
                </ol>
            </nav>
            <h2 class="h3 mb-0 font-weight-bold">Visit Details</h2>
        </div>
        <div class="col-auto">
            @can('edit_patients')
            <a href="{{ route('admin.visit.edit', $visit) }}" class="btn btn-primary shadow-sm mr-2">
                <i class="fe fe-edit-2 mr-1"></i> Edit
            </a>
            @endcan
            <a href="{{ route('admin.visit.index') }}" class="btn btn-outline-secondary">
                <i class="fe fe-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-4">

            <!-- Visit Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="text-uppercase text-muted small font-weight-bold mb-0">
                        <i class="fe fe-activity text-primary mr-2"></i>Visit Info
                    </h6>
                </div>
                <div class="card-body">

                    <!-- Status Badge -->
<!-- Status Badge with Quick Update -->
<div class="mb-3">
    <small class="text-muted d-block mb-1">Status</small>
    <div class="dropdown">
        @php
            $statusColor = match($visit->status) {
                'completed' => 'success',
                'active'    => 'info',
                'pending'   => 'warning',
                'cancelled' => 'danger',
                default     => 'secondary'
            };
        @endphp
        
        <button class="btn btn-{{ $statusColor }} btn-sm dropdown-toggle px-3 py-2" type="button" id="statusMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fe fe-circle fill-current mr-1"></i>{{ ucfirst($visit->status) }}
        </button>

        <div class="dropdown-menu shadow border-0" aria-labelledby="statusMenu">
            <h6 class="dropdown-header">Change Status to:</h6>
            @foreach(['in_progress', 'done', 'cancelled'] as $status)
                @if($status !== $visit->status)
                    <form action="{{ route('admin.visit.update-status', $visit) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <span class="badge badge-dot badge-{{ $status == 'done' ? 'success' : ($status == 'in_progress' ? 'info' : 'danger') }} mr-2"></span>
                            {{ ucfirst($status) }}
                        </button>
                    </form>
                @endif
            @endforeach
        </div>
    </div>
</div>

                    <!-- Created At -->
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-sm bg-light rounded mr-3 mt-1 text-center"
                             style="width: 32px; height: 32px; line-height: 32px;">
                            <i class="fe fe-calendar text-muted"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Visit Date</small>
                            <span class="font-weight-600">
                                {{ $visit->created_at->format('M d, Y') }}
                            </span>
                            <small class="text-muted d-block">{{ $visit->created_at->format('h:i A') }}</small>
                        </div>
                    </div>

                    <!-- Receptionist -->
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-sm bg-light rounded mr-3 mt-1 text-center"
                             style="width: 32px; height: 32px; line-height: 32px;">
                            <i class="fe fe-user text-muted"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Receptionist</small>
                            <span class="font-weight-600">{{ $visit->receptionist->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($visit->notes)
                    <div class="mt-2">
                        <small class="text-muted d-block mb-2">Visit Notes</small>
                        <div class="bg-light p-3 rounded border-left border-primary border-4">
                            <p class="small text-dark mb-0 italic">{{ $visit->notes }}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Patient Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="text-uppercase text-muted small font-weight-bold mb-0">
                        <i class="fe fe-user text-primary mr-2"></i>Patient
                    </h6>
                </div>
                <div class="card-body">
                    @if($visit->patient)
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm bg-soft-primary rounded-circle mr-3 d-flex align-items-center justify-content-center"
                             style="width: 40px; height: 40px;">
                            <span class="h5 mb-0 text-primary">{{ substr($visit->patient->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <strong class="d-block">{{ $visit->patient->name }}</strong>
                            <small class="text-muted">{{ $visit->patient->email }}</small>
                        </div>
                    </div>
                    <div class="small text-muted mb-1">
                        <i class="fe fe-phone mr-1"></i> {{ $visit->patient->phone ?? 'N/A' }}
                    </div>
                    <div class="small text-muted">
                        <i class="fe fe-droplet mr-1"></i> Blood Type: <strong>{{ $visit->patient->blood_type ?? 'N/A' }}</strong>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.patient.show', $visit->patient) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fe fe-external-link mr-1"></i> View Patient
                        </a>
                    </div>
                    @else
                        <p class="text-muted small mb-0">No patient linked.</p>
                    @endif
                </div>
            </div>

            <!-- Doctor Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="text-uppercase text-muted small font-weight-bold mb-0">
                        <i class="fe fe-briefcase text-primary mr-2"></i>Doctor
                    </h6>
                </div>
                <div class="card-body">
                    @if($visit->doctor)
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-sm bg-soft-success rounded-circle mr-3 d-flex align-items-center justify-content-center"
                             style="width: 40px; height: 40px;">
                            <span class="h5 mb-0 text-success">{{ substr($visit->doctor->user->name ?? '?', 0, 1) }}</span>
                        </div>
                        <div>
                            <strong class="d-block">Dr. {{ $visit->doctor->user->name ?? 'N/A' }}</strong>
                            <small class="text-muted">{{ $visit->doctor->major->name ?? 'General' }}</small>
                        </div>
                    </div>
                    @else
                        <p class="text-muted small mb-0">No doctor linked.</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-lg-8">

            <!-- Invoice Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">Invoice</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($visit->invoice)
                            <tr>
                                <td class="font-weight-bold">#INV-{{ str_pad($visit->invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($visit->invoice->created_at)->format('M d, Y') }}</td>
                                <td class="text-success font-weight-bold">${{ number_format($visit->invoice->amount, 2) }}</td>
                                <td><span class="badge badge-success-soft">Paid</span></td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    No invoice generated for this visit.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endcan
@endsection

@push('styles')
<style>
    .bg-soft-primary { background-color: rgba(27, 104, 255, 0.1); }
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .border-4 { border-width: 4px !important; }
    .badge-success-soft { color: #28a745; background-color: rgba(40, 167, 69, 0.1); }
</style>
@endpush