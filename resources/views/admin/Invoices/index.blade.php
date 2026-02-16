@php
$action = 'admin.invoice.index';
if(auth()->user()->hasRole('doctor')){
    $action = 'admin.doctor.myInvoices';
}
@endphp
@extends('admin.master')

@section('title', 'Invoices')

@section('content')

@can('view_invoices')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Invoices</h2>
                    <p class="text-muted">Manage billing, payments, and service records</p>
                </div>
                <div class="col-auto">
                    @can('create_invoices')
                    <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Invoice
                    </a>
                    @endcan
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Search Filters</strong>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route($action) }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Patient Name</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search by patient name...">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status">Payment Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="date">Invoice Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    @role('doctor')
                                    <a href="{{ route('admin.doctor.myInvoices') }}" class="btn btn-secondary">Reset</a>
                                    @endrole
                                    @role('admin')
                                    <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">Reset</a>
                                    @endrole
                                    @role('receptionist')
                                    <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">Reset</a>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow border-0">
                <div class="card-body p-0">
                    
                    @if (session('success'))
                        <div class="alert alert-success m-3 alert-dismissible fade show">
                            <i class="fe fe-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger m-3 alert-dismissible fade show">
                            <i class="fe fe-alert-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Patient & Doctor</th>
                                    <th>Services Rendered</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-right">Total Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">
                                        @can('edit_invoices' || 'delete_invoices')
                                            Actions
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $invoices->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $invoice->patient->name ?? 'Deleted Patient' }}</div>
                                            <small class="text-muted">Dr. {{ $invoice->doctor->user->name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($invoice->services->count() > 0)
                                                <div class="small">
                                                    @foreach($invoice->services->take(2) as $service)
                                                        <span class="d-block text-truncate" style="max-width: 200px;">
                                                            • {{ $service->service_name }}
                                                        </span>
                                                    @endforeach
                                                    @if($invoice->services->count() > 2)
                                                        <span class="text-primary">+{{ $invoice->services->count() - 2 }} more</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted italic small">No services listed</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="small">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</span>
                                        </td>
                                        <td class="text-right font-weight-bold text-dark">
                                            ${{ number_format($invoice->amount, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @can('edit_invoices')
                                            <form action="{{ route('admin.invoice.toggleStatus', $invoice->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                        
                                                <button type="submit"
                                                    class="btn btn-sm rounded-pill 
                                                    {{ $invoice->status === 'paid' ? 'btn-success' : 'btn-warning' }}">
                                                    
                                                    {{ $invoice->status === 'paid' ? 'Paid' : 'Unpaid' }}
                                                </button>
                                            </form>
                                            @else
                                                <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            @endcan
                                        </td>
                                        
                                        <td class="text-right">
                                            <div class="btn-group">
                                                @can('print_invoices')
                                                    @if($invoice->status === 'paid')
                                                        <a href="{{ route('admin.invoice.print', $invoice->id) }}"
                                                            class="btn btn-sm btn-outline-info"
                                                            title="Print Receipt" target="_blank">
                                                            <i class="fe fe-printer"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" 
                                                                disabled 
                                                                title="Only paid invoices can be printed">
                                                            <i class="fe fe-printer"></i>
                                                        </button>
                                                    @endif
                                                @endcan

                                                @can('delete_invoices')
                                                <form action="{{ route('admin.invoice.destroy', $invoice->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" 
                                                            title="Delete">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fe fe-file-text fe-24 d-block mb-2"></i>
                                            No Invoices found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($invoices->hasPages())
                <div class="card-footer bg-transparent border-0">
                    {{ $invoices->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>


@endcan

@endsection
