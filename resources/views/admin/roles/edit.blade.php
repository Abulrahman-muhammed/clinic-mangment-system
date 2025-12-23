@extends('admin.master')
@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Edit Role</h4>
                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Role Name -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Role Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter role name"
                                       value="{{ old('name', $role->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">Permissions</label>

                                    <!-- Select All Button -->
                                    <button type="button" id="select-all" class="btn btn-sm btn-outline-primary">
                                        Select All
                                    </button>
                                </div>

                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox" 
                                                       type="checkbox"
                                                       name="permissions[]" 
                                                       value="{{ $permission->name }}"
                                                       id="perm_{{ $permission->id }}"
                                                       {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @error('permissions')
                                    <div class="text-danger small">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Role
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Select All Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        let allSelected = Array.from(checkboxes).every(cb => cb.checked);

        selectAllBtn.textContent = allSelected ? 'Deselect All' : 'Select All';

        selectAllBtn.addEventListener('click', function() {
            allSelected = !allSelected;
            checkboxes.forEach(cb => cb.checked = allSelected);
            selectAllBtn.textContent = allSelected ? 'Deselect All' : 'Select All';
        });
    });
</script>
@endsection
