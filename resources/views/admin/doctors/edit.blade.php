@extends('admin.master')
@section('title', 'Edit Doctor')
@section('content')

@can('edit_doctors')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Edit Doctor</h2>
                    <p class="text-muted">Update doctor information</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-triangle mr-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Personal Information Card -->
                    <div class="col-md-8">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Personal Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $doctor->user->name) }}" 
                                               placeholder="Enter full name">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $doctor->user->email) }}" 
                                               placeholder="example@email.com">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Phone -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $doctor->user->phone) }}" 
                                               placeholder="+20 xxx xxx xxxx">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6 mb-3">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Address -->
                                    <div class="col-md-12 mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address"
                                               class="form-control @error('address') is-invalid @enderror"
                                               value="{{ old('address', $doctor->address) }}" 
                                               placeholder="Enter address">
                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Password -->
                                    <div class="col-md-12 mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Leave blank to keep current password">
                                        <small class="form-text text-muted">
                                            <i class="fe fe-info"></i> Only fill if you want to change the password
                                        </small>
                                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Professional Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Department -->
                                    <div class="col-md-6 mb-3">
                                        <label for="major_id">Department <span class="text-danger">*</span></label>
                                        <select name="major_id" id="major_id" class="form-control select2 @error('major_id') is-invalid @enderror">
                                            <option value="">Select Department</option>
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}" 
                                                    {{ old('major_id', $doctor->major_id) == $major->id ? 'selected' : '' }}>
                                                    {{ $major->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('major_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Experience -->
                                    <div class="col-md-6 mb-3">
                                        <label for="years_of_experience">Years of Experience</label>
                                        <input type="number" name="years_of_experience" id="years_of_experience"
                                               class="form-control @error('years_of_experience') is-invalid @enderror"
                                               value="{{ old('years_of_experience', $doctor->years_of_experience) }}" 
                                               placeholder="0" min="0">
                                        @error('years_of_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Consultation Fee -->
                                    <div class="col-md-12 mb-3">
                                        <label for="consultation_fee">Consultation Fee (EGP)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="consultation_fee" id="consultation_fee"
                                                   class="form-control @error('consultation_fee') is-invalid @enderror"
                                                   value="{{ old('consultation_fee', $doctor->consultation_fee) }}" 
                                                   placeholder="0.00" min="0">
                                            <div class="input-group-append">
                                                <span class="input-group-text">EGP</span>
                                            </div>
                                            @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Bio -->
                                    <div class="col-md-12 mb-3">
                                        <label for="bio">Biography</label>
                                        <textarea name="bio" id="bio" rows="5" 
                                                  class="form-control @error('bio') is-invalid @enderror"
                                                  placeholder="Write a short bio about the doctor...">{{ old('bio', $doctor->bio) }}</textarea>
                                        <small class="form-text text-muted">Brief description about qualifications and expertise</small>
                                        @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Image Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Doctor Image</strong>
                            </div>
                            <div class="card-body text-center">
                                <!-- Current Image -->
                                <div class="mb-3">
                                    @if($doctor->image)
                                        <img src="{{ asset('images/doctors/' . $doctor->image) }}" 
                                             id="preview-image"
                                             class="img-fluid rounded-circle" 
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             alt="Doctor Image">
                                    @else
                                        <img src="{{ asset('admin-assets/img/default-doctor.png') }}" 
                                             id="preview-image"
                                             class="img-fluid rounded-circle" 
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             alt="Default Image">
                                    @endif
                                </div>

                                <!-- Upload Input -->
                                <div class="custom-file">
                                    <input type="file" name="image" id="image"
                                           class="custom-file-input @error('image') is-invalid @enderror"
                                           accept="image/*"
                                           onchange="previewImage(event)">
                                    <label class="custom-file-label" for="image">Choose image</label>
                                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <small class="form-text text-muted mt-2">
                                    Recommended: Square image, max 2MB
                                </small>
                            </div>
                        </div>


                        <!-- Actions Card -->
                        <div class="card shadow">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block mb-2">
                                    <i class="fe fe-save"></i> Update Doctor
                                </button>
                                <a href="{{ route('admin.doctor.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-x"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endcan

@endsection

@push('styles')
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .custom-file-label::after {
        content: "Browse";
    }
    label {
        font-weight: 500;
        color: #495057;
    }
    .text-danger {
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview-image');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
        
        // Update file label
        const fileName = event.target.files[0].name;
        const label = event.target.nextElementSibling;
        label.textContent = fileName;
    }

    // Initialize Select2 if available
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select Department',
                allowClear: true
            });
        }
    });
</script>
@endpush