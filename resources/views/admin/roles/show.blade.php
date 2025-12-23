@extends('admin.master')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-semibold">Role Details</h4>
                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Main Card -->
            <div class="card shadow border-0">
                <div class="card-body">

                    <!-- Role Info -->
                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Role Name</h5>
                        <h4 class="fw-bold text-dark">{{ ucfirst($role->name) }}</h4>
                        <hr>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <h5 class="text-muted mb-3">Permissions</h5>

                        @if ($role->permissions->count() > 0)
                            <div class="row">
                                @foreach ($role->permissions as $permission)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <div class="border rounded p-3 bg-light text-center">
                                            {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No permissions assigned to this role.</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
