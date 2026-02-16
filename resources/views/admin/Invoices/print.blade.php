@extends('admin.master')

@section('title', 'Print Invoice')

@section('content')
<div class="container-fluid">
    <!-- Print Button -->
    <div class="no-print text-end mb-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fe fe-printer"></i> Print Invoice
        </button>
    </div>

    <!-- Invoice Full Width -->
    <div class="invoice-box bg-white p-5 shadow-sm rounded-3" style="width: 100%; border: 1px solid #ddd;">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1 text-primary">{{ config('app.name') }}</h2>
            <p class="text-muted mb-0">Your Trusted Medical Partner</p>
            <hr style="border-top: 2px solid #0d6efd; width: 80px; margin: 10px auto;">
        </div>

        <!-- Invoice Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Invoice #:</strong> {{ $invoice->id }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Patient:</strong> {{ $invoice->patient->name }}</p>
                <p><strong>Doctor:</strong> Dr. {{ $invoice->doctor->user->name }}</p>
                <p><strong>Created By:</strong> {{ Auth::user()->name ?? 'Admin' }}</p>
            </div>
        </div>

        <!-- Services Table -->
        <table class="table table-bordered align-middle text-center w-100 invoice-table">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Service</th>
                    <th style="width: 180px;">Amount (EGP)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Consultation</td>
                    <td>{{ number_format($invoice->doctor->consultation_fee, 2) }}</td>
                </tr>
                @foreach($invoice->services as $index => $service)
                <tr>
                    <td>{{ $index + 2 }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>{{ number_format($service->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <th colspan="2" class="text-end">Total</th>
                    <th>{{ number_format($invoice->amount, 2) }} EGP</th>
                </tr>
            </tfoot>
        </table>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="mt-4">
            <strong>Notes:</strong>
            <p class="mb-0 text-muted">{{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-center mt-5 small text-muted">
            <hr>
            <p class="mb-1">Thank you for trusting <strong>{{ config('app.name') }}</strong>!</p>
            <p>Phone: +20 123 456 789 | Address: Cairo, Egypt</p>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    body {
        background: #f8f9fa;
        font-family: 'Poppins', Arial, sans-serif;
    }

    .invoice-table th, .invoice-table td {
        padding: 14px;
        font-size: 15px;
    }

    @media print {
        body {
            background: #fff !important;
        }
        .no-print {
            display: none !important;
        }
        .invoice-box {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
        .container-fluid {
            padding: 0 !important;
            width: 100% !important;
        }
        .invoice-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #000 !important;
            font-size: 16px !important;
            padding: 12px !important;
        }
        .invoice-table thead {
            background: #f0f0f0 !important;
            -webkit-print-color-adjust: exact !important;
        }
        @page {
            size: A4;
            margin: 20mm;
        }
    }
</style>
@endsection
