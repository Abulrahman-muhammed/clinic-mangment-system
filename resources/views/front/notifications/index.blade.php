@extends('front.inc.master')

@section('title', 'Notifications')

@section('content')

<style>
.np-section {
    padding: 2.5rem 0 4rem;
}
.np-wrapper {
    max-width: 940px;
    margin: 0 auto;
    padding: 0 1.25rem;
}

/* ── Header ── */
.np-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.np-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 4px;
}
.np-subtitle {
    font-size: 15px;
    color: #64748b;
    margin: 0;
}
.np-header-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}
.np-mark-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, border-color .15s;
    white-space: nowrap;
}
.np-mark-btn:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #374151;
    text-decoration: none;
}
.np-mark-btn--danger {
    color: #dc2626;
    border-color: #fecaca;
    background: #fff;
}
.np-mark-btn--danger:hover {
    background: #fef2f2;
    border-color: #fca5a5;
    color: #b91c1c;
}

/* ── Stats Strip ── */
.np-stats {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .75rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.5rem;
}
.np-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    min-width: 64px;
}
.np-stat-num {
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}
.np-stat-num--blue   { color: var(--blue, #185FA5); }
.np-stat-num--green  { color: #16a34a; }
.np-stat-num--amber  { color: #d97706; }
.np-stat-num--red    { color: #dc2626; }
.np-stat-num--purple { color: #7c3aed; }
.np-stat-lbl {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 400;
}
.np-stat-div {
    width: 1px;
    height: 36px;
    background: #e2e8f0;
    margin: 0 .25rem;
    flex-shrink: 0;
}

/* ── Filter Tabs ── */
.np-tabs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.np-tab {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
    font-weight: 500;
    color: #64748b;
    background: #fff;
    text-decoration: none;
    transition: all .15s;
}
.np-tab:hover {
    background: #f1f5f9;
    color: #1e293b;
    border-color: #cbd5e1;
    text-decoration: none;
}
.np-tab.active {
    background: var(--blue, #185FA5);
    color: #fff;
    border-color: var(--blue, #185FA5);
}

/* ── Cards List ── */
.np-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.np-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    position: relative;
    transition: border-color .15s, box-shadow .15s;
}
.np-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
}
.np-card--unread {
    border-left: 3px solid var(--blue, #185FA5);
    background: #fafcff;
}
.np-ico-wrap {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.np-ico-wrap i { font-size: 18px; }
.np-body {
    flex: 1;
    min-width: 0;
}
.np-msg {
    font-size: 14px;
    color: #1e293b;
    line-height: 1.55;
    margin-bottom: 4px;
}
.np-card--unread .np-msg { font-weight: 500; }
.np-time {
    font-size: 12px;
    color: #94a3b8;
}
.np-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--blue, #185FA5);
    flex-shrink: 0;
}
.np-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.np-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all .15s;
    white-space: nowrap;
}
.np-action-btn:hover {
    background: #f1f5f9;
    color: #1e293b;
    text-decoration: none;
}
.np-action-btn--delete {
    color: #dc2626;
    border-color: #fecaca;
}
.np-action-btn--delete:hover {
    background: #fef2f2;
    color: #b91c1c;
}

/* ── Empty State ── */
.np-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 4rem 2rem;
    text-align: center;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
}
.np-empty-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #cbd5e1;
}
.np-empty h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}
.np-empty p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

/* ── Pagination ── */
.np-pagination {
    display: flex;
    justify-content: center;
    margin-top: 1.75rem;
}

/* ── Responsive ── */
@media (max-width: 640px) {
    .np-card { flex-wrap: wrap; }
    .np-actions {
        width: 100%;
        justify-content: flex-end;
        padding-top: .5rem;
        border-top: 1px solid #f1f5f9;
        margin-top: .25rem;
    }
    .np-stat-div { display: none; }
    .np-stats { gap: 1rem .5rem; padding: 1rem; }
}
</style>

<section class="np-section">
  <div class="np-wrapper">

    {{-- ══════ Header ══════ --}}
    <div class="np-header" data-aos="fade-down">
      <div>
        <h1 class="np-title">Notifications</h1>
        <p class="np-subtitle">Stay up to date with your appointment updates</p>
      </div>

      <div class="np-header-actions">

        @if($unreadCount > 0)
          <form action="{{ route('front.notifications.markAllRead') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="np-mark-btn">
              <i class="fa-solid fa-check-double"></i> Mark all as read
            </button>
          </form>
        @endif

        @if($stats['total'] > 0)
          <form action="{{ route('front.notifications.destroyAll') }}" method="POST"
                id="form-delete-all" class="m-0">
            @csrf
            @method('DELETE')
            <button type="button"
                    class="np-mark-btn np-mark-btn--danger"
                    onclick="confirmDeleteAll()">
              <i class="fa-solid fa-trash-can"></i> Delete all
            </button>
          </form>
        @endif

      </div>
    </div>

    {{-- ══════ Stats Strip ══════ --}}
    <div class="np-stats" data-aos="fade-up" data-aos-delay="100">
      <div class="np-stat">
        <span class="np-stat-num">{{ $stats['total'] }}</span>
        <span class="np-stat-lbl">Total</span>
      </div>
      <div class="np-stat-div"></div>
      <div class="np-stat">
        <span class="np-stat-num np-stat-num--blue">{{ $stats['unread'] }}</span>
        <span class="np-stat-lbl">Unread</span>
      </div>
      <div class="np-stat-div"></div>
      <div class="np-stat">
        <span class="np-stat-num np-stat-num--green">{{ $stats['confirmed'] }}</span>
        <span class="np-stat-lbl">Confirmed</span>
      </div>
      <div class="np-stat-div"></div>
      <div class="np-stat">
        <span class="np-stat-num np-stat-num--amber">{{ $stats['pending'] }}</span>
        <span class="np-stat-lbl">Pending</span>
      </div>
      <div class="np-stat-div"></div>
      <div class="np-stat">
        <span class="np-stat-num np-stat-num--red">{{ $stats['cancelled'] }}</span>
        <span class="np-stat-lbl">Cancelled</span>
      </div>
      <div class="np-stat-div"></div>
      <div class="np-stat">
        <span class="np-stat-num np-stat-num--purple">{{ $stats['completed'] }}</span>
        <span class="np-stat-lbl">Completed</span>
      </div>
    </div>

    {{-- ══════ Filter Tabs ══════ --}}
    <div class="np-tabs" data-aos="fade-up" data-aos-delay="150">
      @php
        $tabs = [
          'all'       => 'All',
          'unread'    => 'Unread',
          'confirmed' => 'Confirmed',
          'pending'   => 'Pending',
          'cancelled' => 'Cancelled',
          'completed' => 'Completed',
        ];
      @endphp

      @foreach($tabs as $key => $label)
        <a href="{{ request()->fullUrlWithQuery(['filter' => $key]) }}"
           class="np-tab {{ $filter === $key ? 'active' : '' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>

    {{-- ══════ Notifications List ══════ --}}
    @if($notifications->isEmpty())
      <div class="np-empty" data-aos="fade-up">
        <div class="np-empty-icon">
          <i class="fa-solid fa-bell-slash"></i>
        </div>
        <h3>No notifications found</h3>
        <p>You don't have any {{ $filter !== 'all' ? $filter : '' }} notifications yet.</p>
      </div>

    @else
      <div class="np-list">
        @foreach($notifications as $i => $notification)
          @php
            $status   = $notification->data['status']  ?? 'pending';
            $message  = $notification->data['message'] ?? 'Your appointment has been updated.';
            $isUnread = is_null($notification->read_at);

            $iconMap = [
              'confirmed' => ['fa-circle-check',   '#16a34a', '#dcfce7'],
              'cancelled' => ['fa-circle-xmark',   '#dc2626', '#fee2e2'],
              'completed' => ['fa-flag-checkered', '#185FA5', '#eff4ff'],
              'pending'   => ['fa-clock',          '#d97706', '#fef3c7'],
            ];
            [$ico, $clr, $bg] = $iconMap[$status] ?? ['fa-bell', '#185FA5', '#eff4ff'];
          @endphp

          <div class="np-card {{ $isUnread ? 'np-card--unread' : '' }}"
               data-aos="fade-up"
               data-aos-delay="{{ min($i * 60, 300) }}">

            <div class="np-ico-wrap" style="background: {{ $bg }};">
              <i class="fa-solid {{ $ico }}" style="color: {{ $clr }};"></i>
            </div>

            <div class="np-body">
              <p class="np-msg">{{ $message }}</p>
              <span class="np-time">{{ $notification->created_at->diffForHumans() }}</span>
            </div>

            @if($isUnread)
              <span class="np-dot"></span>
            @endif

            <div class="np-actions">

              @if($isUnread)
                <form action="{{ route('front.notifications.markAsRead', $notification->id) }}"
                      method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="np-action-btn">
                    <i class="fa-solid fa-check"></i> Mark read
                  </button>
                </form>
              @endif

              <form action="{{ route('front.notifications.destroy', $notification->id) }}"
                    method="POST"
                    id="del-notif-{{ $notification->id }}"
                    class="m-0">
                @csrf
                @method('DELETE')
                <button type="button"
                        class="np-action-btn np-action-btn--delete"
                        onclick="confirmDeleteNotif('{{ $notification->id }}')">
                  <i class="fa-solid fa-trash-can"></i> Delete
                </button>
              </form>

            </div>
          </div>
        @endforeach
      </div>

      @if($notifications->hasPages())
        <div class="np-pagination">
          {{ $notifications->appends(request()->query())->links() }}
        </div>
      @endif
    @endif

  </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteNotif(id) {
  Swal.fire({
    title: 'Delete Notification?',
    text: 'This will permanently remove this notification.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Yes, Delete',
    cancelButtonText: 'Keep It',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    reverseButtons: true,
    focusCancel: true,
    customClass: {
      popup:         'swal-custom-popup',
      title:         'swal-custom-title',
      htmlContainer: 'swal-custom-text',
      confirmButton: 'swal-btn-confirm',
      cancelButton:  'swal-btn-cancel',
    }
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('del-notif-' + id).submit();
    }
  });
}

function confirmDeleteAll() {
  Swal.fire({
    title: 'Delete All Notifications?',
    text: 'This will permanently remove all your notifications.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Yes, Delete All',
    cancelButtonText: 'Keep Them',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    reverseButtons: true,
    focusCancel: true,
    customClass: {
      popup:         'swal-custom-popup',
      title:         'swal-custom-title',
      htmlContainer: 'swal-custom-text',
      confirmButton: 'swal-btn-confirm',
      cancelButton:  'swal-btn-cancel',
    }
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('form-delete-all').submit();
    }
  });
}
</script>
@endpush