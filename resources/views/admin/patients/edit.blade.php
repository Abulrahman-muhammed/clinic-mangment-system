@extends('admin.master')
@section('title', 'Edit Patient')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Edit Patient</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.patient.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $patient->name) }}"
                                       placeholder="Enter patient name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $patient->email) }}"
                                       placeholder="Enter patient email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $patient->phone) }}"
                                       placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date of Birth & Gender -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date"
                                       name="date_of_birth"
                                       class="form-control @error('date_of_birth') is-invalid @enderror"
                                       value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender"
                                        class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Blood Type & Address -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="blood_type">Blood Type</label>
                                <select name="blood_type"
                                        class="form-control @error('blood_type') is-invalid @enderror">
                                    <option value="">Select blood type</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'] as $type)
                                        <option value="{{ $type }}" {{ old('blood_type', $patient->blood_type) == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blood_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="address">Address</label>
                                <input type="text"
                                       name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $patient->address) }}"
                                       placeholder="Enter address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical History -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="medical_history">Medical History</label>
                                <textarea name="medical_history"
                                          rows="4"
                                          class="form-control @error('medical_history') is-invalid @enderror"
                                          placeholder="Enter patient's medical history">{{ old('medical_history', $patient->medical_history) }}</textarea>
                                @error('medical_history')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Patient
                                </button>
                                <a href="{{ route('admin.patient.index') }}" class="btn btn-secondary ms-2">
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
