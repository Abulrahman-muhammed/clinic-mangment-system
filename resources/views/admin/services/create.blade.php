@extends('admin.master')
@section('title', 'Create Service')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Create Service</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Service Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter service name" 
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="price">Price</label>
                                <input type="number" 
                                       name="price" 
                                       step="0.01" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       placeholder="Enter price (optional)" 
                                       value="{{ old('price') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Write a short description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="image">Image</label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Service
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
