@extends('admin.master')
@section('title', 'Edit Receptionist')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Edit Receptionist</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.receptionist.update', $receptionist->id) }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- User Info -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter receptionist full name" 
                                       value="{{ old('name', $receptionist->user->name) }}">
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
                                       placeholder="Enter email" 
                                       value="{{ old('email', $receptionist->user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       placeholder="Enter phone number" 
                                       value="{{ old('phone', $receptionist->user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password">New Password (optional)</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Enter new password if needed">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-md-6 mb-3">
                                <label for="image">Profile Image (optional)</label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($receptionist->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/receptionists/' . $receptionist->image) }}" 
                                             alt="Receptionist Image" 
                                             class="img-thumbnail" width="100">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="address">Address</label>
                                <input type="text" 
                                       name="address" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       placeholder="Enter address" 
                                       value="{{ old('address', $receptionist->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Shift -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shift">Shift</label>
                                <select name="shift" class="form-control @error('shift') is-invalid @enderror">
                                    <option value="">Select shift</option>
                                    <option value="morning" {{ old('shift', $receptionist->shift) == 'morning' ? 'selected' : '' }}>Morning</option>
                                    <option value="evening" {{ old('shift', $receptionist->shift) == 'evening' ? 'selected' : '' }}>Evening</option>
                                </select>
                                @error('shift')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $receptionist->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $receptionist->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Receptionist
                                </button>
                                <a href="{{ route('admin.receptionist.index') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-arrow-left"></i> Cancel
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
