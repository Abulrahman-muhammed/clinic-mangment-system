@extends('admin.master')

@section('title', 'Services')

@section('content')

@can('view_services')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Services Management</h2>
                    <p class="text-muted">Manage available clinic services, pricing, and descriptions</p>
                </div>
                <div class="col-auto">
                    @can('delete_services')
                    <a href="{{ route('admin.service.trashed') }}" class="btn btn-outline-secondary mr-2">
                        <i class="fe fe-archive mr-1"></i> Archived Services
                    </a>
                    @endcan

                    @can('create_services')
                    <a href="{{ route('admin.service.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Service
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-circle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Filters Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.service.index') }}" id="filter-form">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="search">Service Name / Description</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ request('search') }}" placeholder="Search by name or keywords...">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="price_range">Price Range</label>
                                <select name="price_range" id="price_range" class="form-control">
                                    <option value="">All Prices</option>
                                    <option value="free"    {{ request('price_range') == 'free'    ? 'selected' : '' }}>Free</option>
                                    <option value="low"     {{ request('price_range') == 'low'     ? 'selected' : '' }}>Under 500 EGP</option>
                                    <option value="medium"  {{ request('price_range') == 'medium'  ? 'selected' : '' }}>500 – 2000 EGP</option>
                                    <option value="high"    {{ request('price_range') == 'high'    ? 'selected' : '' }}>Above 2000 EGP</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <a href="{{ route('admin.service.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Services Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Services List</strong>
                        <span class="badge badge-primary badge-pill">{{ $services->total() }} Total</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th style="width: 80px;">Image</th>
                                    <th>Service Details</th>
                                    <th>Price</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $services->firstItem() + $loop->index }}</td>

                                        <td>
                                            <div class="avatar avatar-md">
                                                @if($service->image)
                                                    <img src="{{ asset('storage/services/' . $service->image) }}"
                                                         alt="{{ $service->name }}"
                                                         class="avatar-img rounded border shadow-sm"
                                                         onerror="this.parentElement.innerHTML='<div class=\'avatar-img rounded bg-soft-primary d-flex align-items-center justify-content-center border\'><i class=\'fe fe-activity text-primary\'></i></div>'">
                                                @else
                                                    <div class="avatar-img rounded bg-soft-primary d-flex align-items-center justify-content-center border">
                                                        <i class="fe fe-activity text-primary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <strong>{{ $service->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($service->description, 70) }}</small>
                                        </td>

                                        <td>
                                            @if($service->price)
                                                <span class="badge badge-soft-success px-3">
                                                    <i class="fe fe-tag mr-1"></i>
                                                    {{ number_format($service->price, 2) }} EGP
                                                </span>
                                            @else
                                                <span class="badge badge-soft-info px-3">
                                                    <i class="fe fe-gift mr-1"></i> Free
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">

                                                @can('edit_services')
                                                <a href="{{ route('admin.service.edit', $service) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_services')
                                                <form action="{{ route('admin.service.destroy', $service) }}"
                                                      method="POST"
                                                      id="delete-form-{{ $service->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete({{ $service->id }}, '{{ addslashes($service->name) }}')"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" title="Archive">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-activity fe-24 mb-3"></i>
                                                <p class="mb-0">No services found.</p>
                                                @can('create_services')
                                                <a href="{{ route('admin.service.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-plus"></i> Add First Service
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($services->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} entries
                        </div>
                        {{ $services->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@else
    <div class="alert alert-warning text-center">
        <i class="fe fe-alert-triangle mr-2"></i>
        You don't have permission to view services.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md { width: 52px; height: 52px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-primary { background-color: rgba(27, 104, 255, 0.1); }
    .badge-soft-success { color: #28a745; background-color: rgba(40, 167, 69, 0.1); }
    .badge-soft-info    { color: #17a2b8; background-color: rgba(23, 162, 184, 0.1); }
    .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.02); }
    thead.thead-light th {
        color: #6c757d;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Archive Service?',
            html:  "<strong>" + name + "</strong> will be moved to archives!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Archive it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush