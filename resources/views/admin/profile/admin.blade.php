@extends('admin.master')

@section('title', 'Edit My Profile')

@push('styles')
<style>
    .profile-card {
        border-radius: 15px;
        overflow: hidden;
    }
    .profile-header-bg {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        height: 100px;
    }
    .avatar-wrapper {
        margin-top: -50px;
        position: relative;
        display: inline-block;
    }
    .avatar-wrapper img {
        border: 5px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
        color: #a0aec0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0 page-title text-dark">Account Settings</h2>
                    <p class="text-muted">Manage your personal information and security.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary shadow-sm px-4">
                    <i class="fe fe-corner-up-left mr-1"></i> Dashboard
                </a>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-left" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card shadow profile-card mb-4">
                <div class="profile-header-bg"></div>
                <div class="card-body pt-0 text-center">
                    <div class="avatar-wrapper mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128" 
                                class="rounded-circle" width="120" alt="Admin Avatar">
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-left" role="alert">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.updateAdmin', $user) }}" method="POST" class="text-left">
                        @csrf
                        @method('PUT')

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fe fe-user"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" placeholder="Enter your name">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fe fe-mail"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" placeholder="email@example.com">
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="phone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fe fe-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}" placeholder="+20 123 456 7890">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3 text-primary"><i class="fe fe-lock mr-2"></i> Security Update</h5>
                        <p class="small text-muted mb-4">Keep these fields empty if you do not want to change your password.</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="••••••••">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 px-0 mt-3 text-right">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                <i class="fe fe-save mr-2"></i> Update Profile
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection