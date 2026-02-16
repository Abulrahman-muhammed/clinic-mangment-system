@extends('admin.master')
@section('title', 'Create Receptionist')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 page-title mb-0">Create New Receptionist</h2>
                <a href="{{ route('admin.receptionist.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body p-4">
                    <form action="{{ route('admin.receptionist.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="font-weight-bold">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="e.g. Ahmed Mohamed" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="example@clinic.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="font-weight-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       placeholder="01xxxxxxxxx" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Min. 8 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="image" class="font-weight-bold">Profile Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="address" class="font-weight-bold">Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                       placeholder="Enter residential address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="shift" class="font-weight-bold">Work Shift</label>
                                <select name="shift" class="form-control @error('shift') is-invalid @enderror">
                                    <option value="">Choose shift...</option>
                                    <option value="morning" {{ old('shift') == 'morning' ? 'selected' : '' }}>Morning Shift</option>
                                    <option value="evening" {{ old('shift') == 'evening' ? 'selected' : '' }}>Evening Shift</option>
                                </select>
                                @error('shift')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                                <i class="fas fa-save mr-1"></i> Save Receptionist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection