@extends('admin.master')

@section('title', 'Invoices')

@section('content')

@php
    $action = auth()->user()->hasRole('doctor')
        ? route('admin.doctor.myInvoices')
        : route('admin.invoice.index');
@endphp

@can('view_invoices')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Invoices Management</h2>
                    <p class="text-muted">Manage billing, payments, and service records</p>
                </div>
                <div class="col-auto">
                    @can('delete_invoices')
                    <a href="{{ route('admin.invoice.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Invoices
                    </a>
                    @endcan

                    @can('create_invoices')
                    <a href="{{ route('admin.invoice.create') }}" class="btn btn-outline-primary">
                        <i class="fe fe-plus mr-1"></i> Add Invoice
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

            <!-- Filters Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Search Filters</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ $action }}" id="filter-form">
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
                                <a href="{{ $action }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Invoices Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Invoices List</strong>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-success badge-pill mr-2">
                                {{ $invoices->where('status', 'paid')->count() }} Paid
                            </span>
                            <span class="badge badge-warning badge-pill mr-2">
                                {{ $invoices->where('status', 'unpaid')->count() }} Unpaid
                            </span>
                            <span class="badge badge-primary badge-pill">
                                {{ $invoices->total() }} Total
                            </span>
                        </div>
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
                                    <th class="text-center">Date</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 130px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $invoices->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-3">
                                                    <div class="avatar-img rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                                        <span class="h6 mb-0 text-primary">
                                                            {{ strtoupper(substr($invoice->patient->name ?? 'P', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong>{{ $invoice->patient->name ?? 'Deleted Patient' }}</strong>
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
                                                    <span class="d-block small text-truncate" style="max-width: 200px;"
                                                          title="{{ $service->service_name }}">
                                                        <i class="fe fe-check-circle text-success mr-1"></i>
                                                        {{ $service->service_name }}
                                                    </span>
                                                @endforeach
                                                @if($invoice->services->count() > 2)
                                                    <span class="badge badge-soft-primary mt-1">
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
                                            <strong class="text-dark">${{ number_format($invoice->amount, 2) }}</strong>
                                        </td>

                                        <td class="text-center">
                                            @can('edit_invoices')
                                                <form action="{{ route('admin.invoice.toggleStatus', $invoice->id) }}"
                                                      method="POST"
                                                      id="toggle-form-{{ $invoice->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmToggle({{ $invoice->id }}, '{{ $invoice->status }}', '{{ addslashes($invoice->patient->name ?? 'this invoice') }}')"
                                                            class="btn btn-sm rounded-pill {{ $invoice->status === 'paid' ? 'btn-success' : 'btn-warning' }}">
                                                        <i class="fe {{ $invoice->status === 'paid' ? 'fe-check-circle' : 'fe-clock' }} mr-1"></i>
                                                        {{ $invoice->status === 'paid' ? 'Paid' : 'Unpaid' }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : 'warning' }} px-2 py-1">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            @endcan
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">

                                                @can('print_invoices')
                                                @if($invoice->status === 'paid')
                                                    <a href="{{ route('admin.invoice.print', $invoice->id) }}"
                                                       class="btn btn-sm btn-outline-secondary"
                                                       data-toggle="tooltip" title="Print Receipt"
                                                       target="_blank">
                                                        <i class="fe fe-printer"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                            disabled
                                                            data-toggle="tooltip"
                                                            title="Only paid invoices can be printed">
                                                        <i class="fe fe-printer"></i>
                                                    </button>
                                                @endif
                                                @endcan

                                                @can('delete_invoices')
                                                <form action="{{ route('admin.invoice.destroy', $invoice->id) }}"
                                                      method="POST"
                                                      id="delete-form-{{ $invoice->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete({{ $invoice->id }}, '{{ addslashes($invoice->patient->name ?? 'this invoice') }}', '{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}')"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" title="Archive">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-file-text fe-24 mb-3"></i>
                                                <p class="mb-0">No invoices found matching your criteria.</p>
                                                @can('create_invoices')
                                                <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First Invoice
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

                @if($invoices->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} records
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
        You don't have permission to view invoices.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-sm { width: 36px; height: 36px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
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
    .rounded-pill { border-radius: 50rem !important; }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // SweetAlert: Archive invoice
    function confirmDelete(id, patientName, date) {
        Swal.fire({
            title: 'Archive Invoice?',
            html:  "Invoice will be moved to archives!<br><br>" +
                   "<strong>Patient:</strong> " + patientName + "<br>" +
                   "<strong>Date:</strong> " + date,
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

    // SweetAlert: Toggle payment status
    function confirmToggle(id, currentStatus, patientName) {
        const newStatus = currentStatus === 'paid' ? 'Unpaid' : 'Paid';
        const icon      = currentStatus === 'paid' ? 'warning' : 'question';
        const color     = currentStatus === 'paid' ? '#ffc107' : '#28a745';

        Swal.fire({
            title: 'Change Status to ' + newStatus + '?',
            html:  "Change payment status for <strong>" + patientName + "</strong>?",
            icon:  icon,
            showCancelButton: true,
            confirmButtonColor: color,
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, mark as ' + newStatus + '!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('toggle-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush