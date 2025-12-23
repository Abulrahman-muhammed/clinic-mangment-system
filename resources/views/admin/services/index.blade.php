@extends('admin.master')

@section('title', 'Services')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Services</h2>

                @can('create_services')
                    <div class="page-title-right">
                        <a href="{{ route('admin.service.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Service
                        </a>
                    </div>
                @endcan
            </div>

            <!-- Main Card -->
            <div class="card shadow">
                <div class="card-body">

                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <table class="table table-hover align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($services->count() > 0)
                                @foreach ($services as $index => $service)
                                    <tr>
                                        <td>{{ $services->firstItem() + $loop->index }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->price ? number_format($service->price, 2) . ' EGP' : '-' }}</td>
                                        <td>{{ Str::limit($service->description, 50) }}</td>
                                        <td>
                                            @if ($service->image)
                                                <img src="{{ asset('storage/services/' . $service->image) }}" 
                                                     alt="Service image" width="60" height="60" 
                                                     class="rounded object-fit-cover">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('edit_services')
                                                <a href="{{ route('admin.service.edit', $service) }}" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="fe fe-edit-2 fa-2x"></i>
                                                </a>
                                            @endcan

                                            @can('delete_services')
                                                <form action="{{ route('admin.service.destroy', $service) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this service?')">
                                                        <i class="fe fe-trash-2 fa-2x"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No Services found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $services->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
