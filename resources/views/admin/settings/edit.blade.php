@extends('admin.master')
@section('title', 'Settings')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <h2 class="h5 page-title mb-4">Home Page Settings</h2>

            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Hero Section --}}
                        <h4 class="mb-3">Hero Section</h4>
                        <div class="mb-3">
                            <label class="form-label">Image</label><br>
                            <img src="{{ asset('images/settings/' . settings('hero_image')) }}" 
                                 alt="" class="mb-2" style="width:200px; border-radius:5px;">
                            <input type="file" class="form-control @error('hero_image') is-invalid @enderror" name="hero_image">
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('hero_title') is-invalid @enderror" 
                                   name="hero_title" value="{{ old('hero_title', settings('hero_title')) }}">
                            @error('hero_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('hero_description') is-invalid @enderror" 
                                      name="hero_description" rows="4">{{ old('hero_description', settings('hero_description')) }}</textarea>
                            @error('hero_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>

                        {{-- Services Section --}}
                        <h4 class="mb-3">Services Cards</h4>
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="mb-3">
                                <label class="form-label">Service {{ $i }} Image</label><br>
                                <img src="{{ asset('images/settings/' . settings('service_image_' . $i)) }}" 
                                     alt="" style="width:50px; margin-bottom:10px;">
                                <input type="file" class="form-control @error('service_image_'.$i) is-invalid @enderror" 
                                       name="service_image_{{ $i }}">
                                @error('service_image_'.$i)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service {{ $i }} Title</label>
                                <input type="text" class="form-control @error('service_title_'.$i) is-invalid @enderror" 
                                       name="service_title_{{ $i }}" value="{{ old('service_title_'.$i, settings('service_title_'.$i)) }}">
                                @error('service_title_'.$i)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service {{ $i }} Description</label>
                                <textarea class="form-control @error('service_description_'.$i) is-invalid @enderror" 
                                          name="service_description_{{ $i }}" rows="3">{{ old('service_description_'.$i, settings('service_description_'.$i)) }}</textarea>
                                @error('service_description_'.$i)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                        @endfor

                        {{-- App Section --}}
                        <h4 class="mb-3">App Section</h4>
                        <div class="mb-3">
                            <label class="form-label">Image</label><br>
                            <img src="{{ asset('images/settings/' . settings('app_image')) }}" 
                                 alt="" style="width:200px; border-radius:5px;" class="mb-2">
                            <input type="file" class="form-control @error('app_image') is-invalid @enderror" name="app_image">
                            @error('app_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('app_title') is-invalid @enderror" 
                                   name="app_title" value="{{ old('app_title', settings('app_title')) }}">
                            @error('app_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('app_description') is-invalid @enderror" 
                                      name="app_description" rows="4">{{ old('app_description', settings('app_description')) }}</textarea>
                            @error('app_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>

                        {{-- Footer --}}
                        <h4 class="mb-3">Footer</h4>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('footer_title') is-invalid @enderror" 
                                   name="footer_title" value="{{ old('footer_title', settings('footer_title')) }}">
                            @error('footer_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('footer_description') is-invalid @enderror" 
                                      name="footer_description" rows="3">{{ old('footer_description', settings('footer_description')) }}</textarea>
                            @error('footer_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                Update Settings
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
