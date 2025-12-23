@extends('admin.master')
@section('title', 'Edit Department')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Edit Department</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.major.update', $major) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title">Title</label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Title" 
                                       value="{{ old('title', $major->title) }}">
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
                                <textarea name="description" 
                                          id="description" 
                                          cols="30" 
                                          rows="10"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Enter department description">{{ old('description', $major->description) }}</textarea>
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
                                @if($major->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('images/majors/' . $major->image) }}" 
                                             alt="Department Image" width="150" height="150" 
                                             style="object-fit: cover; border-radius:5px;">
                                    </div>
                                @endif
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
                                <button type="submit" class="btn btn-primary">Update Department</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
