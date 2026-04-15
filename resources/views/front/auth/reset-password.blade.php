@extends('front.inc.master')

@section('title')
Reset Password — {{ config('app.name') }}
@endsection

@section('content')

<style>

*, *::before, *::after { box-sizing: border-box; }

:root {
  --blue:       #006aff;
  --blue-mid:   #0052cc;
  --blue-dark:  #003180;
  --blue-soft:  #f2f6ff;
  --gold:       #c9a84c;
  --white:      #ffffff;
  --grey-100:   #f7f8fc;
  --grey-200:   #eef0f6;
  --grey-300:   #d8dce8;
  --grey-500:   #8892aa;
  --grey-700:   #3d4a63;
  --text:       #05143a;
  --danger:     #dc2626;
  --success:    #16a34a;
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
  --t: 0.4s var(--ease);
  --shadow-card: 0 2px 12px rgba(5,20,58,0.07), 0 8px 32px rgba(5,20,58,0.05);
  --shadow-btn:  0 4px 20px rgba(0,106,255,0.35);
}

.fp-page {
  min-height: 100vh;
  background: var(--grey-100);
  display: flex; align-items: center; justify-content: center;
  padding: 32px 24px;
  position: relative; overflow: hidden;
}

.fp-blob { position: fixed; border-radius: 50%; pointer-events: none; z-index: 0; }
.fp-blob-1 {
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,106,255,0.06) 0%, transparent 70%);
  top: -220px; right: -160px;
}
.fp-blob-2 {
  width: 400px; height: 400px;
  background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
  bottom: -110px; left: -90px;
}

.fp-wrap {
  position: relative; z-index: 2;
  width: 100%; max-width: 460px;
  animation: fpUp 0.7s var(--ease) both;
}
@keyframes fpUp { from { opacity:0; transform:translateY(32px); } to { opacity:1; transform:translateY(0); } }

.fp-card {
  background: var(--white);
  border: 1px solid var(--grey-200);
  border-radius: 28px; padding: 52px 48px;
  box-shadow: var(--shadow-card);
  position: relative; overflow: hidden;
}
.fp-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--blue), var(--gold));
}

.fp-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 36px; }
.fp-logo {
  font-family: 'Fraunces', serif;
  font-size: 1.25rem; font-weight: 700; font-style: italic;
  color: var(--blue-dark); text-decoration: none; letter-spacing: -0.3px;
  display: flex; align-items: center; gap: 10px;
}
.fp-logo span { color: var(--blue); font-style: normal; }
.fp-logo-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #003180, var(--blue));
  display: flex; align-items: center; justify-content: center;
  color: var(--white); font-size: 0.85rem;
  box-shadow: 0 4px 12px rgba(0,106,255,0.25);
}
.fp-back-link {
  font-size: 0.78rem; font-weight: 600; color: var(--grey-500);
  text-decoration: none; display: flex; align-items: center; gap: 6px;
  padding: 7px 16px; border: 1px solid var(--grey-200); border-radius: 999px;
  transition: var(--t);
}
.fp-back-link:hover { color: var(--blue); border-color: var(--blue); background: var(--blue-soft); }

.fp-icon-wrap {
  width: 68px; height: 68px; border-radius: 50%;
  background: var(--blue-soft); border: 2px solid rgba(0,106,255,0.12);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 22px;
  animation: popIn 0.6s var(--ease) 0.3s both;
}
@keyframes popIn { from { opacity:0; transform:scale(0.7); } to { opacity:1; transform:scale(1); } }
.fp-icon-wrap i { font-size: 1.7rem; color: var(--blue); }

.fp-heading h1 {
  font-family: 'Fraunces', serif;
  font-size: 2.1rem; font-weight: 700; letter-spacing: -0.6px;
  color: var(--text); line-height: 1.15; margin-bottom: 6px;
}
.fp-heading h1 em { font-style: italic; color: var(--blue); }
.fp-heading p { font-size: 0.88rem; color: var(--grey-500); font-weight: 300; line-height: 1.7; }
.fp-divider { width: 40px; height: 2px; margin: 20px 0 28px; background: linear-gradient(90deg, var(--blue), var(--gold)); border-radius: 2px; }

.fp-alert {
  display: flex; align-items: center; gap: 9px;
  padding: 12px 16px; border-radius: 14px;
  font-size: 0.83rem; font-weight: 500; margin-bottom: 22px;
  animation: fpAlert .3s ease;
}
.fp-alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }
.fp-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: var(--success); font-weight: 600; }
@keyframes fpAlert { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }

.fp-form { display: flex; flex-direction: column; gap: 20px; }
.fp-field { display: flex; flex-direction: column; gap: 7px; }
.fp-field label {
  font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--grey-700);
}
.fp-input-box {
  display: flex; align-items: center;
  background: var(--grey-100); border: 1.5px solid var(--grey-200);
  border-radius: 14px; overflow: hidden;
  transition: border-color var(--t), box-shadow var(--t), background var(--t);
}
.fp-input-box:focus-within {
  border-color: var(--blue); background: var(--white);
  box-shadow: 0 0 0 4px rgba(0,106,255,0.08);
}
.fp-input-box.is-err { border-color: var(--danger); background: #fff9f9; }
.fp-ico { padding: 0 12px 0 16px; color: var(--grey-300); font-size: 0.82rem; flex-shrink: 0; transition: color var(--t); }
.fp-input-box:focus-within .fp-ico { color: var(--blue); }
.fp-input-box input {
  flex: 1; border: none; outline: none; background: transparent;
  font-family: 'DM Sans', sans-serif; font-size: 0.9rem; color: var(--text);
  padding: 13px 14px 13px 0;
}
.fp-input-box input::placeholder { color: var(--grey-300); }
.fp-err-txt { font-size: 0.73rem; color: var(--danger); display: flex; align-items: center; gap: 4px; }

/* Eye toggle button inside input box */
.fp-eye-btn {
  background: none; border: none; cursor: pointer;
  color: var(--grey-300); font-size: 0.82rem;
  padding: 0 14px 0 0; flex-shrink: 0;
  display: flex; align-items: center;
  transition: color var(--t);
}
.fp-eye-btn:hover { color: var(--blue); }
.fp-input-box:focus-within .fp-eye-btn { color: var(--grey-500); }

.fp-match-msg {
  font-size: 0.73rem; font-weight: 600;
  display: flex; align-items: center; gap: 4px;
  margin-top: 2px;
}

.fp-btn {
  width: 100%; padding: 15px; border: none; border-radius: 999px;
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  color: var(--white); font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; font-weight: 700; letter-spacing: 0.02em;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: transform var(--t), box-shadow var(--t);
  box-shadow: var(--shadow-btn); position: relative; overflow: hidden;
}
.fp-btn::before {
  content: ''; position: absolute; top: 0; left: -75%;
  width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
  transform: skewX(-15deg); transition: left 0.5s ease;
}
.fp-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,106,255,0.45); }
.fp-btn:hover::before { left: 125%; }
.fp-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

.fp-footer {
  margin-top: 28px; padding-top: 24px;
  border-top: 1px solid var(--grey-200);
  text-align: center; font-size: 0.88rem; color: var(--grey-500);
}
.fp-footer a { color: var(--blue); font-weight: 700; text-decoration: none; margin-left: 4px; transition: color var(--t); }
.fp-footer a:hover { color: var(--blue-mid); }

@media (max-width: 480px) {
  .fp-card { padding: 36px 24px; }
  .fp-heading h1 { font-size: 1.7rem; }
}
</style>

