@extends('admin.master')

@section('title', 'Edit Appointment')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Edit Appointment #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h2>
                    <p class="text-muted">Modify the appointment status.</p>
                </div>
                <div class="col-auto">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left mr-1"></i> Back to List
                        </a>
                    @endif
                    @if(auth()->user()->hasRole('doctor'))
                        <a href="{{ route('admin.doctor.myBookings') }}" class="btn btn-secondary">
                            <i class="fe fe-arrow-left mr-1"></i> Back to My Appointments
                        </a>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header">
                    <strong class="card-title">Patient & Schedule Details</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Patient Name --}}
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Patient Name</label>
                                <input type="text" class="form-control"
                                       value="{{ $booking->patient->name ?? '—' }}" readonly>
                            </div>

                            {{-- Phone --}}
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Phone Number</label>
                                <input type="text" class="form-control"
                                       value="{{ $booking->patient->phone ?? '—' }}" readonly>
                            </div>

                            {{-- Email --}}
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Email Address</label>
                                <input type="email" class="form-control"
                                       value="{{ $booking->patient->email ?? '—' }}" readonly>
                            </div>

                            <hr class="col-12 my-4">

                            {{-- Date --}}
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Date</label>
                                <input type="date" class="form-control"
                                       value="{{ \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d') }}" readonly>
                            </div>

                            {{-- Time --}}
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Time</label>
                                <input type="time" class="form-control"
                                       value="{{ \Carbon\Carbon::parse($booking->appointment_time)->format('H:i') }}" readonly>
                            </div>

                            {{-- Status (only editable field) --}}
                            <div class="form-group col-md-4">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select name="status" id="status" class="form-control custom-select">
                                    <option value="pending"   {{ $booking->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            {{-- Doctor (read-only display) --}}
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Doctor</label>
                                <input type="text" class="form-control"
                                       value="{{ $booking->doctor->user->name ?? 'N/A' }}" readonly>
                            </div>
                            @endif

                            {{-- Payment info (read-only display) --}}
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Payment Method</label>
                                <input type="text" class="form-control"
                                       value="{{ $booking->payment_method === 'card' ? 'Online (Card)' : 'Pay at Clinic' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Payment Status</label>
                                <input type="text" class="form-control"
                                       value="{{ ucfirst($booking->payment_status) }}" readonly>
                            </div>

                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fe fe-save mr-1"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection