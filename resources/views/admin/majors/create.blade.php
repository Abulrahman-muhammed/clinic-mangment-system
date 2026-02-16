@extends('admin.master')
@section('title', 'Create Department')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Create Department</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.major.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title">Title</label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter department title" 
                                       value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    rows="5" 
                                    placeholder="Write a short description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="image">Image</label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Department
                                </button>
                                <a href="{{ route('admin.major.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Back
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
