@extends('admin.master')
@section('title', 'Create Visit')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Create Visit</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.visit.store') }}" method="POST">
                        @csrf

                        <!-- Patient & Doctor -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_id">Patient</label>
                                <select name="patient_id"
                                        class="form-control select2 @error('patient_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id"
                                        class="form-control select2 @error('doctor_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            Dr. {{ $doctor->user->name }} — {{ $doctor->major->title ?? 'General' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Receptionist & Status -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="receptionist_id">Receptionist</label>
                                <select name="receptionist_id"
                                        class="form-control select2 @error('receptionist_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select receptionist</option>
                                    @foreach($receptionists as $receptionist)
                                        <option value="{{ $receptionist->id }}" {{ old('receptionist_id') == $receptionist->id ? 'selected' : '' }}>
                                            {{ $receptionist->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('receptionist_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                    <option value="" disabled selected>Select status</option>
                                    <option value="in_progress"   {{ old('status') == 'in_progress'   ? 'selected' : '' }}>In Progress</option>
                                    <option value="done"    {{ old('status') == 'done'    ? 'selected' : '' }}>Done</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="notes">Notes</label>
                                <textarea name="notes"
                                        class="form-control @error('notes') is-invalid @enderror"
                                        rows="4"
                                        placeholder="Enter any visit notes or observations...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Visit
                                </button>
                                <a href="{{ route('admin.visit.index') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-arrow-left"></i> Back
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

@push('scripts')
<script>
    $(function () {
        if ($.fn.select2) {
            $('.select2').select2({ theme: 'bootstrap4' });
        }
    });
</script>
@endpush