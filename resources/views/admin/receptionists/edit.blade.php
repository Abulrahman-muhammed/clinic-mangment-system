@extends('admin.master')
@section('title', 'Edit Receptionist')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 page-title mb-0">Edit Receptionist: {{ $receptionist->user->name }}</h2>
                <a href="{{ route('admin.receptionist.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body p-4">
                    <form action="{{ route('admin.receptionist.update', $receptionist->id) }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="font-weight-bold">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $receptionist->user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $receptionist->user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="font-weight-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $receptionist->user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="font-weight-bold">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter new password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="image" class="font-weight-bold">Update Profile Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                
                                @if($receptionist->image)
                                    <div class="mt-3 d-flex align-items-center">
                                        <span class="text-muted small mr-3">Current Image:</span>
                                        <img src="{{ asset('images/receptionists/' . $receptionist->image) }}" 
                                             alt="Current profile" class="img-thumbnail shadow-sm" width="80">
                                    </div>
                                @endif
                                
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="address" class="font-weight-bold">Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                       value="{{ old('address', $receptionist->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="shift" class="font-weight-bold">Work Shift</label>
                                <select name="shift" class="form-control @error('shift') is-invalid @enderror">
                                    <option value="">Select shift</option>
                                    <option value="morning" {{ old('shift', $receptionist->shift) == 'morning' ? 'selected' : '' }}>Morning Shift</option>
                                    <option value="evening" {{ old('shift', $receptionist->shift) == 'evening' ? 'selected' : '' }}>Evening Shift</option>
                                </select>
                                @error('shift')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                                <i class="fas fa-check-circle mr-1"></i> Update Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection