@extends('admin.master')

@section('title', 'Receptionists')

@section('content')

@can('view_receptionists')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Receptionists Management</h2>
                    <p class="text-muted">Manage all front-desk staff and their shifts</p>
                </div>
                <div class="col-auto">
                    @can('create_receptionists')
                    <a href="{{ route('admin.receptionist.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus mr-1"></i> Add Receptionist
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
                    <form method="GET" action="{{ route('admin.receptionist.index') }}">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="search">Name / Email</label>
                                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search by name or email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="shift">Shift</label>
                                <select name="shift" id="shift" class="form-control select2">
                                    <option value="">All Shifts</option>
                                    <option value="morning" {{ request('shift') == 'morning' ? 'selected' : '' }}>Morning</option>
                                    <option value="evening" {{ request('shift') == 'evening' ? 'selected' : '' }}>Evening</option>
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
                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ route('admin.receptionist.index') }}'">
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
                        <strong class="card-title">Receptionists List</strong>
                        <span class="badge badge-primary badge-pill">{{ $receptionists->total() }} Total</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th style="width: 80px;">Image</th>
                                    <th>Receptionist Details</th>
                                    <th>Contact Info</th>
                                    <th>Shift</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($receptionists as $receptionist)
                                    <tr>
                                        <td class="text-center">{{ $receptionists->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="avatar avatar-md">
                                                @if($receptionist->image)
                                                    <img src="{{ asset('images/receptionists/' . $receptionist->image) }}" alt="Profile" class="avatar-img rounded-circle border shadow-sm">
                                                @else
                                                    <div class="avatar-img rounded-circle bg-light d-flex align-items-center justify-content-center border shadow-sm">
                                                        <i class="fe fe-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $receptionist->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted"><i class="fe fe-map-pin mr-1"></i>{{ $receptionist->address ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="small"><i class="fe fe-mail mr-1"></i>{{ $receptionist->user->email ?? '-' }}</div>
                                            <div class="small"><i class="fe fe-phone mr-1"></i>{{ $receptionist->user->phone ?? '-' }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $shiftColor = match($receptionist->shift) {
                                                    'morning' => 'success',
                                                    'evening' => 'warning',
                                                    'night'   => 'secondary',
                                                    default   => 'primary'
                                                };
                                            @endphp
                                            <span class="badge badge-soft-{{ $shiftColor }} px-3">
                                                {{ ucfirst($receptionist->shift ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('edit_receptionists')
                                                <a href="{{ route('admin.receptionist.edit', $receptionist) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                @endcan

                                                @can('delete_receptionists')
                                                <form action="{{ route('admin.receptionist.destroy', $receptionist) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Delete {{ $receptionist->user->name }}?')">
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
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-users fe-24 mb-3"></i>
                                                <p class="mb-0">No receptionists found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($receptionists->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $receptionists->firstItem() }} to {{ $receptionists->lastItem() }} of {{ $receptionists->total() }} entries
                        </div>
                        <div>
                            {{ $receptionists->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endcan

@endsection

@push('styles')
<style>
    .avatar-md { width: 42px; height: 42px; }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }
    .badge-soft-primary { color: #1b68ff; background-color: rgba(27, 104, 255, 0.1); }
    .badge-soft-success { color: #3ad29f; background-color: rgba(58, 210, 159, 0.1); }
    .badge-soft-warning { color: #ffc107; background-color: rgba(255, 193, 7, 0.1); }
    .badge-soft-secondary { color: #adb5bd; background-color: rgba(173, 181, 189, 0.1); }
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