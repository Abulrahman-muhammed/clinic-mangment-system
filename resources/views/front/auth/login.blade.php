<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Sign In — {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,300;1,9..144,400&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --blue:       #006aff;
  --blue-mid:   #0052cc;
  --blue-dark:  #003180;
  --blue-ink:   #5c72a8;
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

.lg-page {
  min-height: 100vh;
  background: var(--grey-100);
  display: flex; align-items: center; justify-content: center;
  padding: 32px 24px;
  position: relative; overflow: hidden;
}

.lg-blob { position: fixed; border-radius: 50%; pointer-events: none; z-index: 0; }
.lg-blob-1 {
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(0,106,255,0.06) 0%, transparent 70%);
  top: -220px; right: -160px;
}
.lg-blob-2 {
  width: 400px; height: 400px;
  background: radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 70%);
  bottom: -110px; left: -90px;
}

.lg-wrap {
  position: relative; z-index: 2;
  width: 100%; max-width: 460px;
  animation: lgUp 0.7s var(--ease) both;
}
@keyframes lgUp { from { opacity:0; transform:translateY(32px); } to { opacity:1; transform:translateY(0); } }

.lg-card {
  background: var(--white);
  border: 1px solid var(--grey-200);
  border-radius: 28px;
  padding: 52px 48px;
  box-shadow: var(--shadow-card);
  position: relative; overflow: hidden;
}
.lg-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--blue), var(--gold));
}

.lg-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 36px; }
.lg-logo {
  font-family: 'Fraunces', serif;
  font-size: 1.25rem; font-weight: 700; font-style: italic;
  color: var(--blue-dark); text-decoration: none; letter-spacing: -0.3px;
  display: flex; align-items: center; gap: 10px;
}
.lg-logo span { color: var(--blue); font-style: normal; }
.lg-logo-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, var(--blue-dark), var(--blue));
  display: flex; align-items: center; justify-content: center;
  color: var(--white); font-size: 0.85rem;
  box-shadow: 0 4px 12px rgba(0,106,255,0.25);
}
.lg-home-link {
  font-size: 0.78rem; font-weight: 600; color: var(--grey-500);
  text-decoration: none; display: flex; align-items: center; gap: 6px;
  padding: 7px 16px; border: 1px solid var(--grey-200); border-radius: 999px;
  transition: var(--t);
}
.lg-home-link:hover { color: var(--blue); border-color: var(--blue); background: var(--blue-soft); }

.lg-heading h1 {
  font-family: 'Fraunces', serif;
  font-size: 2.1rem; font-weight: 700; letter-spacing: -0.6px;
  color: var(--text); line-height: 1.15; margin-bottom: 6px;
}
.lg-heading h1 em { font-style: italic; color: var(--blue); }
.lg-heading p { font-size: 0.88rem; color: var(--grey-500); font-weight: 300; }
.lg-divider {
  width: 40px; height: 2px; margin: 20px 0 28px;
  background: linear-gradient(90deg, var(--blue), var(--gold)); border-radius: 2px;
}

.lg-alert {
  display: flex; align-items: center; gap: 9px;
  padding: 12px 16px; border-radius: 14px;
  font-size: 0.83rem; font-weight: 500; margin-bottom: 22px;
  animation: lgAlert .3s ease;
}
.lg-alert-error  { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }
.lg-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: var(--success); font-weight: 600; }
@keyframes lgAlert { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }

.lg-form { display: flex; flex-direction: column; gap: 20px; }
.lg-field { display: flex; flex-direction: column; gap: 7px; }
.lg-label-row { display: flex; align-items: center; justify-content: space-between; }

.lg-field label {
  font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: 0.08em; color: var(--grey-700);
}
.lg-forgot { font-size: 0.78rem; color: var(--blue); text-decoration: none; font-weight: 600; transition: color var(--t); }
.lg-forgot:hover { color: var(--blue-mid); }

.lg-input-box {
  display: flex; align-items: center;
  background: var(--grey-100); border: 1.5px solid var(--grey-200);
  border-radius: 14px; overflow: hidden;
  transition: border-color var(--t), box-shadow var(--t), background var(--t);
}
.lg-input-box:focus-within {
  border-color: var(--blue); background: var(--white);
  box-shadow: 0 0 0 4px rgba(0,106,255,0.08);
}
.lg-input-box.is-err { border-color: var(--danger); background: #fff9f9; }
.lg-ico { padding: 0 12px 0 16px; color: var(--grey-300); font-size: 0.82rem; flex-shrink: 0; transition: color var(--t); }
.lg-input-box:focus-within .lg-ico { color: var(--blue); }
.lg-input-box input {
  flex: 1; border: none; outline: none; background: transparent;
  font-family: 'DM Sans', sans-serif; font-size: 0.9rem; color: var(--text);
  padding: 13px 14px 13px 0;
}
.lg-input-box input::placeholder { color: var(--grey-300); }
.lg-eye {
  background: none; border: none; cursor: pointer;
  color: var(--grey-300); padding: 0 14px; font-size: 0.88rem; transition: color var(--t);
}
.lg-eye:hover { color: var(--blue); }
.lg-err-txt { font-size: 0.73rem; color: var(--danger); display: flex; align-items: center; gap: 4px; }

.lg-check-label {
  display: flex; align-items: center; gap: 10px;
  font-size: 0.85rem; color: var(--grey-700); cursor: pointer; user-select: none;
}
.lg-check-label input { display: none; }
.lg-checkmark {
  width: 18px; height: 18px; border-radius: 5px;
  border: 1.5px solid var(--grey-300); background: var(--white);
  display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: var(--t);
}
.lg-check-label input:checked + .lg-checkmark { background: var(--blue); border-color: var(--blue); }
.lg-check-label input:checked + .lg-checkmark::after { content: '✓'; color: #fff; font-size: 0.62rem; font-weight: 800; }

.lg-btn {
  width: 100%; padding: 15px; border: none; border-radius: 999px;
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  color: var(--white); font-family: 'DM Sans', sans-serif;
  font-size: 0.95rem; font-weight: 700; letter-spacing: 0.02em;
  cursor: pointer; margin-top: 4px;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: transform var(--t), box-shadow var(--t);
  box-shadow: var(--shadow-btn); position: relative; overflow: hidden;
}
.lg-btn::before {
  content: ''; position: absolute; top: 0; left: -75%;
  width: 50%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
  transform: skewX(-15deg); transition: left 0.5s ease;
}
.lg-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,106,255,0.45); }
.lg-btn:hover::before { left: 125%; }
.lg-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

.lg-footer {
  margin-top: 28px; padding-top: 24px;
  border-top: 1px solid var(--grey-200);
  text-align: center; font-size: 0.88rem; color: var(--grey-500);
}
.lg-footer a { color: var(--blue); font-weight: 700; text-decoration: none; margin-left: 4px; transition: color var(--t); }
.lg-footer a:hover { color: var(--blue-mid); }

@media (max-width: 480px) {
  .lg-card { padding: 36px 24px; }
  .lg-heading h1 { font-size: 1.7rem; }
}
</style>
</head>
<body>

<div class="lg-page">
  <div class="lg-blob lg-blob-1"></div>
  <div class="lg-blob lg-blob-2"></div>

  <div class="lg-wrap">
    <div class="lg-card">

      <div class="lg-top">
        <a href="{{ route('front.home') }}" class="lg-logo">
          <div class="lg-logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
          Clinic<span>Care</span>
        </a>
        <a href="{{ route('front.home') }}" class="lg-home-link">
          <i class="fa-solid fa-arrow-left"></i> Home
        </a>
      </div>

      <div class="lg-heading">
        <h1>Welcome <em>back.</em></h1>
        <p>Enter your credentials to continue</p>
      </div>
      <div class="lg-divider"></div>

      <!-- demo error — uncomment to test -->
      <!-- <div class="lg-alert lg-alert-error"><i class="fa-solid fa-circle-exclamation"></i> Invalid email or password.</div> -->
      <!-- <div class="lg-alert lg-alert-success"><i class="fa-solid fa-circle-check"></i> Password reset successfully.</div> -->
      {{-- session status --}}
      @if (session('status'))
        <div class="lg-alert lg-alert-success">
          <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
          <div class="lg-alert-close"><i class="fa-solid fa-xmark"></i></div>
        </div>
      @endif


      <form action="{{ route('login') }}" method="POST" class="lg-form" id="lgForm">
        @csrf
        <div class="lg-field">
          <label>Email Address</label>
          <div class="lg-input-box">
            <i class="fa-solid fa-at lg-ico"></i>
            <input type="email" name="email" placeholder="you@example.com" autocomplete="email" value="{{ old('email') }}"/>
          </div>
          @error('email')
            <span class="lg-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
          @enderror
        </div>

        <div class="lg-field">
          <div class="lg-label-row">
            <label>Password</label>
            <a href="{{ route('password.request') }}" class="lg-forgot">Forgot password?</a>
          </div>
          @error('password')
            <span class="lg-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
          @enderror
          <div class="lg-input-box">
            <i class="fa-solid fa-lock lg-ico"></i>
            <input type="password" id="lgPw" name="password" placeholder="••••••••" autocomplete="current-password"/>
            <button type="button" class="lg-eye" onclick="lgToggle('lgPw', this)">
              <i class="fa-regular fa-eye"></i>
            </button>
          </div>
        </div>

        <label class="lg-check-label">
          <input type="checkbox" name="remember">
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
</div>

<script>
function lgToggle(id, btn) {
  const inp = document.getElementById(id), i = btn.querySelector('i');
  inp.type = inp.type === 'password' ? 'text' : 'password';
  i.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}
document.getElementById('lgForm').addEventListener('submit', function(e) {
  const b = document.getElementById('lgBtn');
  b.querySelector('.s1').style.display = 'none';
  b.querySelector('.s2').style.display = 'flex';
  b.disabled = true;
  setTimeout(() => {
    b.querySelector('.s1').style.display = 'flex';
    b.querySelector('.s2').style.display = 'none';
    b.disabled = false;
  }, 2000);
});
</script>
</body>
</html>