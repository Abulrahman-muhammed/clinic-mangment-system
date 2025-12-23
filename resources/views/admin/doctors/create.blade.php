@extends('admin.master')
@section('title', 'Add Doctor')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Add Doctor</h2>
            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.doctor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Name Field -->
                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Name" 
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       placeholder="Phone" 
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email Field -->
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="Email" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Department Field -->
                            <div class="col-md-6 mb-3">
                                <label for="major_id">Department</label>
                                <select name="major_id" 
                                        class="form-control @error('major_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select Department</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                            {{ $major->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('major_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender Field -->
                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" 
                                        class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="bio">Bio</label>
                                <textarea name="bio" 
                                          id="bio" 
                                          cols="30" 
                                          rows="8" 
                                          class="form-control @error('bio') is-invalid @enderror" 
                                          placeholder="Write a short bio...">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Address Field -->
                            <div class="col-md-6 mb-3">
                                <label for="address">Address</label>
                                <input type="text" 
                                       name="address" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       placeholder="Address" 
                                       value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Consultation Fee Field -->
                            <div class="col-md-3 mb-3">
                                <label for="consultation_fee">Consultation Fee</label>
                                <input type="number" 
                                       step="0.01" 
                                       name="consultation_fee" 
                                       class="form-control @error('consultation_fee') is-invalid @enderror" 
                                       placeholder="Fee" 
                                       value="{{ old('consultation_fee') }}">
                                @error('consultation_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Years of Experience Field -->
                            <div class="col-md-3 mb-3">
                                <label for="years_of_experience">Years of Experience</label>
                                <input type="number" 
                                       name="years_of_experience" 
                                       class="form-control @error('years_of_experience') is-invalid @enderror" 
                                       placeholder="Years" 
                                       value="{{ old('years_of_experience') }}">
                                @error('years_of_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="image">Image</label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Doctor</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
