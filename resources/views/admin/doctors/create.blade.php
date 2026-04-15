@extends('admin.master')

@section('title', 'Add New Doctor')

@section('content')
<div class="container-fluid">
    @can('create_doctors')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Add New Doctor</h2>
                    <p class="text-muted">Create a new doctor profile with credentials and specialization</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Doctors
                    </a>
                </div>
            </div>
                {{-- validation error messages --}}
                {{-- @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fe fe-alert-triangle mr-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif --}}
            <form action="{{ route('admin.doctor.store') }}" method="POST" enctype="multipart/form-data" id="doctorForm">
                @csrf

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-user text-primary mr-2"></i> Account Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fe fe-user"></i></span></div>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                           class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fe fe-phone"></i></span></div>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                                           class="form-control @error('phone') is-invalid @enderror" placeholder="e.g., 01012345678" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fe fe-mail"></i></span></div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                           class="form-control @error('email') is-invalid @enderror" placeholder="doctor@hospital.com" required autocomplete="email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fe fe-lock"></i></span></div>
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 characters" required autocomplete="new-password">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <small class="form-text text-muted"><i class="fe fe-info mr-1"></i> Security: Minimum 8 characters.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-briefcase text-primary mr-2"></i> Professional Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="major_id">Department <span class="text-danger">*</span></label>
                                <select name="major_id" id="major_id" class="form-control select2 @error('major_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Department</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" @selected(old('major_id') == $major->id)>{{ $major->title }}</option>
                                    @endforeach
                                </select>
                                @error('major_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male" @selected(old('gender') == 'male')>Male</option>
                                    <option value="female" @selected(old('gender') == 'female')>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="years_of_experience">Years of Experience</label>
                                <div class="input-group">
                                    <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience') }}" 
                                           class="form-control @error('years_of_experience') is-invalid @enderror" min="0" max="60">
                                    <div class="input-group-append"><span class="input-group-text">Years</span></div>
                                    @error('years_of_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="consultation_fee">Consultation Fee</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="consultation_fee" id="consultation_fee" value="{{ old('consultation_fee') }}" 
                                           class="form-control @error('consultation_fee') is-invalid @enderror" min="0">
                                    <div class="input-group-append"><span class="input-group-text">EGP</span></div>
                                    @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fe fe-map-pin"></i></span></div>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}" 
                                           class="form-control @error('address') is-invalid @enderror" placeholder="Enter clinic or office address">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="bio">Biography</label>
                                <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" 
                                          placeholder="Write a brief professional biography...">{{ old('bio') }}</textarea>
                                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fe fe-image text-primary mr-2"></i> Profile Photo</h5>
                    </div>
                    <div class="card-body">
                        <div class="custom-file mb-3">
                            <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this)">
                            <label class="custom-file-label" for="image">Choose photo...</label>
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div id="imagePreview" class="text-center @if(!old('image')) d-none @endif">
                            <img src="#" alt="Preview" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-5">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><span class="text-danger">*</span> Required fields</span>
                        <div>
                            <a href="{{ route('admin.doctor.index') }}" class="btn btn-light border mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fe fe-save mr-1"></i> Create Doctor Profile
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-warning border-0 shadow-sm text-center p-5">
        <i class="fe fe-lock fe-32 mb-3 d-block"></i>
        <h4>Access Denied</h4>
        <p class="mb-0">You don't have the necessary permissions to create new doctor profiles.</p>
    </div>
    @endcan
</div>
@endsection

@push('styles')
<style>
    .card { border-radius: 0.75rem; border: none; }
    .card-header { background-color: transparent; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 1.5rem; }
    .input-group-text { background-color: #f8f9fa; color: #6c757d; border-right: none; }
    .input-group > .form-control { border-left: none; }
    .input-group > .form-control:focus { border-color: #ced4da; }
    .select2-container--bootstrap4 .select2-selection { border-radius: 0.25rem; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        // Initialize Select2
        if ($.fn.select2) {
            $('.select2').select2({ theme: 'bootstrap4', width: '100%' });
        }

        // File Input Label & Image Preview
        window.previewImage = function(input) {
            const $preview = $('#imagePreview');
            const $label = $(input).siblings('.custom-file-label');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const fileName = input.files[0].name;
                
                $label.addClass('selected').html(fileName);
                
                reader.onload = function(e) {
                    $preview.removeClass('d-none').find('img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $preview.addClass('d-none');
                $label.removeClass('selected').html('Choose photo...');
            }
        }
    });
</script>
@endpush