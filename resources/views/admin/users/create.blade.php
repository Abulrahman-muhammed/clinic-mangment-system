@extends('admin.master')
@section('title', 'Add User')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Add User</h2>

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

                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role">Role</label>
                                <select name="role" class="form-control">
                                    <option value="" disabled selected>Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add User</button>
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary"> Back</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
