@extends('admin.master')
@section('title', 'Create Patient')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Create Patient</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.patient.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter patient full name" 
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="Enter patient email" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       placeholder="Enter phone number" 
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row">

                            <!-- Date of Birth -->
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" 
                                       name="date_of_birth" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                                        <div class="col-md-6 mb-3">
                                <label for="address">Address</label>
                                <input type="text" 
                                       name="address" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       placeholder="Enter patient address" 
                                       value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" 
                                        class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" disabled selected>Select gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Blood Type -->
                            <div class="col-md-6 mb-3">
                                <label for="blood_type">Blood Type</label>
                                <select name="blood_type" 
                                        class="form-control @error('blood_type') is-invalid @enderror">
                                    <option value="" selected disabled>Select blood type</option>
                                    <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="unknown" {{ old('blood_type') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                </select>
                                @error('blood_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Medical History -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="medical_history">Medical History</label>
                                <textarea name="medical_history" 
                                          class="form-control @error('medical_history') is-invalid @enderror" 
                                          rows="4" 
                                          placeholder="Enter any previous medical history...">{{ old('medical_history') }}</textarea>
                                @error('medical_history')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Patient
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
