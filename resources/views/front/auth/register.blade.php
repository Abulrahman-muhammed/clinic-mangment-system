<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Register — {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,300;1,9..144,400&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --blue:       #006aff;
  --blue-mid:   #0052cc;
  --blue-dark:  #003180;
  --blue-ink:   #05143a;
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

html, body { height: 100%; font-family: 'DM Sans', sans-serif; -webkit-font-smoothing: antialiased; }

/* ── LAYOUT ── */
.rg-page {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
}

/* ══ LEFT PANEL ══ */
.rg-left {
  background: var(--blue-ink);
  position: sticky; top: 0; height: 100vh;
  display: flex; flex-direction: column;
  overflow: hidden;
}
.rg-mesh {
  position: absolute; inset: 0; z-index: 0;
  background:
    radial-gradient(ellipse 80% 60% at 20% 10%, rgba(0,106,255,0.22) 0%, transparent 60%),
    radial-gradient(ellipse 60% 50% at 85% 80%, rgba(201,168,76,0.14) 0%, transparent 55%),
    radial-gradient(ellipse 50% 70% at 70% 20%, rgba(0,82,204,0.18) 0%, transparent 50%);
  animation: meshMove 12s ease-in-out infinite alternate;
}
@keyframes meshMove {
  0%   { filter: hue-rotate(0deg) brightness(1); }
  100% { filter: hue-rotate(8deg) brightness(1.06); }
}
.rg-grid {
  position: absolute; inset: 0; z-index: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
  background-size: 48px 48px;
}

.rg-nav {
  position: relative; z-index: 10;
  padding: 28px 36px 0;
  display: flex; align-items: center; justify-content: space-between;
}
.rg-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
.rg-brand-icon {
  width: 38px; height: 38px; border-radius: 10px;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.2);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.9rem; color: var(--white); backdrop-filter: blur(8px);
}
.rg-brand-name {
  font-family: 'Fraunces', serif;
  font-size: 1.15rem; font-weight: 700; font-style: italic;
  color: var(--white); letter-spacing: -0.2px;
}
.rg-brand-name em { font-style: normal; color: rgba(255,255,255,0.45); }
.rg-back {
  font-size: 0.75rem; font-weight: 600;
  color: rgba(255,255,255,0.45); text-decoration: none;
  display: flex; align-items: center; gap: 6px;
  padding: 6px 14px; border: 1px solid rgba(255,255,255,0.1);
  border-radius: 999px; transition: var(--t); backdrop-filter: blur(8px);
}
.rg-back:hover { color: var(--white); border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.07); }

.rg-left-body { position: relative; z-index: 5; padding: 40px 36px 0; flex: 1; }
.rg-tag {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(201,168,76,0.15); border: 1px solid rgba(201,168,76,0.3);
  border-radius: 999px; padding: 5px 14px;
  font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em;
  color: var(--gold); text-transform: uppercase; margin-bottom: 20px;
}
.rg-tag-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); animation: blink 2s infinite; }
@keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0.3;} }

.rg-h {
  font-family: 'Fraunces', serif;
  font-size: 2.6rem; font-weight: 700; line-height: 1.12;
  letter-spacing: -0.8px; color: var(--white); margin-bottom: 16px;
}
.rg-h em { font-style: italic; color: rgba(255,255,255,0.4); }
.rg-p {
  font-size: 0.88rem; color: rgba(255,255,255,0.5);
  font-weight: 300; line-height: 1.8; max-width: 320px; margin-bottom: 36px;
}

.rg-feat-cards { display: flex; flex-direction: column; gap: 12px; }
.rg-feat-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 16px; padding: 16px 18px;
  display: flex; align-items: center; gap: 14px;
  backdrop-filter: blur(12px); transition: var(--t);
  animation: slideIn 0.7s var(--ease) both;
}
.rg-feat-card:nth-child(1) { animation-delay: 0.1s; }
.rg-feat-card:nth-child(2) { animation-delay: 0.22s; }
.rg-feat-card:nth-child(3) { animation-delay: 0.34s; }
@keyframes slideIn { from{opacity:0;transform:translateX(-20px);} to{opacity:1;transform:translateX(0);} }
.rg-feat-card:hover { background: rgba(255,255,255,0.09); border-color: rgba(255,255,255,0.16); transform: translateX(5px); }

.rg-feat-ico {
  width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.rg-ico-1 { background: rgba(0,106,255,0.2); color: #63b3ed; }
.rg-ico-2 { background: rgba(201,168,76,0.18); color: var(--gold); }
.rg-ico-3 { background: rgba(22,163,74,0.18); color: #4ade80; }

.rg-feat-card strong { display: block; font-size: 0.88rem; font-weight: 600; color: var(--white); margin-bottom: 2px; }
.rg-feat-card span { font-size: 0.75rem; color: rgba(255,255,255,0.45); font-weight: 300; }

.rg-stats {
  position: relative; z-index: 5;
  padding: 24px 36px 32px; display: flex;
  border-top: 1px solid rgba(255,255,255,0.07); margin-top: auto;
}
.rg-stat { flex: 1; text-align: center; padding: 0 16px; position: relative; }
.rg-stat + .rg-stat::before {
  content: ''; position: absolute; left: 0; top: 20%; bottom: 20%;
  width: 1px; background: rgba(255,255,255,0.1);
}
.rg-stat-num {
  font-family: 'Fraunces', serif;
  font-size: 1.6rem; font-weight: 700; color: var(--white); line-height: 1; margin-bottom: 4px;
}
.rg-stat-num span { color: var(--gold); }
.rg-stat-lbl { font-size: 0.68rem; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; }

/* ══ RIGHT PANEL ══ */
.rg-right {
  background: var(--grey-100);
  display: flex; align-items: center; justify-content: center;
  padding: 48px 52px; overflow-y: auto;
}
.rg-form-wrap {
  width: 100%; max-width: 480px;
  animation: formIn 0.65s var(--ease) both; animation-delay: 0.15s;
}
@keyframes formIn { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }

.rg-fh { margin-bottom: 10px; }
.rg-fh h1 {
  font-family: 'Fraunces', serif;
  font-size: 1.9rem; font-weight: 700; letter-spacing: -0.5px;
  color: var(--text); line-height: 1.15; margin-bottom: 5px;
}
.rg-fh h1 em { font-style: italic; color: var(--blue); }
.rg-fh p { font-size: 0.87rem; color: var(--grey-500); font-weight: 300; }
.rg-line { width: 40px; height: 2px; background: linear-gradient(90deg, var(--blue), var(--gold)); border-radius: 2px; margin: 18px 0 24px; }

.rg-steps {
  display: flex; align-items: center;
  background: var(--white); border: 1px solid var(--grey-200);
  border-radius: 14px; padding: 14px 20px; margin-bottom: 28px;
}
.rg-step { display: flex; align-items: center; gap: 8px; flex: 1; }
.rg-step-dot {
  width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.68rem; font-weight: 800; font-family: 'Fraunces', serif;
  border: 1.5px solid var(--grey-300); color: var(--grey-500); transition: var(--t);
}
.rg-step.active .rg-step-dot { background: var(--blue); border-color: var(--blue); color: var(--white); box-shadow: 0 3px 10px rgba(0,106,255,0.3); }
.rg-step-lbl { font-size: 0.72rem; font-weight: 600; color: var(--grey-500); white-space: nowrap; }
.rg-step.active .rg-step-lbl { color: var(--blue); }
.rg-step-bar { flex: 1; height: 2px; background: var(--grey-200); border-radius: 2px; margin: 0 10px; }

.rg-alert {
  display: flex; align-items: center; gap: 9px;
  padding: 12px 16px; border-radius: 14px; margin-bottom: 22px;
  font-size: 0.83rem; font-weight: 500; animation: alertIn .3s ease;
}
.rg-alert-error { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }
@keyframes alertIn { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }

.rg-form { display: flex; flex-direction: column; gap: 16px; }
.rg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.rg-field { display: flex; flex-direction: column; gap: 6px; }
.rg-field label {
  font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--grey-700);
  display: flex; align-items: center; gap: 6px;
}
.rg-field label i { color: var(--blue); font-size: 0.68rem; }

.rg-input-box {
  display: flex; align-items: center;
  background: var(--white); border: 1.5px solid var(--grey-200);
  border-radius: 12px; overflow: hidden;
  transition: border-color var(--t), box-shadow var(--t);
  box-shadow: 0 1px 3px rgba(5,20,58,0.04);
}
.rg-input-box:focus-within { border-color: var(--blue); box-shadow: 0 0 0 4px rgba(0,106,255,0.08); }
.rg-input-box.is-err { border-color: var(--danger); background: #fff9f9; }
.rg-input-box input {
  flex: 1; border: none; outline: none; background: transparent;
  font-family: 'DM Sans', sans-serif; font-size: 0.88rem; color: var(--text);
  padding: 12px 14px;
}
.rg-input-box input::placeholder { color: var(--grey-300); }
.rg-eye {
  background: none; border: none; cursor: pointer;
  color: var(--grey-300); padding: 0 13px; font-size: 0.85rem; transition: color var(--t);
}
.rg-eye:hover { color: var(--blue); }
.rg-err-txt { font-size: 0.72rem; color: var(--danger); display: flex; align-items: center; gap: 4px; }

.rg-pw-str { display: flex; align-items: center; gap: 8px; }
.rg-pw-segs { display: flex; gap: 3px; flex: 1; }
.rg-pw-seg { height: 3px; flex: 1; border-radius: 3px; background: var(--grey-200); transition: background .3s; }
.rg-pw-lbl { font-size: 0.68rem; font-weight: 700; color: var(--grey-500); white-space: nowrap; min-width: 36px; }

.rg-match { font-size: 0.73rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }

.rg-check-label {
  display: flex; align-items: flex-start; gap: 10px;
  font-size: 0.83rem; color: var(--grey-700);
  cursor: pointer; user-select: none; line-height: 1.5;
}
.rg-check-label input { display: none; }
.rg-cm {
  width: 18px; height: 18px; min-width: 18px; border-radius: 5px;
  border: 1.5px solid var(--grey-300); background: var(--white);
  display: flex; align-items: center; justify-content: center;
  transition: var(--t); margin-top: 1px;
}
.rg-check-label input:checked + .rg-cm { background: var(--blue); border-color: var(--blue); }
.rg-check-label input:checked + .rg-cm::after { content: '✓'; color: #fff; font-size: 0.6rem; font-weight: 800; }
.rg-tl { color: var(--blue); text-decoration: none; font-weight: 600; transition: color var(--t); }
.rg-tl:hover { color: var(--blue-mid); }

.rg-btn {
  width: 100%; padding: 15px; border: none; border-radius: 999px;
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  color: var(--white); font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; font-weight: 700; letter-spacing: 0.02em;
  cursor: pointer; margin-top: 6px;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: transform var(--t), box-shadow var(--t);
  box-shadow: var(--shadow-btn); position: relative; overflow: hidden;
}
.rg-btn::before {
  content: ''; position: absolute; top: 0; left: -75%;
  width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
  transform: skewX(-15deg); transition: left 0.5s ease;
}
.rg-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,106,255,0.45); }
.rg-btn:hover::before { left: 125%; }
.rg-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

.rg-footer {
  margin-top: 22px; padding-top: 20px;
  border-top: 1px solid var(--grey-200);
  text-align: center; font-size: 0.87rem; color: var(--grey-500);
}
.rg-footer a { color: var(--blue); font-weight: 700; text-decoration: none; margin-left: 4px; transition: color var(--t); }
.rg-footer a:hover { color: var(--blue-mid); }

@media (max-width: 960px) {
  .rg-page { grid-template-columns: 1fr; }
  .rg-left { display: none; }
  .rg-right { padding: 48px 24px; min-height: 100vh; align-items: flex-start; padding-top: 56px; }
}
@media (max-width: 500px) {
  .rg-row { grid-template-columns: 1fr; }
  .rg-steps { display: none; }
}
</style>
</head>
<body>
<div class="rg-page">

  <!-- ══ LEFT PANEL ══ -->
  <div class="rg-left">
    <div class="rg-mesh"></div>
    <div class="rg-grid"></div>

    <div class="rg-nav">
      <a href="#" class="rg-brand">
        <div class="rg-brand-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="rg-brand-name">Clinic<em>Care</em></div>
      </a>
      <a href="{{ route('front.home') }}" class="rg-back"><i class="fa-solid fa-arrow-left"></i> Home</a>
    </div>

    <div class="rg-left-body">
      <div class="rg-tag"><div class="rg-tag-dot"></div> Join Today</div>
      <h2 class="rg-h">Healthcare<br/>made <em>simple</em><br/>for you.</h2>
      <p class="rg-p">Connect with certified doctors, book appointments, and manage your health — all in one place.</p>

      <div class="rg-feat-cards">
        <div class="rg-feat-card">
          <div class="rg-feat-ico rg-ico-1"><i class="fa-solid fa-user-doctor"></i></div>
          <div>
            <strong>Expert Doctors</strong>
            <span>Verified specialists across all fields</span>
          </div>
        </div>
        <div class="rg-feat-card">
          <div class="rg-feat-ico rg-ico-2"><i class="fa-solid fa-calendar-check"></i></div>
          <div>
            <strong>Easy Booking</strong>
            <span>Schedule in under 60 seconds</span>
          </div>
        </div>
        <div class="rg-feat-card">
          <div class="rg-feat-ico rg-ico-3"><i class="fa-solid fa-robot"></i></div>
          <div>
            <strong>AI Health Assistant</strong>
            <span>Instant answers, available 24/7</span>
          </div>
        </div>
      </div>
    </div>

    <div class="rg-stats">
      <div class="rg-stat">
        <div class="rg-stat-num">50<span>+</span></div>
        <div class="rg-stat-lbl">Doctors</div>
      </div>
      <div class="rg-stat">
        <div class="rg-stat-num">10<span>k+</span></div>
        <div class="rg-stat-lbl">Patients</div>
      </div>
      <div class="rg-stat">
        <div class="rg-stat-num">4.9<span>★</span></div>
        <div class="rg-stat-lbl">Rating</div>
      </div>
    </div>
  </div>

  <!-- ══ RIGHT PANEL ══ -->
  <div class="rg-right">
    <div class="rg-form-wrap">

      <div class="rg-fh">
        <h1>Create <em>account.</em></h1>
        <p>Fill in the details below to get started</p>
      </div>
      <div class="rg-line"></div>

      <div class="rg-steps">
        <div class="rg-step active">
          <div class="rg-step-dot">1</div>
          <div class="rg-step-lbl">Your Info</div>
        </div>
        <div class="rg-step-bar"></div>
        <div class="rg-step">
          <div class="rg-step-dot">2</div>
          <div class="rg-step-lbl">Verify Email</div>
        </div>
        <div class="rg-step-bar"></div>
        <div class="rg-step">
          <div class="rg-step-dot">3</div>
          <div class="rg-step-lbl">Start</div>
        </div>
      </div>

      <!-- demo alert — uncomment to test -->
      <!-- <div class="rg-alert rg-alert-error"><i class="fa-solid fa-circle-exclamation"></i> <span>Please fix the errors below.</span></div> -->
{{-- validation errors --}}

      <form action="{{ route('register') }}" method="POST" class="rg-form" id="registerForm">
        @csrf

        <div class="rg-row">
          <div class="rg-field">
            <label><i class="fa-solid fa-user"></i> Full Name</label>
            <div class="rg-input-box">
              <input type="text" name="name" placeholder="John Doe" autocomplete="name" value="{{ old('name') }}" />
                </div>
              @error('name')
                <span class="rg-err-txt"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
              @enderror
          </div>
          <div class="rg-field">
            <label><i class="fa-solid fa-phone"></i> Phone</label>
            <div class="rg-input-box">
              <input type="tel" name="phone" placeholder="+20 100 000 0000" autocomplete="tel" value="{{ old('phone') }}" class="@error('phone')
                  invalid-input
              @enderror" />
            </div>
            @error('phone')
              <span class="rg-err-txt"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="rg-field">
          <label><i class="fa-solid fa-at"></i> Email Address</label>
          <div class="rg-input-box">
            <input type="email" name="email" placeholder="john@example.com" autocomplete="email" value="{{ old('email') }}" class="@error('email')
                invalid-input
            @enderror" />
          </div>
            @error("email")
              <span class="rg-err-txt"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
            @enderror
        </div>

        <div class="rg-field">
          <label><i class="fa-solid fa-lock"></i> Password</label>
          <div class="rg-input-box">
            <input type="password" id="rgPw1" name="password" placeholder="Min. 8 characters" autocomplete="new-password"/>
            <button type="button" class="rg-eye" onclick="rgToggle('rgPw1', this)"><i class="fa-regular fa-eye"></i></button>
          </div>
          @error('password')
            <span class="rg-err-txt"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</span>
          @enderror
          <div class="rg-pw-str" id="rgPwStr" style="display:none;">
            <div class="rg-pw-segs">
              <div class="rg-pw-seg" id="rgS1"></div>
              <div class="rg-pw-seg" id="rgS2"></div>
              <div class="rg-pw-seg" id="rgS3"></div>
              <div class="rg-pw-seg" id="rgS4"></div>
            </div>
            <span class="rg-pw-lbl" id="rgPwLbl">Weak</span>
          </div>
        </div>

        <div class="rg-field">
          <label><i class="fa-solid fa-lock"></i> Confirm Password</label>
          <div class="rg-input-box">
            <input type="password" id="rgPw2" name="password_confirmation" placeholder="Repeat your password" autocomplete="new-password"/>
            <button type="button" class="rg-eye" onclick="rgToggle('rgPw2', this)"><i class="fa-regular fa-eye"></i></button>
          </div>
          <span class="rg-match" id="rgMatch" style="display:none;"></span>
        </div>


        <button type="submit" class="rg-btn" id="registerBtn">
          <span class="rg-s1"><i class="fa-solid fa-user-plus"></i> Create Account</span>
          <span class="rg-s2" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i> Creating…</span>
        </button>

      </form>

      <div class="rg-footer">
        Already have an account?
        <a href="{{ route('login') }}">Sign in <i class="fa-solid fa-arrow-right"></i></a>
      </div>

    </div>
  </div>

</div>

<script>
function rgToggle(id, btn) {
  const inp = document.getElementById(id), i = btn.querySelector('i');
  inp.type = inp.type === 'password' ? 'text' : 'password';
  i.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}

const RG_C = ['#ef4444','#f97316','#eab308','#16a34a'];
const RG_L = ['Weak','Fair','Good','Strong'];

document.getElementById('rgPw1').addEventListener('input', function () {
  const val = this.value, wrap = document.getElementById('rgPwStr');
  if (!val) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'flex';
  let sc = 0;
  if (val.length >= 8) sc++;
  if (/[A-Z]/.test(val)) sc++;
  if (/[0-9]/.test(val)) sc++;
  if (/[^A-Za-z0-9]/.test(val)) sc++;
  for (let i = 1; i <= 4; i++)
    document.getElementById('rgS' + i).style.background = i <= sc ? RG_C[sc-1] : '#eef0f6';
  const lbl = document.getElementById('rgPwLbl');
  lbl.textContent = RG_L[sc-1] || 'Weak';
  lbl.style.color  = RG_C[sc-1] || RG_C[0];
});

document.getElementById('rgPw2').addEventListener('input', function () {
  const pw1 = document.getElementById('rgPw1').value;
  const msg = document.getElementById('rgMatch');
  if (!this.value) { msg.style.display = 'none'; return; }
  msg.style.display = 'flex';
  if (this.value === pw1) {
    msg.innerHTML   = '<i class="fa-solid fa-circle-check" style="color:#16a34a"></i> Passwords match';
    msg.style.color = '#16a34a';
  } else {
    msg.innerHTML   = '<i class="fa-solid fa-circle-xmark" style="color:#dc2626"></i> Passwords do not match';
    msg.style.color = '#dc2626';
  }
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
  const btn = document.getElementById('registerBtn');
  btn.querySelector('.rg-s1').style.display = 'none';
  btn.querySelector('.rg-s2').style.display = 'flex';
  btn.disabled = true;
  setTimeout(() => {
    btn.querySelector('.rg-s1').style.display = 'flex';
    btn.querySelector('.rg-s2').style.display = 'none';
    btn.disabled = false;
  }, 2000);
});
</script>
</body>
</html>