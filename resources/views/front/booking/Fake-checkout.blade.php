@extends('front.inc.master')

@section('title', 'Secure Checkout — Stripe')

@section('content')

<section class="ck-section">
  <div class="ck-wrapper">

    {{-- ── Stripe top bar ── --}}
    <div class="ck-topbar">
      <div class="ck-topbar-inner">
        <i class="fa-brands fa-stripe ck-stripe-logo"></i>
        <div class="ck-secure-badge">
          <i class="fa-solid fa-lock"></i> Secure Payment
        </div>
      </div>
    </div>

    <div class="ck-layout">

      {{-- ── Order Summary ── --}}
      <aside class="ck-summary">
        <div class="ck-sum-header">
          <i class="fa-regular fa-calendar-check"></i>
          <h3>Order Summary</h3>
        </div>

        <div class="ck-sum-row">
          <span>Doctor</span>
          <strong>Dr. {{ $booking->doctor->user->name }}</strong>
        </div>
        <div class="ck-sum-row">
          <span>Specialty</span>
          <strong>{{ $booking->doctor->major->title }}</strong>
        </div>
        <div class="ck-sum-row">
          <span>Date</span>
          <strong>{{ $booking->formatted_date }}</strong>
        </div>
        <div class="ck-sum-row">
          <span>Time</span>
          <strong>{{ $booking->formatted_time }}</strong>
        </div>

        <div class="ck-sum-divider"></div>

        <div class="ck-sum-total">
          <span>Total</span>
          <strong>{{ number_format($booking->amount, 2) }} <em>EGP</em></strong>
        </div>

        <div class="ck-sum-note">
          <i class="fa-solid fa-shield-halved"></i>
          All transactions are encrypted and secured by Stripe.
        </div>
      </aside>

      {{-- ── Payment Form (simulated) ── --}}
      <div class="ck-main">
        <div class="ck-card">

          <h2 class="ck-title">Card Details</h2>
          <p class="ck-subtitle">This is a simulated payment — no real charge will occur.</p>

          <div class="ck-demo-notice">
            <i class="fa-solid fa-flask"></i>
            <div>
              <strong>Demo Mode.</strong>
              Use test card <code>4242 4242 4242 4242</code>, any future date, any CVC.
            </div>
          </div>

          {{-- Fake card form --}}
          <form action="{{ route('front.booking.pay-simulate', $booking) }}" method="POST" id="ck-form">
            @csrf
            <input type="hidden" name="result" id="pay-result" value="success">
            <input type="hidden" name="card_name" id="hdn-card-name">
            <input type="hidden" name="card_last4" id="hdn-card-last4">
            <input type="hidden" name="card_expiry" id="hdn-card-expiry">

            <div class="ck-field">
              <label>Cardholder Name</label>
              <div class="ck-inp">
                <i class="fa-regular fa-user"></i>
                <input type="text" id="card-name" placeholder="Name on card" autocomplete="cc-name">
              </div>
            </div>

            <div class="ck-field">
              <label>Card Number</label>
              <div class="ck-inp">
                <i class="fa-regular fa-credit-card"></i>
                <input type="text" id="card-number" maxlength="19"
                       placeholder="1234 5678 9012 3456" autocomplete="cc-number">
                <div class="ck-card-brands">
                  <svg viewBox="0 0 48 16" height="12" fill="none">
                    <text y="13" font-size="13" font-weight="700" fill="#1a1f71" font-family="Arial">VISA</text>
                  </svg>
                  <svg viewBox="0 0 32 20" height="12">
                    <circle cx="12" cy="10" r="10" fill="#EB001B"/>
                    <circle cx="20" cy="10" r="10" fill="#F79E1B"/>
                    <path d="M16 4.8a10 10 0 0 1 0 10.4A10 10 0 0 1 16 4.8z" fill="#FF5F00"/>
                  </svg>
                </div>
              </div>
            </div>

            <div class="ck-row-2">
              <div class="ck-field">
                <label>Expiry Date</label>
                <div class="ck-inp">
                  <i class="fa-regular fa-calendar"></i>
                  <input type="text" id="card-expiry" maxlength="5"
                         placeholder="MM/YY" autocomplete="cc-exp">
                </div>
              </div>

              <div class="ck-field">
                <label>CVC</label>
                <div class="ck-inp">
                  <i class="fa-solid fa-lock"></i>
                  <input type="text" id="card-cvc" maxlength="4"
                         placeholder="•••" autocomplete="cc-csc">
                </div>
              </div>
            </div>

            {{-- Submit / Fail buttons --}}
            <button type="submit" class="ck-btn ck-btn--pay" id="pay-btn">
              <i class="fa-solid fa-lock"></i>
              Pay {{ number_format($booking->amount, 2) }} EGP
            </button>

            <button type="button" class="ck-btn ck-btn--fail" id="fail-btn">
              <i class="fa-solid fa-circle-xmark"></i>
              Simulate Payment Failure
            </button>

          </form>

          <p class="ck-cancel-link">
            <a href="{{ route('front.booking.create', $booking->doctor) }}">
              <i class="fa-solid fa-arrow-left"></i> Cancel & go back
            </a>
          </p>

        </div>
      </div>

    </div>
  </div>
