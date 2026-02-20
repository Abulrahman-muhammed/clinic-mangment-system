{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') — {{ config('app.name') }}</title>

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- AOS (optional animations) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

<style>
/* ============================================================
   Place file at: resources/views/front/inc/auth-styles.blade.php
============================================================ */

/* ── PAGE WRAPPER ── */
.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: #f0f4f8;
    position: relative;
    overflow: hidden;
}

/* ── BACKGROUND SHAPES ── */
.auth-bg-shape {
    position: fixed; border-radius: 50%;
    pointer-events: none; z-index: 0;
}
.auth-bg-shape-1 {
    width: 620px; height: 620px;
    background: radial-gradient(circle, rgba(0,106,255,0.08) 0%, transparent 70%);
    top: -200px; right: -150px;
}
.auth-bg-shape-2 {
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(0,168,232,0.07) 0%, transparent 70%);
    bottom: -100px; left: -100px;
}
.auth-bg-shape-3 {
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(0,106,255,0.05) 0%, transparent 70%);
    top: 50%; left: 40%;
}

/* ── CARD ── */
.auth-card {
    background: #fff;
    border-radius: 24px;
    padding: 52px 48px;
    width: 100%; max-width: 460px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 50px rgba(0,30,80,0.08);
    position: relative; z-index: 2;
}

/* ── TOP ROW ── */
.auth-top {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 36px;
}
.auth-logo {
    display: flex; align-items: center; gap: 10px; text-decoration: none;
}
.auth-logo-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #006aff, #00a8e8);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.88rem;
}
.auth-logo-name { font-size: 1rem; font-weight: 800; color: #0f172a; }
.auth-back-link {
    font-size: 0.78rem; color: #94a3b8; text-decoration: none;
    display: flex; align-items: center; gap: 5px; font-weight: 500; transition: color .2s;
}
.auth-back-link:hover { color: #006aff; }

/* ── HEADING ── */
.auth-heading { margin-bottom: 28px; }
.auth-heading h1 { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 5px; }
.auth-heading p { font-size: 0.88rem; color: #94a3b8; }

/* ── ALERT ── */
.auth-alert-error {
    display: flex; align-items: center; gap: 9px;
    background: #fef2f2; color: #dc2626;
    border: 1px solid #fecaca; border-radius: 10px;
    padding: 11px 14px; margin-bottom: 22px;
    font-size: 0.83rem; font-weight: 500;
}

/* ── FORM ── */
.auth-form { display: flex; flex-direction: column; gap: 18px; }
.auth-field { display: flex; flex-direction: column; gap: 6px; }
.auth-field label {
    font-size: 0.78rem; font-weight: 700; color: #475569;
    letter-spacing: 0.05em; text-transform: uppercase;
    display: flex; align-items: center; justify-content: space-between;
}

/* Input box */
.auth-input-box {
    position: relative; display: flex; align-items: center;
    background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px;
    transition: border-color .2s, box-shadow .2s, background .2s;
}
.auth-input-box:focus-within {
    border-color: #006aff; background: #fff;
    box-shadow: 0 0 0 4px rgba(0,106,255,0.08);
}
.auth-input-box.is-err { border-color: #f87171; background: #fff5f5; }
.auth-input-box .ai-ico {
    padding: 0 14px 0 16px; color: #cbd5e1;
    font-size: 0.85rem; flex-shrink: 0; transition: color .2s;
}
.auth-input-box:focus-within .ai-ico { color: #006aff; }
.auth-input-box input {
    flex: 1; border: none; outline: none; background: transparent;
    font-size: 0.9rem; color: #0f172a;
    padding: 13px 16px 13px 0; font-family: inherit;
}
.auth-input-box input::placeholder { color: #cbd5e1; }

/* Eye toggle */
.auth-eye {
    padding: 0 14px; background: none; border: none;
    color: #cbd5e1; cursor: pointer; font-size: 0.88rem;
    transition: color .2s; flex-shrink: 0;
}
.auth-eye:hover { color: #006aff; }

/* Error text */
.auth-err-txt {
    font-size: 0.75rem; color: #ef4444;
    display: flex; align-items: center; gap: 4px;
}

/* Forgot link */
.auth-forgot {
    font-size: 0.78rem; color: #006aff; text-decoration: none;
    font-weight: 600; text-transform: none; letter-spacing: 0; transition: color .2s;
}
.auth-forgot:hover { color: #0047cc; }

/* Password Strength */
.auth-pw-strength { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
.auth-pw-bar { flex: 1; height: 4px; background: #e8ecf0; border-radius: 4px; overflow: hidden; }
.auth-pw-fill { height: 100%; width: 0; border-radius: 4px; transition: width .3s, background .3s; }
.auth-pw-strength span { font-size: 0.75rem; font-weight: 600; color: #888; white-space: nowrap; }

/* Match message */
.auth-match-msg { font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }

/* Checkbox */
.auth-check-label {
    display: flex; align-items: flex-start; gap: 9px;
    font-size: 0.84rem; color: #64748b; cursor: pointer; user-select: none; line-height: 1.5;
}
.auth-check-label input { display: none; }
.auth-checkmark {
    width: 18px; height: 18px; min-width: 18px; border-radius: 5px;
    border: 1.5px solid #cbd5e1; background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: .2s; margin-top: 1px;
}
.auth-check-label input:checked + .auth-checkmark { background: #006aff; border-color: #006aff; }
.auth-check-label input:checked + .auth-checkmark::after {
    content: '✓'; color: #fff; font-size: 0.65rem; font-weight: 800;
}
.auth-terms-link { color: #006aff; text-decoration: none; font-weight: 600; }
.auth-terms-link:hover { text-decoration: underline; }

/* Submit Button */
.auth-submit-btn {
    width: 100%; padding: 14px; border: none; border-radius: 12px;
    background: #006aff; color: #fff;
    font-weight: 700; font-size: 0.95rem; font-family: inherit;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background .25s, transform .25s, box-shadow .25s;
    box-shadow: 0 4px 16px rgba(0,106,255,0.30); margin-top: 4px;
}
.auth-submit-btn:hover { background: #0052cc; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0,106,255,0.38); }
.auth-submit-btn:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

/* Footer */
.auth-footer {
    margin-top: 24px; padding-top: 22px;
    border-top: 1px solid #f1f5f9;
    text-align: center; font-size: 0.88rem; color: #94a3b8;
}
.auth-footer a {
    color: #006aff; font-weight: 700; text-decoration: none; margin-left: 4px; transition: color .2s;
}
.auth-footer a:hover { color: #0052cc; }

/* Responsive */
@media (max-width: 520px) {
    .auth-card { padding: 36px 22px; }
    .auth-heading h1 { font-size: 1.5rem; }
}
</style>

    @stack('style')
</head>
<body>

<div class="auth-page">

    {{-- Background Shapes --}}
    <div class="auth-bg-shape auth-bg-shape-1"></div>
    <div class="auth-bg-shape auth-bg-shape-2"></div>
    <div class="auth-bg-shape auth-bg-shape-3"></div>

    {{-- Page Content (Card) --}}
    @yield('auth-content')

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script>
<script>AOS.init({ once: true, duration: 500 });</script>

{{-- Shared password toggle helper --}}
<script>
function authTogglePw(id, btn) {
    const inp = document.getElementById(id);
    const ico = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fa-regular fa-eye-slash';
    } else {
        inp.type = 'password';
        ico.className = 'fa-regular fa-eye';
    }
}
</script>

@stack('scripts')
</body>
</html>