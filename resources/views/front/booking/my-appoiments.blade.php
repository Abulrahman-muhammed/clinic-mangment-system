@extends('front.inc.master')

@section('title', 'My Appointments')

@section('content')

<section class="ap-section">
  <div class="ap-wrapper">

    {{-- ══════════ Header ══════════ --}}
    <div class="ap-header" data-aos="fade-down">
      <div class="ap-header-left">
        <h1 class="ap-title">My Appointments</h1>
        <p class="ap-subtitle">Track and manage all your bookings in one place</p>
      </div>
      <a href="{{ route('front.doctors') }}" class="ap-new-btn">
        <i class="fa-solid fa-plus"></i> Book New Appointment
      </a>
    </div>

    {{-- ══════════ Stats Strip ══════════ --}}
    <div class="ap-stats" data-aos="fade-up" data-aos-delay="100">
      <div class="ap-stat">
        <span class="ap-stat-num">{{ $bookings->total() }}</span>
        <span class="ap-stat-lbl">Total</span>
      </div>
      <div class="ap-stat-div"></div>
      <div class="ap-stat">
        <span class="ap-stat-num ap-stat-num--blue">{{ $bookings->where('status','confirmed')->count() }}</span>
        <span class="ap-stat-lbl">Confirmed</span>
      </div>
      <div class="ap-stat-div"></div>
      <div class="ap-stat">
        <span class="ap-stat-num ap-stat-num--green">{{ $bookings->where('status','completed')->count() }}</span>
        <span class="ap-stat-lbl">Completed</span>
      </div>
      <div class="ap-stat-div"></div>
      <div class="ap-stat">
        <span class="ap-stat-num ap-stat-num--yellow">{{ $bookings->where('status','pending')->count() }}</span>
        <span class="ap-stat-lbl">Pending</span>
      </div>
      <div class="ap-stat-div"></div>
      <div class="ap-stat">
        <span class="ap-stat-num ap-stat-num--red">{{ $bookings->where('status','cancelled')->count() }}</span>
        <span class="ap-stat-lbl">Cancelled</span>
      </div>
    </div>

    {{-- ══════════ Filter Tabs ══════════ --}}
    <div class="ap-tabs" data-aos="fade-up" data-aos-delay="150">
      @php
        $tabs = [
          'all'       => 'All',
          'pending'   => 'Pending',
          'confirmed' => 'Confirmed',
          'completed' => 'Completed',
          'cancelled' => 'Cancelled',
        ];
        $current = request('status', 'all');
      @endphp
      @foreach($tabs as $key => $label)
        <a href="{{ request()->fullUrlWithQuery(['status' => $key]) }}"
           class="ap-tab {{ $current === $key ? 'active' : '' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>

    {{-- ══════════ Appointments List ══════════ --}}
    @if($bookings->isEmpty())
      <div class="ap-empty" data-aos="fade-up">
        <div class="ap-empty-icon">
          <i class="fa-regular fa-calendar-xmark"></i>
        </div>
        <h3>No appointments found</h3>
        <p>You don't have any {{ $current !== 'all' ? $current : '' }} appointments yet.</p>
        <a href="{{ route('front.doctors') }}" class="ap-empty-btn">
          <i class="fa-solid fa-stethoscope"></i> Find a Doctor
        </a>
      </div>
    @else
      <div class="ap-list">
        @foreach($bookings as $i => $booking)
        <div class="ap-card" data-aos="fade-up" data-aos-delay="{{ min($i * 60, 300) }}">

          {{-- Left: Doctor Info --}}
          <div class="ap-card-doctor">
            <div class="ap-doc-avatar">
              @if($booking->doctor->image)
                <img src="{{ asset('images/doctors/' . $booking->doctor->image) }}"
                     alt="Dr. {{ $booking->doctor->user->name }}">
              @else
                <div class="ap-doc-initials">
                  {{ strtoupper(substr($booking->doctor->user->name, 0, 1)) }}
                </div>
              @endif
            </div>
            <div class="ap-doc-info">
              <h4 class="ap-doc-name">Dr. {{ $booking->doctor->user->name }}</h4>
              <span class="ap-doc-major">{{ $booking->doctor->major->title }}</span>
              <div class="ap-booking-id">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
          </div>

          {{-- Center: Date & Time --}}
          <div class="ap-card-datetime">
            <div class="ap-date-block">
              <div class="ap-date-day">{{ $booking->appointment_date->format('d') }}</div>
              <div class="ap-date-month">{{ $booking->appointment_date->format('M Y') }}</div>
            </div>
            <div class="ap-date-sep"><i class="fa-solid fa-circle ap-dot"></i></div>
            <div class="ap-time-block">
              <i class="fa-regular fa-clock"></i>
              {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
            </div>
          </div>

          {{-- Right: Badges & Payment --}}
          <div class="ap-card-meta">
            <span class="ap-badge ap-badge--{{ $booking->status }}">
              @switch($booking->status)
                @case('confirmed') <i class="fa-solid fa-circle-check"></i> Confirmed @break
                @case('pending')   <i class="fa-solid fa-clock"></i> Pending @break
                @case('completed') <i class="fa-solid fa-flag-checkered"></i> Completed @break
                @case('cancelled') <i class="fa-solid fa-circle-xmark"></i> Cancelled @break
              @endswitch
            </span>

            <div class="ap-payment">
              @if($booking->payment_method === 'card')
                <span class="ap-pay-chip ap-pay-chip--card">
                  <i class="fa-regular fa-credit-card"></i>
                  @if($booking->payment_status === 'paid')
                    Paid ••••{{ $booking->card_last4 }}
                  @elseif($booking->payment_status === 'failed')
                    Payment Failed
                  @else
                    Online · Pending
                  @endif
                </span>
              @else
                <span class="ap-pay-chip ap-pay-chip--clinic">
                  <i class="fa-solid fa-hospital"></i> Pay at Clinic
                </span>
              @endif
            </div>

            <div class="ap-amount">{{ number_format($booking->amount, 2) }} <em>EGP</em></div>
          </div>

          {{-- Actions --}}
          <div class="ap-card-actions">
            @if($booking->status === 'pending' && $booking->payment_method === 'card' && $booking->payment_status === 'pending')
              <a href="{{ route('front.booking.fake-checkout', $booking) }}"
                 class="ap-action-btn ap-action-btn--pay">
                <i class="fa-solid fa-lock"></i> Complete Payment
              </a>
            @endif

            {{-- ✅ Invoice Button: only for paid card bookings --}}
            @if($booking->payment_method === 'card' && $booking->payment_status === 'paid')
              <button type="button"
                      class="ap-action-btn ap-action-btn--invoice"
                      onclick="showInvoice({
                        id:       '{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}',
                        doctor:   'Dr. {{ addslashes($booking->doctor->user->name) }}',
                        major:    '{{ addslashes($booking->doctor->major->title) }}',
                        date:     '{{ $booking->appointment_date->format('d M Y') }}',
                        time:     '{{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}',
                        amount:   '{{ number_format($booking->amount, 2) }}',
                        last4:    '{{ $booking->card_last4 }}',
                        status:   '{{ $booking->status }}',
                        patient:  '{{ addslashes(auth()->user()->name) }}',
                        paidAt:   '{{ $booking->updated_at->format('d M Y, g:i A') }}'
                      })">
                <i class="fa-solid fa-file-invoice"></i> Invoice
              </button>
            @endif

            @if(in_array($booking->status, ['pending', 'confirmed']) && $booking->payment_method === 'at_clinic')
              <form action="{{ route('front.booking.cancel', $booking) }}"
                    method="POST"
                    id="cancel-form-{{ $booking->id }}">
                @csrf @method('PATCH')
                <button type="button"
                        class="ap-action-btn ap-action-btn--cancel"
                        onclick="confirmCancel({{ $booking->id }})">
                  <i class="fa-solid fa-xmark"></i> Cancel
                </button>
              </form>
            @endif

            @if($booking->status === 'cancelled')
              <a href="{{ route('front.booking.create', $booking->doctor) }}"
                 class="ap-action-btn ap-action-btn--rebook">
                <i class="fa-solid fa-rotate-right"></i> Rebook
              </a>
            @endif

            {{-- 🗑 Delete Button: only for cancelled or completed --}}
            @if(in_array($booking->status, ['cancelled', 'completed']) || $booking->payment_status === 'failed')
              <form action="{{ route('front.booking.destroy', $booking) }}"
                    method="POST"
                    id="delete-form-{{ $booking->id }}">
                @csrf @method('DELETE')
                <button type="button"
                        class="ap-action-btn ap-action-btn--delete"
                        onclick="confirmDelete({{ $booking->id }})">
                  <i class="fa-solid fa-trash-can"></i> Delete
                </button>
              </form>
            @endif
          </div>

        </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if($bookings->hasPages())
      <div class="ap-pagination">
        {{ $bookings->appends(request()->query())->links() }}
      </div>
      @endif
    @endif

  </div>
