@extends('front.inc.master')

@section('title', 'Booking Confirmed!')

@section('content')

<section class="res-section">
  <div class="res-wrapper">

    <div class="res-card res-card--success" data-aos="fade-up">

      <div class="res-icon res-icon--success">
        <i class="fa-solid fa-circle-check"></i>
      </div>

      <h1 class="res-title">Booking Confirmed!</h1>
      <p class="res-subtitle">
        Your appointment has been successfully booked.
        @if($booking->payment_method === 'card')
          Payment of <strong>{{ number_format($booking->amount,2) }} EGP</strong> received.
        @else
          Please pay <strong>{{ number_format($booking->amount,2) }} EGP</strong> at the clinic.
        @endif
      </p>

      <div class="res-grid">
        <div class="res-item">
          <span class="res-lbl"><i class="fa-regular fa-user"></i> Doctor</span>
          <span class="res-val">Dr. {{ $booking->doctor->user->name }}</span>
        </div>
        <div class="res-item">
          <span class="res-lbl"><i class="fa-solid fa-stethoscope"></i> Specialty</span>
          <span class="res-val">{{ $booking->doctor->major->title }}</span>
        </div>
        <div class="res-item">
          <span class="res-lbl"><i class="fa-regular fa-calendar"></i> Date</span>
          <span class="res-val">{{ $booking->formatted_date }}</span>
        </div>
        <div class="res-item">
          <span class="res-lbl"><i class="fa-regular fa-clock"></i> Time</span>
          <span class="res-val">{{ $booking->formatted_time }}</span>
        </div>
        <div class="res-item">
          <span class="res-lbl"><i class="fa-solid fa-receipt"></i> Booking #</span>
          <span class="res-val">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="res-item">
          <span class="res-lbl"><i class="fa-solid fa-wallet"></i> Payment</span>
          <span class="res-val res-val--paid">
            @if($booking->payment_method === 'card')
              <i class="fa-solid fa-check-circle"></i> Paid Online
            @else
              <i class="fa-solid fa-hospital"></i> Pay at Clinic
            @endif
          </span>
        </div>
      </div>

      @if($booking->card_last4)
      <div class="res-card-info">
        <i class="fa-regular fa-credit-card"></i>
        Paid with card ending in <strong>••••&nbsp;{{ $booking->card_last4 }}</strong>
      </div>
      @endif

      <div class="res-actions">
        <a href="{{ route('front.home') }}" class="res-btn res-btn--outline">
          <i class="fa-solid fa-house"></i> Back to Home
        </a>
        <a href="{{ route('front.profile.my-appointments') }}" class="res-btn res-btn--primary">
          <i class="fa-regular fa-calendar-check"></i> My Appointments
        </a>
      </div>

    </div>

  </div>
</section>

@endsection

@push('style')
<style>
.res-section{min-height:100vh;background:var(--grey-100);display:flex;align-items:center;padding:60px 0}
.res-wrapper{max-width:560px;margin:0 auto;padding:0 20px}
.res-card{background:#fff;border-radius:20px;padding:44px 36px;text-align:center;border:1px solid var(--grey-200);box-shadow:var(--shadow-card)}
.res-icon{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:2rem}
.res-icon--success{background:#f0fff4;color:#38a169}
.res-title{font-family:'Fraunces',serif;font-size:1.7rem;font-weight:700;color:var(--text);margin-bottom:8px}
.res-subtitle{font-size:.88rem;color:var(--grey-500);margin-bottom:28px;line-height:1.7}
.res-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;text-align:left;margin-bottom:20px}
.res-item{background:var(--grey-100);border-radius:10px;padding:12px 14px;display:flex;flex-direction:column;gap:5px}
.res-lbl{font-size:.7rem;font-weight:600;color:var(--grey-500);text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:5px}
.res-val{font-size:.86rem;font-weight:600;color:var(--text)}
.res-val--paid{color:#38a169;display:flex;align-items:center;gap:5px}
.res-card-info{background:#f0efff;border:1px solid #c4b5fd;border-radius:10px;padding:11px 16px;font-size:.8rem;color:#5b21b6;margin-bottom:24px;display:flex;align-items:center;gap:8px}
.res-actions{display:flex;gap:12px;justify-content:center}
.res-btn{display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:var(--r-sm);font-size:.85rem;font-weight:700;text-decoration:none;transition:var(--t)}
.res-btn--primary{background:var(--blue);color:#fff;box-shadow:var(--shadow-btn)}
.res-btn--primary:hover{background:var(--blue-mid);transform:translateY(-2px)}
.res-btn--outline{background:#fff;color:var(--grey-700);border:1.5px solid var(--grey-200)}
.res-btn--outline:hover{border-color:var(--blue);color:var(--blue)}
@media(max-width:480px){.res-grid{grid-template-columns:1fr}.res-actions{flex-direction:column}}
</style>
@endpush