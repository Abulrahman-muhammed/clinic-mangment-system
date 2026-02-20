@extends('front.inc.master')
@section('title', 'Sign In')
@section('content')

<style>
/* ── PAGE ── */
.lg-page {
  min-height: 100vh;
  background: #f0f4f8;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  position: relative;
  overflow: hidden;
}

/* soft bg shapes */
.lg-bg-s1 {
  position: fixed; width: 600px; height: 600px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.08) 0%, transparent 70%);
  top: -200px; right: -150px; pointer-events: none;
}
.lg-bg-s2 {
  position: fixed; width: 400px; height: 400px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,168,232,0.07) 0%, transparent 70%);
  bottom: -100px; left: -100px; pointer-events: none;
}

/* ── CARD ── */
.lg-card {
  background: #fff;
  border-radius: 24px;
  padding: 52px 48px;
  width: 100%;
  max-width: 440px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 50px rgba(0,30,80,0.08);
  position: relative; z-index: 2;
}

/* Top row */
.lg-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 40px;
}
.lg-logo {
  display: flex; align-items: center; gap: 10px;
  text-decoration: none;
}
.lg-logo-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #5890df, #00a8e8);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 0.85rem;
}
.lg-logo-name {
  font-size: 1rem; font-weight: 800;
  color: #0f172a; letter-spacing: -0.3px;
}
.lg-home-link {
  font-size: 0.78rem; color: #94a3b8; text-decoration: none;
  display: flex; align-items: center; gap: 5px; font-weight: 500;
  transition: color .2s;
}
.lg-home-link:hover { color: #006aff; }

/* Heading */
.lg-heading { margin-bottom: 32px; }
.lg-heading h1 {
  font-size: 1.75rem; font-weight: 800;
  color: #0f172a; letter-spacing: -0.6px;
  margin-bottom: 5px;
}
.lg-heading p { font-size: 0.88rem; color: #94a3b8; font-weight: 400; }

/* Alert */
.lg-alert {
  display: flex; align-items: center; gap: 9px;
  background: #fef2f2; color: #dc2626;
  border: 1px solid #fecaca; border-radius: 10px;
  padding: 11px 14px; margin-bottom: 22px;
  font-size: 0.83rem; font-weight: 500;
}
.lg-alert i { flex-shrink: 0; }

/* Form */
.lg-form { display: flex; flex-direction: column; gap: 20px; }
.lg-field { display: flex; flex-direction: column; gap: 6px; }

.lg-field label {
  font-size: 0.78rem; font-weight: 700; color: #475569;
  letter-spacing: 0.05em; text-transform: uppercase;
}
.lg-input-box {
  position: relative;
  display: flex; align-items: center;
  background: #f8fafc;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  transition: border-color .2s, box-shadow .2s, background .2s;
}
.lg-input-box:focus-within {
  border-color: #006aff;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(0,106,255,0.08);
}
.lg-input-box.is-err { border-color: #f87171; background: #fff5f5; }
.lg-input-box i.lg-ico {
  padding: 0 14px 0 16px;
  color: #cbd5e1; font-size: 0.85rem;
  flex-shrink: 0; transition: color .2s;
}
.lg-input-box:focus-within i.lg-ico { color: #006aff; }
.lg-input-box input {
  flex: 1; border: none; outline: none; background: transparent;
  font-size: 0.9rem; color: #0f172a; padding: 13px 16px 13px 0;
  font-family: inherit;
}
.lg-input-box input::placeholder { color: #cbd5e1; }
.lg-input-box .lg-eye {
  padding: 0 14px; background: none; border: none;
  color: #cbd5e1; cursor: pointer; font-size: 0.88rem;
  transition: color .2s; flex-shrink: 0;
}
.lg-input-box .lg-eye:hover { color: #006aff; }
.lg-err-txt {
  font-size: 0.75rem; color: #ef4444;
  display: flex; align-items: center; gap: 4px;
}

/* Row between label and forgot */
.lg-label-row {
  display: flex; align-items: center; justify-content: space-between;
}
.lg-forgot {
  font-size: 0.78rem; color: #006aff; text-decoration: none; font-weight: 600;
  transition: color .2s;
}
.lg-forgot:hover { color: #0047cc; }

/* Remember */
.lg-check-label {
  display: flex; align-items: center; gap: 9px;
  font-size: 0.84rem; color: #64748b; cursor: pointer; user-select: none;
}
.lg-check-label input { display: none; }
.lg-checkmark {
  width: 18px; height: 18px; border-radius: 5px;
  border: 1.5px solid #cbd5e1; background: #fff;
  display: flex; align-items: center; justify-content: center;
  transition: .2s; flex-shrink: 0;
}
.lg-check-label input:checked + .lg-checkmark { background: #006aff; border-color: #006aff; }
.lg-check-label input:checked + .lg-checkmark::after {
  content: '✓'; color: #fff; font-size: 0.65rem; font-weight: 800;
}

/* Button */
.lg-btn {
  width: 100%; padding: 14px; border: none; border-radius: 50px;
  background: linear-gradient(135deg, #00a8e8, #0077b6); color: #fff;
  font-weight: 700; font-size: 1rem; font-family: inherit;
  cursor: pointer; letter-spacing: 0.01em;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: transform .25s, box-shadow .25s;
  box-shadow: 0 6px 20px rgba(0,120,182,0.35);
  margin-top: 4px;
}
.lg-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,120,182,0.45); }
.lg-btn:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

/* Footer */
.lg-footer {
  margin-top: 28px; padding-top: 24px;
  border-top: 1px solid #f1f5f9;
  text-align: center;
  font-size: 0.88rem; color: #94a3b8;
}
.lg-footer a {
  color: #006aff; font-weight: 700; text-decoration: none;
  margin-left: 4px; transition: color .2s;
}
.lg-footer a:hover { color: #0052cc; }

/* Responsive */
@media (max-width: 480px) {
  .lg-card { padding: 36px 24px; }
  .lg-heading h1 { font-size: 1.5rem; }
}
</style>

<div class="lg-page">
  <div class="lg-bg-s1"></div>
  <div class="lg-bg-s2"></div>

  <div class="lg-card">

    <!-- Top Row -->
    <div class="lg-top">
      <a href="{{ route('front.home') }}" class="lg-logo">
        <div class="lg-logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <span class="lg-logo-name">ClinicCare</span>
      </a>
      <a href="{{ route('front.home') }}" class="lg-home-link">
        <i class="fa-solid fa-arrow-left"></i> Home
      </a>
    </div>

    <!-- Heading -->
    <div class="lg-heading">
      <h1>Sign in</h1>
      <p>Welcome back — enter your details below</p>
    </div>

    <!-- Alerts -->
    @if($errors->any())
      <div class="lg-alert"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
    @endif
    @if(session('error'))
      <div class="lg-alert"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
    @endif

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="lg-form" id="lgForm">
      @csrf

      <div class="lg-field">
        <label>Email Address</label>
        <div class="lg-input-box {{ $errors->has('email') ? 'is-err' : '' }}">
          <i class="fa-solid fa-at lg-ico"></i>
          <input type="email" name="email" placeholder="you@example.com"
            value="{{ old('email') }}" autocomplete="email" />
        </div>
        @error('email')<span class="lg-err-txt"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</span>@enderror
      </div>

      <div class="lg-field">
        <div class="lg-label-row">
          <label>Password</label>
          <a href="{{ route('password.request') }}" class="lg-forgot">Forgot password?</a>
        </div>
        <div class="lg-input-box {{ $errors->has('password') ? 'is-err' : '' }}">
          <i class="fa-solid fa-lock lg-ico"></i>
          <input type="password" id="lgPw" name="password"
            placeholder="••••••••" autocomplete="current-password" />
          <button type="button" class="lg-eye" onclick="lgToggle('lgPw',this)">
            <i class="fa-regular fa-eye"></i>
          </button>
        </div>
        @error('password')<span class="lg-err-txt"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</span>@enderror
      </div>

      <label class="lg-check-label">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <span class="lg-checkmark"></span>
        Keep me signed in
      </label>

      <button type="submit" class="lg-btn" id="lgBtn">
        <span class="s1"><i class="fa-solid fa-right-to-bracket"></i> Sign In</span>
        <span class="s2" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i> Signing in…</span>
      </button>
    </form>

    <div class="lg-footer">
      Don't have an account?
      <a href="{{ route('register') }}">Create one <i class="fa-solid fa-arrow-right"></i></a>
    </div>

  </div>
</div>

@push('scripts')
<script>
function lgToggle(id, btn) {
  const inp = document.getElementById(id), i = btn.querySelector('i');
  inp.type = inp.type === 'password' ? 'text' : 'password';
  i.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}
document.getElementById('lgForm').addEventListener('submit', function(){
  const b = document.getElementById('lgBtn');
  b.querySelector('.s1').style.display = 'none';
  b.querySelector('.s2').style.display = 'flex';
  b.disabled = true;
});
</script>
@endpush

@endsection