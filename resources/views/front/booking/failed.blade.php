@extends('front.inc.master')

@section('title', 'Payment Failed')

@section('content')

<section class="res-section">
  <div class="res-wrapper">

    <div class="res-card res-card--failed" data-aos="fade-up">

      <div class="res-icon res-icon--failed">
        <i class="fa-solid fa-circle-xmark"></i>
      </div>

      <h1 class="res-title">Payment Failed</h1>
      <p class="res-subtitle">
        We couldn't process your payment for booking <strong>#{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}</strong>.
        Your booking has been <strong>cancelled</strong>. No charge was made.
      </p>

      <div class="res-fail-box">
        <i class="fa-solid fa-circle-info"></i>
        <div>
          Common reasons: insufficient funds, incorrect card details, or card declined.
          Please try again with a different card.
        </div>
      </div>

      <div class="res-actions">
        <a href="{{ route('front.booking.create', $booking->doctor) }}" class="res-btn res-btn--primary">
          <i class="fa-solid fa-rotate-right"></i> Try Again
        </a>
        <a href="{{ route('front.home') }}" class="res-btn res-btn--outline">
          <i class="fa-solid fa-house"></i> Back to Home
        </a>
      </div>

    </div>

  </div>
</section>

@endsection

@push('style')
<style>
.res-section{min-height:100vh;background:var(--grey-100);display:flex;align-items:center;padding:60px 0}
.res-wrapper{max-width:500px;margin:0 auto;padding:0 20px}
.res-card{background:#fff;border-radius:20px;padding:44px 36px;text-align:center;border:1px solid var(--grey-200);box-shadow:var(--shadow-card)}
.res-icon{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:2rem}
.res-icon--failed{background:#fff5f5;color:#e53e3e}
.res-title{font-family:'Fraunces',serif;font-size:1.7rem;font-weight:700;color:var(--text);margin-bottom:8px}
.res-subtitle{font-size:.88rem;color:var(--grey-500);margin-bottom:24px;line-height:1.7}
.res-fail-box{background:#fff5f5;border:1px solid #fed7d7;border-radius:10px;padding:13px 16px;font-size:.8rem;color:#c53030;display:flex;align-items:flex-start;gap:10px;text-align:left;margin-bottom:28px;line-height:1.7}
.res-fail-box i{flex-shrink:0;margin-top:2px}
.res-actions{display:flex;gap:12px;justify-content:center}
.res-btn{display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border-radius:var(--r-sm);font-size:.85rem;font-weight:700;text-decoration:none;transition:var(--t)}
.res-btn--primary{background:#e53e3e;color:#fff}
.res-btn--primary:hover{background:#c53030;transform:translateY(-2px)}
.res-btn--outline{background:#fff;color:var(--grey-700);border:1.5px solid var(--grey-200)}
.res-btn--outline:hover{border-color:var(--blue);color:var(--blue)}
@media(max-width:480px){.res-actions{flex-direction:column}}
</style>
@endpush