</section>

{{-- ══════════════════════════════════════════════════
     INVOICE MODAL
══════════════════════════════════════════════════ --}}
<div id="invoiceModal" class="inv-overlay" onclick="closeInvoice(event)">
  <div class="inv-modal">

    {{-- Close --}}
    <button class="inv-close" onclick="closeInvoiceBtn()">
      <i class="fa-solid fa-xmark"></i>
    </button>

    {{-- Printable Invoice --}}
    <div class="inv-paper" id="invoicePaper">

      {{-- Header --}}
      <div class="inv-head">
        <div class="inv-logo">
          <i class="fa-solid fa-stethoscope"></i>
          <span>{{ config('app.name') }}</span>
        </div>
        <div class="inv-head-right">
          <div class="inv-tag">PAYMENT RECEIPT</div>
          <div class="inv-ref">Ref #<span id="inv-id"></span></div>
        </div>
      </div>

      <div class="inv-divider"></div>

      {{-- Status Banner --}}
      <div class="inv-status-banner">
        <i class="fa-solid fa-circle-check"></i>
        <span>Payment Confirmed</span>
      </div>

      {{-- Info Grid --}}
      <div class="inv-grid">
        <div class="inv-section">
          <div class="inv-section-title">Patient</div>
          <div class="inv-section-val" id="inv-patient"></div>
        </div>
        <div class="inv-section">
          <div class="inv-section-title">Doctor</div>
          <div class="inv-section-val" id="inv-doctor"></div>
          <div class="inv-section-sub" id="inv-major"></div>
        </div>
        <div class="inv-section">
          <div class="inv-section-title">Appointment Date</div>
          <div class="inv-section-val" id="inv-date"></div>
          <div class="inv-section-sub" id="inv-time"></div>
        </div>
        <div class="inv-section">
          <div class="inv-section-title">Payment Method</div>
          <div class="inv-section-val">Credit Card</div>
          <div class="inv-section-sub">••••&nbsp;<span id="inv-last4"></span></div>
        </div>
        <div class="inv-section">
          <div class="inv-section-title">Paid On</div>
          <div class="inv-section-val" id="inv-paidat"></div>
        </div>
        <div class="inv-section">
          <div class="inv-section-title">Booking Status</div>
          <div class="inv-section-val inv-section-status" id="inv-bstatus"></div>
        </div>
      </div>

      <div class="inv-divider"></div>

      {{-- Total --}}
      <div class="inv-total-row">
        <span class="inv-total-lbl">Total Paid</span>
        <span class="inv-total-val"><span id="inv-amount"></span> <em>EGP</em></span>
      </div>

      <div class="inv-divider"></div>

      {{-- Footer --}}
      <div class="inv-footer">
        <p>Thank you for using {{ config('app.name') }}. This is an official payment receipt.</p>
      </div>

    </div>{{-- /inv-paper --}}

    {{-- Print Button (outside paper so it won't print) --}}
    <div class="inv-actions">
      <button class="inv-print-btn" onclick="printInvoice()">
        <i class="fa-solid fa-print"></i> Print Invoice
      </button>
      <button class="inv-dl-btn" onclick="closeInvoiceBtn()">
        <i class="fa-solid fa-xmark"></i> Close
      </button>
    </div>

  </div>
</div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('front-assets/css/my-appointments.css') }}">
@endpush

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Auto-hide flash messages after 4 seconds
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.bk-alert').forEach(function (el) {
    setTimeout(() => el.style.opacity = '0', 4000);
    setTimeout(() => el.remove(), 4400);
  });
});

