@extends('admin.master')

@section('title', 'Edit Appointment')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Edit Appointment #{{ $booking->id }}</h2>
                    <p class="text-muted">Modify patient information or reschedule the appointment.</p>
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
                            <div class="form-group col-md-6">
                                <label for="name" class="font-weight-bold">Patient Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $booking->name) }}" readonly>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone" class="font-weight-bold">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $booking->phone) }}" readonly>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="email" class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $booking->email) }}" readonly>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <hr class="col-12 my-4">

                            <div class="form-group col-md-4">
                                <label for="date" class="font-weight-bold">Date</label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ old('date', \Carbon\Carbon::parse($booking->date)->format('Y-m-d')) }}" readonly>
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="time" class="font-weight-bold">Time</label>
                                <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" 
                                       value="{{ old('time', \Carbon\Carbon::parse($booking->date)->format('H:i')) }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select name="status" id="status" class="form-control custom-select">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}> Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}> Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}> Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}> Cancelled</option>
                                </select>
                            </div>

                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('receptionist'))
                            <div class="form-group col-md-12">
                                <label for="doctor_id" class="font-weight-bold">Assign Doctor</label>
                                <input type="text" name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" 
                                       value="{{ old('doctor_id', $booking->doctor->user->name) }}" readonly>
                            </div>
                            @endif
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update Appointment Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection