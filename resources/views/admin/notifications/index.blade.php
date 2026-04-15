@extends('admin.master')

@section('title', 'Notifications')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .bg-soft-primary { background-color: rgba(27,104,255,.06); }
    .notif-row:hover { background-color: rgba(0,0,0,.02); }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            {{-- Page Header --}}
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h3 mb-0 page-title">Notifications</h2>
                    <p class="text-muted small mb-0">All your system notifications</p>
                </div>
                <div class="col-auto d-flex" style="gap: 8px;">

                    {{-- Mark all as read --}}
                    <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fe fe-check-circle mr-1"></i> Mark all read
                        </button>
                    </form>

                    {{-- Clear all --}}
                    <form action="{{ route('admin.notifications.clearAll') }}" method="POST" id="clear-all-form">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-outline-danger btn-sm" id="clear-all-btn">
                            <i class="fe fe-trash-2 mr-1"></i> Clear all
                        </button>
                    </form>

                </div>
            </div>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            {{-- Notifications Card --}}
            <div class="card shadow border-0">

                {{-- Stats bar --}}
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                    <span class="small text-muted">
                        {{ $notifications->total() }} total &nbsp;·&nbsp;
                        <span class="text-primary font-weight-bold">
                            {{ auth()->user()->unreadNotifications->count() }} unread
                        </span>
                    </span>
                    <span class="badge badge-primary badge-pill px-3">{{ $notifications->total() }} Records</span>
                </div>

                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        @php
                            $data   = $notification->data;
                            $isRead = ! is_null($notification->read_at);
                            $color  = $data['color'] ?? 'primary';
                            $icon   = $data['icon']  ?? 'fe-bell';

                            $colorMap = [
                                'primary' => '#1b68ff',
                                'success' => '#28a745',
                                'info'    => '#17a2b8',
                                'warning' => '#ffc107',
                                'danger'  => '#dc3545',
                            ];
                            $hex = $colorMap[$color] ?? '#1b68ff';
                        @endphp

                        <div class="d-flex align-items-start px-4 py-3 border-bottom notif-row {{ $isRead ? '' : 'bg-soft-primary' }}"
                             style="transition: background .2s;">

                            {{-- Icon circle --}}
                            <div class="mr-3 flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:40px;height:40px;background:{{ $hex }}1a;">
                                    <i class="fe {{ $icon }} text-{{ $color }}"></i>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="d-flex justify-content-between align-items-start flex-wrap">
                                    <div>
                                        <strong class="text-dark">
                                            <a href="{{ route('admin.booking.edit', $data['booking_id'] ?? null) ?? '#' }}" class="text-dark" style="text-decoration:underline;">
                                            {{ $data['title'] ?? 'Notification' }}
                                        </a>
                                        </strong>
                                        @if(! $isRead)
                                            <span class="badge badge-{{ $color }} ml-1" style="font-size:.6rem;">New</span>
                                        @endif
                                    </div>
                                    <small class="text-muted ml-2 text-nowrap">
                                        <i class="fe fe-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="text-muted small mb-0 mt-1">{{ $data['message'] ?? '' }}</p>
                            </div>

                            {{-- Actions --}}
                            <div class="ml-3 d-flex align-items-center flex-shrink-0" style="gap:6px;">

                                @if(! $isRead)
                                    <a href="{{ route('admin.notifications.read', $notification->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Mark as read"
                                       data-toggle="tooltip">
                                        <i class="fe fe-check"></i>
                                    </a>
                                @endif

                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                      method="POST"
                                      class="delete-notif-form">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger delete-notif-btn"
                                            title="Delete"
                                            data-toggle="tooltip">
                                        <i class="fe fe-trash-2"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    @empty
                        <div class="text-center py-5">
                            <i class="fe fe-bell-off text-muted" style="font-size:2.5rem;"></i>
                            <p class="text-muted mt-3 mb-0">No notifications yet.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($notifications->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }}
                            of {{ $notifications->total() }}
                        </span>
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {

    // ── Tooltips ────────────────────────────────────────
    $('[data-toggle="tooltip"]').tooltip();

    // ── Delete single notification ───────────────────────
    $(document).on('click', '.delete-notif-btn', function () {
        const form = $(this).closest('.delete-notif-form');

        Swal.fire({
            title: 'Delete Notification?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ── Clear all notifications ──────────────────────────
    $('#clear-all-btn').on('click', function () {
        Swal.fire({
            title: 'Clear All Notifications?',
            text: 'All notifications will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear all',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $('#clear-all-form').submit();
            }
        });
    });

});
</script>
@endpush