@extends('admin.master')

@section('title', 'Contacts')

@section('content')

@can('view_contacts')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Page Title -->
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 page-title">Contacts</h2>
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
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Message</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($contacts->count() > 0)
                                @foreach ($contacts as $index => $contact)
                                    <tr>
                                        <td>{{ $contacts->firstItem() + $loop->index }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($contact->created_at)->format('d-M-Y h:i A') }}</td>
                                        <td>{{ $contact->message }}</td>
                                        <td>
                                            @can('delete_contacts')
                                            <form action="{{ route('admin.contact.destroy', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this contact?')">
                                                    <i class="fe fe-trash-2 fa-2x"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No contacts found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $contacts->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection
