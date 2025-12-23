@extends('admin.master')
@section('title', 'Edit Doctor')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Edit Doctor</h2>
            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $doctor->user->name) }}" placeholder="Name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $doctor->user->email) }}" placeholder="Email">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $doctor->user->phone) }}" placeholder="Phone">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Leave blank to keep current">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Department -->
                            <div class="col-md-6 mb-3">
                                <label for="major_id">Department</label>
                                <select name="major_id" class="form-control @error('major_id') is-invalid @enderror">
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" 
                                            {{ old('major_id', $doctor->major_id) == $major->id ? 'selected' : '' }}>
                                            {{ $major->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('major_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Consultation Fee -->
                            <div class="col-md-6 mb-3">
                                <label for="consultation_fee">Consultation Fee (EGP)</label>
                                <input type="number" step="0.01" name="consultation_fee"
                                       class="form-control @error('consultation_fee') is-invalid @enderror"
                                       value="{{ old('consultation_fee', $doctor->consultation_fee) }}" placeholder="Fee">
                                @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Experience -->
                            <div class="col-md-6 mb-3">
                                <label for="years_of_experience">Years of Experience</label>
                                <input type="number" name="years_of_experience"
                                       class="form-control @error('years_of_experience') is-invalid @enderror"
                                       value="{{ old('years_of_experience', $doctor->years_of_experience) }}" placeholder="Years">
                                @error('years_of_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="address">Address</label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $doctor->address) }}" placeholder="Address">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status', $doctor->status) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $doctor->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="bio">Bio</label>
                                <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror"
                                          placeholder="Write short bio...">{{ old('bio', $doctor->bio) }}</textarea>
                                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image"
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if($doctor->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/doctors/' . $doctor->image) }}" width="100" alt="Doctor Image">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Doctor</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
