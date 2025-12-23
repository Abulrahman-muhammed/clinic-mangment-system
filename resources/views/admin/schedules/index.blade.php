@extends('admin.master')
@section('title', 'Doctor Schedules')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title">Doctor Schedules</h2>
            <div class="card shadow">
                <div class="card-body">

                    @can('create_schedules')
                        <a href="{{ route('admin.schedule.create') }}" class="btn btn-primary mb-3">
                            <i class="fe fe-plus"></i> Add New Schedule
                        </a>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Doctor</th>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $schedule->doctor->name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->day_of_week }}</td>
                                        <td>{{ $schedule->start_time }}</td>
                                        <td>{{ $schedule->end_time }}</td>
                                        <td>
                                            @can('edit_schedules')
                                                <a href="{{ route('admin.schedule.edit', $schedule->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                            @endcan

                                            @can('delete_schedules')
                                                <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No schedules found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
