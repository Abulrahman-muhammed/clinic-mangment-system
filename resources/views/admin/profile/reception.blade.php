@extends('admin.master')

@section('title', 'Edit Receptionist Profile')

@push('styles')
<style>
    .profile-card { border-radius: 15px; overflow: hidden; }
    .profile-header-bg {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        height: 120px;
    }
    .avatar-wrapper { margin-top: -60px; position: relative; display: inline-block; }
    .avatar-wrapper img { border: 5px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); object-fit: cover; }
    .form-label { font-weight: 600; color: #4a5568; font-size: 0.85rem; text-transform: uppercase; }
    .section-title { border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; color: #38b2ac; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0 text-dark">Receptionist Profile</h2>
                    <p class="text-muted">Update personal information and work preferences.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">
                    <i class="fe fe-corner-up-left mr-1"></i> Dashboard
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            @endif

            <div class="card shadow profile-card mb-5">
                <div class="profile-header-bg"></div>
                <div class="card-body pt-0">
                    
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

                    <form action="{{ route('admin.profile.updateReceptionist', $receptionist) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center">
                            <div class="avatar-wrapper mb-4">
                                @if($receptionist->image)
                                    <img src="{{ asset('images/receptionists/' . $receptionist->image) }}" class="rounded-circle" width="130" height="130" id="previewImg">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($receptionist->user->name) }}&background=38b2ac&color=fff&size=128" class="rounded-circle" width="130" id="previewImg">
                                @endif
                                <div class="mt-2">
                                    <label for="image" class="btn btn-sm btn-light shadow-sm">
                                        <i class="fe fe-camera mr-1"></i> Change Photo
                                    </label>
                                    <input type="file" name="image" id="image" class="d-none" onchange="previewFile(this)">
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title"><i class="fe fe-user mr-2"></i> Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $receptionist->user->name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $receptionist->user->email) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $receptionist->user->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Work Shift</label>
                                <input type="text" class="form-control bg-light text-capitalize" 
                                       value="{{ $receptionist->work_shift == 'morning' ? 'Morning' : 'Evening' }}" readonly>
                                <small class="text-info">Contact admin to change your assigned shift.</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Residential Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $receptionist->address) }}" placeholder="Enter residential address">
                            </div>
                        </div>

                        <h5 class="section-title mt-4"><i class="fe fe-lock mr-2"></i> Security Update</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
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

@push('scripts')
<script>
    function previewFile(input){
        var file = input.files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush