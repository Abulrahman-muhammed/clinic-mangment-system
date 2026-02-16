@extends('admin.master')
@section('title', 'Add Doctor Schedule')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Add Doctor Schedule</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.schedule.store') }}" method="POST">
                        @csrf

                        <!-- Doctor Selection -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id" 
                                        class="form-control @error('doctor_id') is-invalid @enderror select2">
                                    <option value="">Select Doctor</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }} ({{ $doctor->major?->title ?? 'No Department' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Day Selection -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="day_of_week">Day of the Week</label>
                                <select name="day_of_week" 
                                        class="form-control @error('day_of_week') is-invalid @enderror">
                                    <option value="">Select Day</option>
                                    @foreach (['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                        <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('day_of_week')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Time Range -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time">Start Time</label>
                                <input type="time" 
                                       name="start_time" 
                                       class="form-control @error('start_time') is-invalid @enderror"
                                       value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time">End Time</label>
                                <input type="time" 
                                       name="end_time" 
                                       class="form-control @error('end_time') is-invalid @enderror"
                                       value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Add Schedule
                                </button>
                                <a href="{{ route('admin.schedule.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Back
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
