@extends('admin.master')
@section('title', 'Create Role')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">Create Role</h2>

                <div class="card shadow">
                    <div class="card-body">

                        <form action="{{ route('admin.role.store') }}" method="POST">
                            @csrf

                            <!-- Role Name -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Role Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter role name" value="{{ old('name') }}">
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
                                                    <input class="form-check-input permission-checkbox" type="checkbox"
                                                        name="permissions[]" value="{{ $permission->name }}"
                                                        id="perm_{{ $permission->id }}">
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
                                        <i class="fas fa-save"></i> Create Role
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
            let allSelected = false;

            selectAllBtn.addEventListener('click', function() {
                allSelected = !allSelected;
                checkboxes.forEach(cb => cb.checked = allSelected);
                selectAllBtn.textContent = allSelected ? 'Deselect All' : 'Select All';
            });
        });
    </script>
@endsection
