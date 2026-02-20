@extends('admin.master')

@section('title', 'Archived Invoices')

@section('content')

@can('delete_invoices')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Invoices</h2>
                    <p class="text-muted">View and manage archived billing records</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.invoice.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Invoices
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
                    <strong class="card-title">Search Filters</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.invoice.trashed') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Patient Name</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ request('search') }}" placeholder="Search by patient name...">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="status">Payment Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="paid"   {{ request('status') == 'paid'   ? 'selected' : '' }}>Paid</option>
                                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="date">Invoice Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-1">
                                <label>&nbsp;</label>
                                <a href="{{ route('admin.invoice.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Invoices Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Invoices List</strong>
                        <span class="badge badge-warning badge-pill">{{ $invoices->total() }} Archived</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped align-middle mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Patient & Doctor</th>
                                    <th>Services Rendered</th>
                                    <th class="text-center">Invoice Date</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th>Archived On</th>
                                    <th class="text-center" style="width: 110px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $invoices->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-soft-warning d-flex align-items-center justify-content-center">
                                                        <span class="h6 mb-0 text-warning">
                                                            {{ strtoupper(substr($invoice->patient->name ?? 'P', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong class="text-muted">{{ $invoice->patient->name ?? 'Deleted Patient' }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fe fe-user mr-1"></i>
                                                        Dr. {{ $invoice->doctor->user->name ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if($invoice->services && $invoice->services->count() > 0)
                                                @foreach($invoice->services->take(2) as $service)
                                                    <span class="d-block small text-truncate text-muted" style="max-width: 200px;"
                                                          title="{{ $service->service_name }}">
                                                        <i class="fe fe-check-circle mr-1"></i>
                                                        {{ $service->service_name }}
                                                    </span>
                                                @endforeach
                                                @if($invoice->services->count() > 2)
                                                    <span class="badge badge-soft-secondary mt-1">
                                                        +{{ $invoice->services->count() - 2 }} more
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted small fst-italic">No services listed</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-soft-secondary px-2 py-1">
                                                <i class="fe fe-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}
                                            </span>
                                        </td>

                                        <td class="text-right">
                                            <strong class="text-muted">${{ number_format($invoice->amount, 2) }}</strong>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : 'warning' }} px-2 py-1"
                                                  style="opacity: 0.75;">
                                                <i class="fe {{ $invoice->status === 'paid' ? 'fe-check-circle' : 'fe-clock' }} mr-1"></i>
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $invoice->deleted_at->format('d M, Y') }}<br>
                                                <span style="font-size: 0.7rem;">
                                                    {{ $invoice->deleted_at->diffForHumans() }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore -->
                                                <form action="{{ route('admin.invoice.restore', $invoice->id) }}"
                                                      method="POST"
                                                      id="restore-form-{{ $invoice->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmRestore({{ $invoice->id }}, '{{ addslashes($invoice->patient->name ?? 'this invoice') }}', '{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}')"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-toggle="tooltip" title="Restore Invoice">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived invoices found.</p>
                                                <a href="{{ route('admin.invoice.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Invoices
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($invoices->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} archived records
                        </small>
                        {{ $invoices->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
        You don't have permission to view archived invoices.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm { width: 36px; height: 36px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-warning   { background-color: rgba(255, 193,   7, 0.1); }
    .bg-soft-primary   { background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-primary   { color: #1b68ff; background-color: rgba(27, 104, 255, 0.1); }
    .badge-soft-secondary { color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
    .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.02); }
    thead.thead-light th {
        color: #6c757d;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function confirmRestore(id, patientName, date) {
        Swal.fire({
            title: 'Restore Invoice?',
            html:  "Invoice will be moved back to active!<br><br>" +
                   "<strong>Patient:</strong> " + patientName + "<br>" +
                   "<strong>Date:</strong> " + date,
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

    function confirmPermanentDelete(id, patientName, date) {
        Swal.fire({
            title: 'Permanently Delete?',
            html:  "Invoice will be <strong class='text-danger'>permanently deleted!</strong><br><br>" +
                   "<strong>Patient:</strong> " + patientName + "<br>" +
                   "<strong>Date:</strong> " + date + "<br><br>" +
                   "<small class='text-muted'>This action cannot be undone!</small>",
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
                document.getElementById('force-delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush