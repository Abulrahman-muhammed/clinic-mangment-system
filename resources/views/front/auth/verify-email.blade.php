@extends('front.inc.master')
@section('title', 'Verify Your Email')
@section('content')

<style>
/* ── PAGE ── */
.vr-page {
  min-height: 100vh;
  background: #f0f4f8;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  position: relative;
  overflow: hidden;
}

.vr-bg-s1 {
  position: fixed; width: 600px; height: 600px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.08) 0%, transparent 70%);
  top: -200px; right: -150px; pointer-events: none;
}
.vr-bg-s2 {
  position: fixed; width: 400px; height: 400px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,168,232,0.07) 0%, transparent 70%);
  bottom: -100px; left: -100px; pointer-events: none;
}

/* ── CARD ── */
.vr-card {
  background: #fff;
  border-radius: 24px;
  padding: 52px 48px;
  width: 100%;
  max-width: 460px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 50px rgba(0,30,80,0.08);
  position: relative; z-index: 2;
  text-align: center;
}

/* Top row */
.vr-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 40px;
  text-align: left;
}
.vr-logo {
  display: flex; align-items: center; gap: 10px;
  text-decoration: none;
}
.vr-logo-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #5890df, #00a8e8);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 0.85rem;
}
.vr-logo-name {
  font-size: 1rem; font-weight: 800;
  color: #0f172a; letter-spacing: -0.3px;
}
.vr-home-link {
  font-size: 0.78rem; color: #94a3b8; text-decoration: none;
  display: flex; align-items: center; gap: 5px; font-weight: 500;
  transition: color .2s;
}
.vr-home-link:hover { color: #006aff; }

/* ── Icon ── */
.vr-icon-wrap {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e0f2fe, #dbeafe);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 28px;
  position: relative;
  animation: vrPulse 2.5s ease-in-out infinite;
}
.vr-icon-wrap i {
  font-size: 2rem;
  background: linear-gradient(135deg, #00a8e8, #006aff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.vr-icon-wrap::before {
  content: '';
  position: absolute; inset: -6px;
  border-radius: 50%;
  border: 2px dashed rgba(0, 106, 255, 0.2);
  animation: vrSpin 12s linear infinite;
}

@keyframes vrPulse {
  0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0,106,255,0.15); }
  50%       { transform: scale(1.04); box-shadow: 0 0 0 12px rgba(0,106,255,0); }
}
@keyframes vrSpin {
  from { transform: rotate(0deg); }
  to   { transform: rotate(360deg); }
}

/* ── Heading ── */
.vr-heading h1 {
  font-size: 1.7rem; font-weight: 800;
  color: #0f172a; letter-spacing: -0.5px;
  margin-bottom: 10px;
}
.vr-heading p {
  font-size: 0.88rem; color: #64748b;
  line-height: 1.7; max-width: 320px; margin: 0 auto 28px;
}
.vr-heading p strong { color: #0f172a; font-weight: 700; }

/* ── Alerts ── */
.vr-alert-success {
  display: flex; align-items: center; gap: 10px;
  background: linear-gradient(135deg, #f0fdf4, #dcfce7);
  color: #16a34a;
  border: 1px solid #86efac;
  border-radius: 12px;
  padding: 13px 16px; margin-bottom: 24px;
  font-size: 0.84rem; font-weight: 600;
  box-shadow: 0 2px 8px rgba(22,163,74,0.1);
  animation: vrSlideIn .3s ease;
  text-align: left;
}
.vr-alert-success i { flex-shrink: 0; font-size: 1rem; color: #22c55e; }

.vr-alert-error {
  display: flex; align-items: center; gap: 10px;
  background: #fef2f2; color: #dc2626;
  border: 1px solid #fecaca; border-radius: 12px;
  padding: 13px 16px; margin-bottom: 24px;
  font-size: 0.84rem; font-weight: 600;
  animation: vrSlideIn .3s ease;
  text-align: left;
}
.vr-alert-error i { flex-shrink: 0; }

@keyframes vrSlideIn {
  from { opacity: 0; transform: translateY(-8px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── Steps ── */
.vr-steps {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-bottom: 32px;
}
.vr-step {
  display: flex; align-items: center; gap: 7px;
  font-size: 0.75rem; font-weight: 600; color: #94a3b8;
}
.vr-step-num {
  width: 22px; height: 22px; border-radius: 50%;
  background: #e2e8f0; color: #94a3b8;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.7rem; font-weight: 800;
  flex-shrink: 0;
}
.vr-step.done .vr-step-num {
  background: #22c55e; color: #fff;
}
.vr-step.active .vr-step-num {
  background: linear-gradient(135deg, #00a8e8, #006aff); color: #fff;
}
.vr-step.active { color: #0f172a; }
.vr-step-divider {
  width: 24px; height: 1.5px; background: #e2e8f0;
  flex-shrink: 0; margin-bottom: 1px;
}

/* ── Button ── */
.vr-btn {
  width: 100%; padding: 14px; border: none; border-radius: 50px;
  background: linear-gradient(135deg, #00a8e8, #0077b6); color: #fff;
  font-weight: 700; font-size: 0.95rem; font-family: inherit;
  cursor: pointer; letter-spacing: 0.01em;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: transform .25s, box-shadow .25s;
  box-shadow: 0 6px 20px rgba(0,120,182,0.35);
  text-decoration: none;
}
.vr-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,120,182,0.45); color: #fff; }
.vr-btn:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

.vr-btn-outline {
  width: 100%; padding: 13px; border: 1.5px solid #e2e8f0; border-radius: 50px;
  background: transparent; color: #64748b;
  font-weight: 600; font-size: 0.88rem; font-family: inherit;
  cursor: pointer; letter-spacing: 0.01em;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: all .2s; margin-top: 12px; text-decoration: none;
}
.vr-btn-outline:hover { border-color: #006aff; color: #006aff; background: rgba(0,106,255,0.04); }

/* cooldown */
.vr-cooldown {
  font-size: 0.78rem; color: #94a3b8;
  margin-top: 16px;
  display: flex; align-items: center; justify-content: center; gap: 5px;
}
.vr-cooldown #vrTimer { font-weight: 700; color: #006aff; }

/* ── Footer ── */
.vr-footer {
  margin-top: 28px; padding-top: 24px;
  border-top: 1px solid #f1f5f9;
  font-size: 0.82rem; color: #94a3b8;
}
.vr-footer a {
  color: #ef4444; font-weight: 600; text-decoration: none;
  transition: color .2s;
}
.vr-footer a:hover { color: #dc2626; }

/* Responsive */
@media (max-width: 480px) {
  .vr-card { padding: 36px 24px; }
  .vr-heading h1 { font-size: 1.4rem; }
}
</style>

<div class="vr-page">
  <div class="vr-bg-s1"></div>
  <div class="vr-bg-s2"></div>

  <div class="vr-card">

    <!-- Top Row -->
    <div class="vr-top">
      <a href="{{ route('front.home') }}" class="vr-logo">
        <div class="vr-logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <span class="vr-logo-name">ClinicCare</span>
      </a>
      <a href="{{ route('front.home') }}" class="vr-home-link">
        <i class="fa-solid fa-arrow-left"></i> Home
      </a>
    </div>

    <!-- Steps -->
    <div class="vr-steps">
      <div class="vr-step done">
        <div class="vr-step-num"><i class="fa-solid fa-check" style="font-size:0.6rem;"></i></div>
        Register
      </div>
      <div class="vr-step-divider"></div>
      <div class="vr-step active">
        <div class="vr-step-num">2</div>
        Verify Email
      </div>
      <div class="vr-step-divider"></div>
      <div class="vr-step">
        <div class="vr-step-num">3</div>
        Done
      </div>
    </div>

    <!-- Icon -->
    <div class="vr-icon-wrap">
      <i class="fa-solid fa-envelope"></i>
    </div>

    <!-- Heading -->
    <div class="vr-heading">
      <h1>Check your inbox</h1>
      <p>
        We've sent a verification link to<br>
        <strong>{{ Auth::user()->email }}</strong><br>
        Click the link in the email to activate your account.
      </p>
    </div>

    <!-- Alerts -->
    @if(session('status') == 'verification-link-sent')
      <div class="vr-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <span>A new verification link has been sent to your email!</span>
      </div>
    @endif

    @if($errors->any())
      <div class="vr-alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ $errors->first() }}
      </div>
    @endif

    <!-- Resend Button -->
    <form method="POST" action="{{ route('verification.send') }}" id="vrForm">
      @csrf
      <button type="submit" class="vr-btn" id="vrBtn">
        <i class="fa-solid fa-paper-plane"></i>
        <span id="vrBtnText">Resend Verification Email</span>
      </button>
    </form>

    <!-- Cooldown hint -->
    <div class="vr-cooldown" id="vrCooldown" style="display:none;">
      <i class="fa-regular fa-clock"></i>
      You can resend in <span id="vrTimer">60</span>s
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="vr-btn-outline">
        <i class="fa-solid fa-right-from-bracket"></i>
        Sign out & use different account
      </button>
    </form>

    <!-- Footer note -->
    <div class="vr-footer">
      Didn't get the email? Check your spam folder, or
      <a href="#" onclick="document.getElementById('vrForm').submit(); return false;">resend it</a>.
    </div>

  </div>
</div>

@push('scripts')
<script>
// Cooldown after submit
document.getElementById('vrForm').addEventListener('submit', function() {
  const btn      = document.getElementById('vrBtn');
  const cooldown = document.getElementById('vrCooldown');
  const timerEl  = document.getElementById('vrTimer');

  btn.disabled = true;
  btn.style.opacity = '0.6';

  @if(session('status') == 'verification-link-sent')
    // Already sent — start cooldown immediately on page load
    startCooldown();
  @endif

  function startCooldown() {
    cooldown.style.display = 'flex';
    let t = 60;
    timerEl.textContent = t;
    const iv = setInterval(() => {
      t--;
      timerEl.textContent = t;
      if (t <= 0) {
        clearInterval(iv);
        btn.disabled = false;
        btn.style.opacity = '1';
        cooldown.style.display = 'none';
      }
    }, 1000);
  }
});

// Auto-start cooldown if link was just sent
@if(session('status') == 'verification-link-sent')
(function() {
  const btn      = document.getElementById('vrBtn');
  const cooldown = document.getElementById('vrCooldown');
  const timerEl  = document.getElementById('vrTimer');
  btn.disabled   = true;
  btn.style.opacity = '0.6';
  cooldown.style.display = 'flex';
  let t = 60;
  timerEl.textContent = t;
  const iv = setInterval(() => {
    t--;
    timerEl.textContent = t;
    if (t <= 0) {
      clearInterval(iv);
      btn.disabled = false;
      btn.style.opacity = '1';
      cooldown.style.display = 'none';
    }
  }, 1000);
})();
@endif
</script>
@endpush

@endsection