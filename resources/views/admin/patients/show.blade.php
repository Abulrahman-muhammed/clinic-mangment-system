@extends('admin.master')

@section('title', 'Patient Details - ' . $patient->name)

@section('content')
@can('view_patients')
<div class="container-fluid py-4">
    <div class="row align-items-end mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ auth()->user()->hasRole('doctor') ? route('admin.doctor.myPatients') : route('admin.patient.index') }}">
                            Patients
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ $patient->name }}</li>
                </ol>
            </nav>
            <h2 class="h3 mb-0 font-weight-bold">Patient Profile</h2>
        </div>
        <div class="col-auto">
            @can('edit_patients')
            <a href="{{ route('admin.patient.edit', $patient) }}" class="btn btn-primary shadow-sm mr-2">
                <i class="fe fe-edit-2 mr-1"></i> Edit
            </a>
            @endcan
            <a href="{{ auth()->user()->hasRole('doctor') ? route('admin.doctor.myPatients') : route('admin.patient.index') }}"
               class="btn btn-outline-secondary">
                <i class="fe fe-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- ─── Left Column ─────────────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Contact Information --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="text-uppercase text-muted small font-weight-bold mb-0">
                        <i class="fe fe-phone-call text-primary mr-2"></i>Contact Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-sm bg-light-primary text-primary rounded mr-3 mt-1 text-center"
                             style="width: 32px; height: 32px; line-height: 32px;">
                            <i class="fe fe-mail"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Email Address</small>
                            <span class="font-weight-600">{{ $patient->email }}</span>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-sm bg-light-success text-success rounded mr-3 mt-1 text-center"
                             style="width: 32px; height: 32px; line-height: 32px;">
                            <i class="fe fe-phone"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Phone Number</small>
                            <span class="font-weight-600">{{ $patient->phone }}</span>
                        </div>
                    </div>
                    @if($patient->address)
                    <div class="d-flex">
                        <div class="avatar avatar-sm bg-light-info text-info rounded mr-3 mt-1 text-center"
                             style="width: 32px; height: 32px; line-height: 32px;">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Home Address</small>
                            <span class="font-weight-600">{{ $patient->address }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Personal Details --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="text-uppercase text-muted small font-weight-bold mb-0">
                        <i class="fe fe-user text-primary mr-2"></i>Personal Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row no-gutters mb-4">
                        <div class="col-6 border-right px-2">
                            <small class="text-muted d-block">Date of Birth</small>
                            <p class="font-weight-bold mb-0">
                                {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : '—' }}
                            </p>
                        </div>
                        <div class="col-6 px-3">
                            <small class="text-muted d-block">Age</small>
                            <p class="font-weight-bold mb-0">
                                {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' Years' : '—' }}
                            </p>
                        </div>
                    </div>
                    <div class="row no-gutters mb-4">
                        <div class="col-6 border-right px-2">
                            <small class="text-muted d-block mb-1">Gender</small>
                            <span class="badge badge-{{ $patient->gender == 'male' ? 'primary' : 'danger' }}-soft text-capitalize">
                                <i class="fe fe-{{ $patient->gender == 'male' ? 'user' : 'user-plus' }} mr-1"></i>{{ $patient->gender }}
                            </span>
                        </div>
                        <div class="col-6 px-3">
                            <small class="text-muted d-block mb-1">Blood Type</small>
                            <span class="badge badge-danger px-2">
                                <i class="fe fe-droplet mr-1"></i>{{ $patient->blood_type ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                    @if($patient->medical_history)
                    <div class="mt-2">
                        <small class="text-muted d-block mb-2">Medical Notes</small>
                        <div class="bg-light p-3 rounded border-left border-primary border-4">
                            <p class="small text-dark mb-0 italic">{{ $patient->medical_history }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ─── Right Column ────────────────────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Stat Cards --}}
            <div class="row mb-4">
                @php
                    $statCards = [
                        ['label' => 'Completed Appointments', 'val' => $stats['completed_appointments'] ?? 0, 'icon' => 'check-circle', 'color' => 'success'],
                        ['label' => 'Total Spent', 'val' => '$' . number_format($stats['total_amount'], 2), 'icon' => 'dollar-sign', 'color' => 'info'],
                        ['label' => 'Total Visits', 'val' => $visits->total(), 'icon' => 'calendar', 'color' => 'primary'],
                    ];
                @endphp
                @foreach($statCards as $card)
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm bg-{{ $card['color'] }} text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <small class="text-white-50 text-uppercase font-weight-bold">{{ $card['label'] }}</small>
                                    <h3 class="text-white mt-1 mb-0">{{ $card['val'] }}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="fe fe-{{ $card['icon'] }} opacity-50 h2 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Appointments History --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">Appointments History</h5>
                    <span class="badge badge-light text-muted">{{ $appointments->total() }} Records</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Schedule</th>
                                <th>Practitioner</th>
                                <th>Status</th>
                                <th class="text-right">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                            <tr>
                                <td>
                                    <div class="font-weight-600 text-dark">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($appointment->date)->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2 bg-light rounded-circle text-center"
                                             style="width:24px; height:24px;">
                                            <i class="fe fe-user small"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-600 small">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $appointment->doctor->major->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusColor = match($appointment->status) {
                                            'completed' => 'success',
                                            'pending'   => 'warning',
                                            'confirmed' => 'info',
                                            default     => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusColor }}-soft">
                                        <i class="fe fe-circle fill-current mr-1 small"></i>{{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.booking.index') }}" class="btn btn-sm btn-light btn-rounded">
                                        <i class="fe fe-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="{{ asset('assets/img/empty-state.svg') }}" alt="" style="width: 60px" class="mb-3 opacity-25">
                                    <p class="text-muted">No appointment records found for this patient.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($appointments->hasPages())
                <div class="card-footer bg-white border-0 pt-0">
                    {{ $appointments->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>

            {{-- ═══════════════════════════════════════════════════════════════
                 Visits History  (NEW)
            ════════════════════════════════════════════════════════════════ --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fe fe-activity text-primary mr-2"></i>Visits History
                    </h5>
                    <span class="badge badge-light text-muted">{{ $visits->total() }} Records</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Doctor</th>
                                <th>Receptionist</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Date</th>
                                <th class="text-right">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($visits as $visit)
                            <tr>
                                <td class="text-muted small">{{ $visit->id }}</td>

                                {{-- Doctor --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2 bg-soft-success rounded-circle text-center"
                                             style="width:24px; height:24px; line-height:24px;">
                                            <i class="fe fe-user small text-success"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-600 small">Dr. {{ $visit->doctor->user->name ?? 'N/A' }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $visit->doctor->major->name ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Receptionist --}}
                                <td>
                                    <span class="small">{{ $visit->receptionist->name ?? '—' }}</span>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @php
                                        $vColor = match($visit->status) {
                                            'completed' => 'success',
                                            'active'    => 'info',
                                            'pending'   => 'warning',
                                            'cancelled' => 'danger',
                                            default     => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $vColor }}-soft">
                                        <i class="fe fe-circle fill-current mr-1 small"></i>{{ ucfirst($visit->status) }}
                                    </span>
                                </td>

                                {{-- Notes --}}
                                <td style="max-width: 160px;">
                                    <p class="small text-truncate mb-0" title="{{ $visit->notes ?? '' }}">
                                        {{ $visit->notes ?? '—' }}
                                    </p>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="small font-weight-600">{{ $visit->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $visit->created_at->format('h:i A') }}</small>
                                </td>

                                {{-- View --}}
                                <td class="text-right">
                                    @can('view_patients')
                                    <a href="{{ route('admin.visit.show', $visit) }}" class="btn btn-sm btn-light btn-rounded">
                                        <i class="fe fe-eye"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fe fe-folder-minus fe-24 text-muted mb-2 d-block"></i>
                                    <p class="text-muted mb-0">No visit records found for this patient.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($visits->hasPages())
                <div class="card-footer bg-white border-0 pt-0">
                    {{ $visits->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>

            {{-- Recent Billing --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">Recent Billing</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-right">Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td class="font-weight-bold">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</td>
                                <td class="text-success font-weight-bold">${{ number_format($invoice->amount, 2) }}</td>
                                <td><span class="badge badge-success-soft">Paid</span></td>
                                <td class="text-right">
                                    <a href="{{ route('admin.invoice.print', $invoice) }}" class="btn btn-sm btn-light btn-rounded" target="_blank">
                                        <i class="fe fe-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">No billing history available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- end col-lg-8 --}}
    </div>
</div>
@endcan
@endsection

@push('styles')
<style>
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .badge-success-soft  { color: #28a745; background-color: rgba(40, 167, 69, 0.1); }
    .badge-info-soft     { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    .badge-warning-soft  { color: #ffc107; background-color: rgba(255, 193, 7, 0.1); }
    .badge-danger-soft   { color: #dc3545; background-color: rgba(220, 53, 69, 0.1); }
    .badge-secondary-soft{ color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
    .badge-primary-soft  { color: #1b68ff; background-color: rgba(27, 104, 255, 0.1); }
    .border-4 { border-width: 4px !important; }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>
@endpush