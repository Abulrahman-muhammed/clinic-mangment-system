@extends('admin.master')
@section('title', 'Edit User')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Edit User</h2>

            <div class="card shadow">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $user->name) }}" placeholder="Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" placeholder="Email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $user->phone) }}" placeholder="Phone">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="">-- Select Role --</option>
                                    @foreach ($roles as $id => $roleName)
                                        <option value="{{ $roleName }}"
                                            {{ (old('role', $userRole ?? '') == $roleName) ? 'selected' : '' }}>
                                            {{ ucfirst($roleName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">Update User</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary px-4">Back</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
