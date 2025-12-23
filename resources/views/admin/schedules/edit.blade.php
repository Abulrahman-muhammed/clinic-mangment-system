@extends('admin.master')
@section('title', 'Edit Doctor Schedule')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Edit Doctor Schedule</h2>

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('admin.schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                                    <option value="">-- Select Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $schedule->doctor_id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="day_of_week">Day of Week</label>
                                <select name="day_of_week" class="form-control @error('day_of_week') is-invalid @enderror">
                                    @foreach(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                                        <option value="{{ $day }}" {{ $schedule->day_of_week == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('day_of_week')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time">Start Time</label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                    value="{{ $schedule->start_time }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time">End Time</label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                    value="{{ $schedule->end_time }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fe fe-save"></i> Update Schedule
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
