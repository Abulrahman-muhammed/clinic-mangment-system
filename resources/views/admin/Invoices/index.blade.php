@extends('admin.master')

@section('title', 'Invoices')

@section('content')

@can('view_invoices')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title mb-0">Invoices</h2>

                @can('create_invoices')
                <div class="page-title-right">
                    <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus"></i> Add Invoice
                    </a>
                </div>
                @endcan
            </div>

            <!-- Main Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Services</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $invoices->firstItem() + $loop->index }}</td>
                                        <td>{{ $invoice->patient->name ?? '-' }}</td>
                                        <td>{{ $invoice->doctor->user->name ?? '-' }}</td>

                                        <td>
                                            @if($invoice->services->count() > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($invoice->services as $service)
                                                        <li>{{ $service->service_name }} - ${{ number_format($service->price, 2) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No Services</span>
                                            @endif
                                        </td>

                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>${{ number_format($invoice->amount, 2) }}</td>

                                        <!-- Status -->
                                        <td>
                                            @can('edit_invoices')
                                            <button type="button"
                                                class="btn btn-sm status-toggle-btn {{ $invoice->status === 'paid' ? 'btn-success' : 'btn-warning' }}"
                                                data-id="{{ $invoice->id }}"
                                                data-status="{{ $invoice->status === 'paid' ? 'unpaid' : 'paid' }}">
                                                @if ($invoice->status === 'paid')
                                                    <i class="fe fe-check-circle"></i> Paid
                                                @else
                                                    <i class="fe fe-x-circle"></i> Unpaid
                                                @endif
                                            </button>
                                            @else
                                                <span class="badge {{ $invoice->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            @endcan
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            @can('print_invoices')
                                            <a href="{{ route('admin.invoice.print', $invoice->id) }}"
                                                class="btn btn-sm btn-info print-btn {{ $invoice->status === 'paid' ? '' : 'd-none' }}"
                                                title="Print" target="_blank">
                                                <i class="fe fe-printer fa-2x"></i>
                                            </a>
                                            @endcan

                                            @can('delete_invoices')
                                            <form action="{{ route('admin.invoice.destroy', $invoice->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this invoice?')"
                                                    title="Delete">
                                                    <i class="fe fe-trash-2 fa-2x"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No Invoices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $invoices->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection
