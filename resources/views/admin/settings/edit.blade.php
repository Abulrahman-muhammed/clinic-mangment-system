@extends('admin.master')
@section('title', 'General Settings')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-4">Clinic General Settings</h2>

            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">
                    {{-- لاحظ استدعاء الكلاس مباشرة هنا أو تمريره من الكنترولر --}}
                    @php $generalSettings = app(App\Settings\GeneralSettings::class); @endphp
{{-- Success Message with Dismiss Button --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fe fe-check-circle fe-16 mr-2"></i> {{-- أيقونة اختيارية لو بتستخدم Feather Icons --}}
            <strong>Success!</strong> &nbsp; {{ session('success') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Basic Information --}}
                        <h4 class="mb-3 text-primary">Basic Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Clinic Name</label>
                                <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                       name="site_name" value="{{ old('site_name', $generalSettings->site_name) }}">
                                @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Clinic Email</label>
                                <input type="email" class="form-control @error('site_email') is-invalid @enderror" 
                                       name="site_email" value="{{ old('site_email', $generalSettings->site_email) }}">
                                @error('site_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('site_phone') is-invalid @enderror" 
                                       name="site_phone" value="{{ old('site_phone', $generalSettings->site_phone) }}">
                                @error('site_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control @error('site_address') is-invalid @enderror" 
                                       name="site_address" value="{{ old('site_address', $generalSettings->site_address) }}">
                                @error('site_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Social Media Links --}}
                        <h4 class="mb-3 text-primary">Social Media</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook URL</label>
                                <input type="url" class="form-control" name="facebook_url" value="{{ old('facebook_url', $generalSettings->facebook_url) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter URL</label>
                                <input type="url" class="form-control" name="twitter_url" value="{{ old('twitter_url', $generalSettings->twitter_url) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram URL</label>
                                <input type="url" class="form-control" name="instagram_url" value="{{ old('instagram_url', $generalSettings->instagram_url) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">LinkedIn URL</label>
                                <input type="url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url', $generalSettings->linkedin_url) }}">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">
                                <i class="fe fe-save fe-16 mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection