@extends('admin.master')

@section('title', 'Services')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Services Management</h2>
                    <p class="text-muted">Manage available clinic services, pricing, and descriptions</p>
                </div>
                <div class="col-auto">
                    @can('create_services')
                    <a href="{{ route('admin.service.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Service
                    </a>
                    @endcan
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Filters</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.service.index') }}">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="search">Service Name / Description</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search by name or keywords...">
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-filter"></i> Filter
                                </button>
                            </div>
                            <div class="form-group col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ route('admin.service.index') }}'">
                                    <i class="fe fe-rotate-ccw"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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
                                    <th class="text-center" style="width: 150px;">
                                        @can('delete_services' || 'edit_services')
                                            Actions
                                        @endcan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td class="text-center">{{ $services->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="avatar avatar-md">
                                                @if($service->image)
                                                    <img src="{{ asset('storage/services/' . $service->image) }}" alt="Service" class="avatar-img rounded border shadow-sm">
                                                @else
                                                    <div class="avatar-img rounded bg-light d-flex align-items-center justify-content-center border shadow-sm">
                                                        <i class="fe fe-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $service->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($service->description, 70) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-success px-3">
                                                {{ $service->price ? number_format($service->price, 2) . ' EGP' : 'Free' }}
                                            </span>
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
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Delete this service?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            data-toggle="tooltip" title="Delete">
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
                        <div>
                            {{ $services->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-md { width: 48px; height: 48px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .badge-soft-success { color: #3ad29f; background-color: rgba(58, 210, 159, 0.1); }
    thead.thead-light th {
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () { $('[data-toggle="tooltip"]').tooltip() })
</script>
@endpush