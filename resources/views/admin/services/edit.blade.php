@extends('admin.master')
@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Edit Service</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Service Name</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $service->name) }}" 
                                       placeholder="Enter service name">
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
                                       value="{{ old('price', $service->price) }}" 
                                       placeholder="Enter service price">
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
                                          placeholder="Enter description">{{ old('description', $service->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Image -->
                        @if($service->image)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label>Current Image</label><br>
                                <img src="{{ asset('storage/services/' . $service->image)  }}" 
                                     alt="Service Image" 
                                     width="100" 
                                     class="rounded shadow-sm border">
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Image -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="image">Change Image</label>
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
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Service
                                </button>
                                <a href="{{ route('admin.service.index') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-arrow-left"></i> Back
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