// ── Cancel Confirmation (SweetAlert2) ─────────────
function confirmCancel(id) {
  Swal.fire({
    title: 'Cancel Appointment?',
    text: 'Are you sure you want to cancel this appointment? This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="fa-solid fa-xmark"></i> Yes, Cancel It',
    cancelButtonText: 'Keep Appointment',
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#2563eb',
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
      document.getElementById('cancel-form-' + id).submit();
    }
  });
}

// ── Delete Confirmation (SweetAlert2) ─────────────
function confirmDelete(id) {
  Swal.fire({
    title: 'Delete Appointment?',
    text: 'This will permanently remove the appointment record. You cannot undo this.',
    icon: 'error',
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
      document.getElementById('delete-form-' + id).submit();
    }
  });
}

// ── Invoice Modal ──────────────────────────────────
function showInvoice(data) {
  document.getElementById('inv-id').textContent      = data.id;
  document.getElementById('inv-patient').textContent = data.patient;
  document.getElementById('inv-doctor').textContent  = data.doctor;
  document.getElementById('inv-major').textContent   = data.major;
  document.getElementById('inv-date').textContent    = data.date;
  document.getElementById('inv-time').textContent    = data.time;
  document.getElementById('inv-amount').textContent  = data.amount;
  document.getElementById('inv-last4').textContent   = data.last4;
  document.getElementById('inv-paidat').textContent  = data.paidAt;
  document.getElementById('inv-bstatus').textContent = data.status;

  document.getElementById('invoiceModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeInvoice(e) {
  if (e.target === document.getElementById('invoiceModal')) closeInvoiceBtn();
}

function closeInvoiceBtn() {
  document.getElementById('invoiceModal').classList.remove('open');
  document.body.style.overflow = '';
}

function printInvoice() {
  window.print();
}

// Close with Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeInvoiceBtn();
});
</script>
@endpush