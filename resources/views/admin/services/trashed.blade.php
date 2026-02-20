@extends('admin.master')

@section('title', 'Archived Services')

@section('content')

@can('delete_services')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Header -->
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Archived Services</h2>
                    <p class="text-muted">View and manage archived clinic services</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.service.index') }}" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left mr-1"></i> Back to Services
                    </a>
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
                    <form method="GET" action="{{ route('admin.service.trashed') }}" id="filter-form">
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
                                    <option value="free"   {{ request('price_range') == 'free'   ? 'selected' : '' }}>Free</option>
                                    <option value="low"    {{ request('price_range') == 'low'    ? 'selected' : '' }}>Under 500 EGP</option>
                                    <option value="medium" {{ request('price_range') == 'medium' ? 'selected' : '' }}>500 – 2000 EGP</option>
                                    <option value="high"   {{ request('price_range') == 'high'   ? 'selected' : '' }}>Above 2000 EGP</option>
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
                                <a href="{{ route('admin.service.trashed') }}" class="btn btn-secondary btn-block">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archived Services Table Card -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="card-title">Archived Services List</strong>
                        <span class="badge badge-warning badge-pill">{{ $services->total() }} Archived</span>
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
                                    <th>Archived On</th>
                                    <th class="text-center" style="width: 130px;">Actions</th>
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
                                                         class="avatar-img rounded border shadow-sm opacity-50"
                                                         onerror="this.parentElement.innerHTML='<div class=\'avatar-img rounded bg-soft-warning d-flex align-items-center justify-content-center border\'><i class=\'fe fe-activity text-warning\'></i></div>'">
                                                @else
                                                    <div class="avatar-img rounded bg-soft-warning d-flex align-items-center justify-content-center border">
                                                        <i class="fe fe-activity text-warning"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <strong class="text-muted">{{ $service->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($service->description, 70) }}</small>
                                        </td>

                                        <td>
                                            @if($service->price)
                                                <span class="badge badge-soft-secondary px-3">
                                                    <i class="fe fe-tag mr-1"></i>
                                                    {{ number_format($service->price, 2) }} EGP
                                                </span>
                                            @else
                                                <span class="badge badge-soft-secondary px-3">
                                                    <i class="fe fe-gift mr-1"></i> Free
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                <i class="fe fe-clock mr-1"></i>
                                                {{ $service->deleted_at->format('d M, Y') }}<br>
                                                <span style="font-size: 0.7rem;">
                                                    {{ $service->deleted_at->diffForHumans() }}
                                                </span>
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <!-- Restore -->
                                                <form action="{{ route('admin.service.restore', $service->id) }}"
                                                      method="POST"
                                                      id="restore-form-{{ $service->id }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button"
                                                            onclick="confirmRestore({{ $service->id }}, '{{ addslashes($service->name) }}')"
                                                            class="btn btn-sm btn-outline-success"
                                                            data-toggle="tooltip" title="Restore Service">
                                                        <i class="fe fe-rotate-ccw"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-archive fe-24 mb-3"></i>
                                                <p class="mb-0">No archived services found.</p>
                                                <a href="{{ route('admin.service.index') }}" class="btn btn-primary mt-3">
                                                    <i class="fe fe-arrow-left"></i> Go to Active Services
                                                </a>
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
                            Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} archived entries
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
        You don't have permission to view archived services.
    </div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md { width: 52px; height: 52px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .bg-soft-warning   { background-color: rgba(255, 193, 7,  0.1); }
    .bg-soft-primary   { background-color: rgba(27,  104, 255, 0.1); }
    .badge-soft-secondary { color: #6c757d; background-color: rgba(108, 117, 125, 0.1); }
    .opacity-50 { opacity: 0.5; }
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

    function confirmRestore(id, name) {
        Swal.fire({
            title: 'Restore Service?',
            html:  "<strong>" + name + "</strong> will be moved back to active services!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Restore!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restore-form-' + id).submit();
            }
        });
    }

    function confirmPermanentDelete(id, name) {
        Swal.fire({
            title: 'Permanently Delete?',
            html:  "<strong class='text-danger'>" + name + "</strong> will be permanently deleted!<br><br>" +
                   "<small class='text-muted'>This action cannot be undone!</small>",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6e7881',
            confirmButtonText: 'Yes, Delete Forever!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            input: 'checkbox',
            inputPlaceholder: 'I understand this cannot be undone',
            inputValidator: (result) => {
                return !result && 'You must confirm to proceed'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('force-delete-form-' + id).submit();
            }
        });
    }

    setTimeout(function () { $('.alert').fadeOut('slow'); }, 5000);
</script>
@endpush