<div class="fp-page">
  <div class="fp-blob fp-blob-1"></div>
  <div class="fp-blob fp-blob-2"></div>

  <div class="fp-wrap">
    <div class="fp-card">

      {{-- Top Row --}}
      <div class="fp-top">
        <a href="{{ route('front.home') }}" class="fp-logo">
          <div class="fp-logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
          Clinic<span>Care</span>
        </a>
        <a href="{{ route('login') }}" class="fp-back-link">
          <i class="fa-solid fa-arrow-left"></i> Back to login
        </a>
      </div>

      {{-- Icon --}}
      <div class="fp-icon-wrap">
        <i class="fa-solid fa-lock-open"></i>
      </div>

      {{-- Heading --}}
      <div class="fp-heading">
        <h1>Set a new <em>password</em></h1>
        <p>Choose a strong password and you'll be back in action in no time.</p>
      </div>
      <div class="fp-divider"></div>

      {{-- Validation errors --}}
      @if ($errors->any())
        <div class="fp-alert fp-alert-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Form --}}
      <form action="{{ route('password.store') }}" method="POST" class="fp-form" id="rpForm">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div class="fp-field">
          <label>Email Address</label>
          <div class="fp-input-box {{ $errors->has('email') ? 'is-err' : '' }}">
            <i class="fa-solid fa-at fp-ico"></i>
            <input
              type="email"
              name="email"
              placeholder="you@example.com"
              value="{{ old('email', request('email')) }}"
              autocomplete="email"
            />
          </div>
          @error('email')
            <span class="fp-err-txt">
              <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
          @enderror
        </div>

        {{-- New Password --}}
        <div class="fp-field">
          <label>New Password</label>
          <div class="fp-input-box {{ $errors->has('password') ? 'is-err' : '' }}">
            <i class="fa-solid fa-lock fp-ico"></i>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Min. 8 characters"
              autocomplete="new-password"
            />
            <button type="button" class="fp-eye-btn" onclick="rpToggle('password', this)">
              <i class="fa-regular fa-eye"></i>
            </button>
          </div>
          @error('password')
            <span class="fp-err-txt">
              <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
            </span>
          @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="fp-field">
          <label>Confirm Password</label>
          <div class="fp-input-box {{ $errors->has('password_confirmation') ? 'is-err' : '' }}">
            <i class="fa-solid fa-lock fp-ico"></i>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              placeholder="Repeat your password"
              autocomplete="new-password"
            />
            <button type="button" class="fp-eye-btn" onclick="rpToggle('password_confirmation', this)">
              <i class="fa-regular fa-eye"></i>
            </button>
          </div>
          <span class="fp-match-msg" id="matchMsg" style="display:none;"></span>
        </div>

        <button type="submit" class="fp-btn" id="rpBtn">
          <span class="s1"><i class="fa-solid fa-shield-check"></i> Reset Password</span>
          <span class="s2" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i> Resetting…</span>
        </button>

      </form>

      <div class="fp-footer">
        Remember your password?
        <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left"></i> Back to Sign In</a>
      </div>

    </div>
  </div>
</div>

<script>
function rpToggle(id, btn) {
  const inp = document.getElementById(id);
  const i   = btn.querySelector('i');
  inp.type  = inp.type === 'password' ? 'text' : 'password';
  i.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}

document.getElementById('password_confirmation').addEventListener('input', function () {
  const msg   = document.getElementById('matchMsg');
  const match = this.value === document.getElementById('password').value;
  if (!this.value) { msg.style.display = 'none'; return; }
  msg.style.display = 'flex';
  msg.innerHTML = match
    ? '<i class="fa-solid fa-circle-check" style="color:#16a34a"></i> <span style="color:#16a34a">Passwords match</span>'
    : '<i class="fa-solid fa-circle-xmark" style="color:#dc2626"></i> <span style="color:#dc2626">Passwords do not match</span>';
});

document.getElementById('rpForm').addEventListener('submit', function () {
  const btn = document.getElementById('rpBtn');
  btn.querySelector('.s1').style.display = 'none';
  btn.querySelector('.s2').style.display = 'flex';
  btn.disabled = true;
});
</script>

@endsection