</section>

@endsection

@push('style')
<style>
/* ─── Layout ─── */
.ck-section{min-height:100vh;background:#f6f6fb;display:flex;flex-direction:column}
.ck-wrapper{max-width:1000px;margin:0 auto;padding:0 20px 80px;flex:1}

/* ─── Top bar ─── */
.ck-topbar{background:#fff;border-bottom:1px solid #e5e7eb;padding:14px 0;margin-bottom:40px}
.ck-topbar-inner{max-width:1000px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:space-between}
.ck-stripe-logo{font-size:2.2rem;color:#635bff}
.ck-secure-badge{display:flex;align-items:center;gap:7px;font-size:.78rem;font-weight:600;color:#374151}
.ck-secure-badge i{color:#10b981}

/* ─── Grid ─── */
.ck-layout{display:grid;grid-template-columns:1fr 1.5fr;gap:24px;align-items:start}

/* ─── Summary ─── */
.ck-summary{background:#fff;border-radius:16px;padding:24px 22px;border:1px solid #e5e7eb;box-shadow:0 1px 6px rgba(0,0,0,.06);position:sticky;top:24px}
.ck-sum-header{display:flex;align-items:center;gap:10px;margin-bottom:20px;font-family:'Fraunces',serif;font-size:1.1rem;font-weight:700;color:#111}
.ck-sum-header i{color:#635bff;font-size:1.1rem}
.ck-sum-row{display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px dashed #e5e7eb;font-size:.8rem;color:#6b7280}
.ck-sum-row strong{color:#111;font-size:.82rem}
.ck-sum-divider{height:1px;background:#e5e7eb;margin:12px 0}
.ck-sum-total{display:flex;justify-content:space-between;align-items:center;font-size:.88rem;font-weight:700;color:#111}
.ck-sum-total strong{font-family:'Fraunces',serif;font-size:1.5rem;color:#635bff}
.ck-sum-total em{font-style:normal;font-size:.7rem;color:#9ca3af;font-family:'DM Sans',sans-serif}
.ck-sum-note{margin-top:16px;font-size:.73rem;color:#9ca3af;display:flex;align-items:flex-start;gap:7px;line-height:1.6}
.ck-sum-note i{color:#10b981;flex-shrink:0;margin-top:2px}

/* ─── Card ─── */
.ck-card{background:#fff;border-radius:16px;padding:32px 28px;border:1px solid #e5e7eb;box-shadow:0 1px 6px rgba(0,0,0,.06)}
.ck-title{font-family:'Fraunces',serif;font-size:1.35rem;font-weight:700;color:#111;margin-bottom:4px}
.ck-subtitle{font-size:.8rem;color:#9ca3af;margin-bottom:22px}

/* ─── Demo notice ─── */
.ck-demo-notice{background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:12px 15px;font-size:.79rem;color:#92400e;display:flex;align-items:flex-start;gap:10px;margin-bottom:24px;line-height:1.6}
.ck-demo-notice i{color:#d97706;flex-shrink:0;margin-top:2px}
.ck-demo-notice code{background:#fde68a;padding:1px 6px;border-radius:4px;font-size:.78rem;letter-spacing:.06em}

/* ─── Fields ─── */
.ck-field{margin-bottom:16px}
.ck-field label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:7px}
.ck-inp{position:relative;display:flex;align-items:center}
.ck-inp>i:first-child{position:absolute;left:13px;color:#9ca3af;font-size:.8rem;pointer-events:none}
.ck-inp input{width:100%;padding:12px 14px 12px 38px;border:1.5px solid #d1d5db;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.86rem;color:#111;outline:none;transition:.2s}
.ck-inp input:focus{border-color:#635bff;box-shadow:0 0 0 3px rgba(99,91,255,.1)}
.ck-row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.ck-card-brands{position:absolute;right:12px;display:flex;gap:5px;align-items:center}

/* ─── Buttons ─── */
.ck-btn{width:100%;padding:14px;border:none;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:.2s;margin-top:12px}
.ck-btn--pay{background:#635bff;color:#fff;box-shadow:0 6px 20px rgba(99,91,255,.35)}
.ck-btn--pay:hover{background:#4f46e5;transform:translateY(-2px)}
.ck-btn--fail{background:#fff;color:#ef4444;border:1.5px solid #fca5a5}
.ck-btn--fail:hover{background:#fff5f5}
.ck-cancel-link{text-align:center;margin-top:18px;font-size:.8rem}
.ck-cancel-link a{color:#9ca3af;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:7px}
.ck-cancel-link a:hover{color:#635bff}

/* ─── Responsive ─── */
@media(max-width:680px){.ck-layout{grid-template-columns:1fr}.ck-summary{position:static}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Format card number with spaces ──
  const cardNum = document.getElementById('card-number');
  cardNum.addEventListener('input', function () {
    let v = this.value.replace(/\D/g,'').slice(0,16);
    this.value = v.replace(/(.{4})/g,'$1 ').trim();
  });

  // ── Format expiry MM/YY ──
  const expiry = document.getElementById('card-expiry');
  expiry.addEventListener('input', function () {
    let v = this.value.replace(/\D/g,'').slice(0,4);
    if (v.length >= 3) v = v.slice(0,2) + '/' + v.slice(2);
    this.value = v;
  });

  // ── On Pay click → validate + fill hiddens ──
  document.getElementById('pay-btn').addEventListener('click', function (e) {
    e.preventDefault();

    const name   = document.getElementById('card-name').value.trim();
    const num    = document.getElementById('card-number').value.replace(/\s/g,'');
    const exp    = document.getElementById('card-expiry').value.trim();
    const cvc    = document.getElementById('card-cvc').value.trim();

    if (!name)            { showError('Please enter cardholder name.'); return; }
    if (num.length < 16)  { showError('Please enter a valid 16-digit card number.'); return; }
    if (!/^\d{2}\/\d{2}$/.test(exp)) { showError('Please enter expiry as MM/YY.'); return; }
    if (cvc.length < 3)   { showError('Please enter a valid CVC.'); return; }

    document.getElementById('pay-result').value  = 'success';
    document.getElementById('hdn-card-name').value  = name;
    document.getElementById('hdn-card-last4').value = num.slice(-4);
    document.getElementById('hdn-card-expiry').value = exp;

    // Show loading state
    const btn = document.getElementById('pay-btn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    // Simulate 1.5s delay for realism
    setTimeout(() => { btn.closest('form').submit(); }, 1500);
  });

  // ── Fail button ──
  document.getElementById('fail-btn').addEventListener('click', function () {
    document.getElementById('pay-result').value = 'fail';
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
    this.disabled = true;
    setTimeout(() => { document.getElementById('ck-form').submit(); }, 1200);
  });

  function showError(msg) {
    // Remove old error
    document.querySelectorAll('.ck-error').forEach(e => e.remove());
    const div = document.createElement('div');
    div.className = 'ck-error';
    div.style.cssText = 'background:#fff5f5;border:1px solid #fca5a5;color:#c53030;padding:10px 14px;border-radius:8px;font-size:.8rem;margin-bottom:12px;';
    div.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> ${msg}`;
    document.getElementById('ck-form').prepend(div);
  }
});
</script>
@endpush