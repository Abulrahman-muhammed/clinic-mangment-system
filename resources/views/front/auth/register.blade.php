@extends('front.inc.master')
@section('title', 'Register')
@section('content')

<div class="auth-page-wrapper">

    <!-- LEFT PANEL -->
    <div class="auth-left-panel">
        <div class="auth-left-inner">
            <div class="auth-brand" data-aos="fade-down">
                <div class="auth-brand-icon">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <span>{{ config('app.name') }}</span>
            </div>

            <div class="auth-left-text" data-aos="fade-up" data-aos-delay="100">
                <h2>Join Our Health Community</h2>
                <p>Create your account in seconds and get instant access to world-class healthcare services, expert doctors, and smart health tools.</p>
            </div>

            <div class="auth-steps" data-aos="fade-up" data-aos-delay="200">
                <div class="auth-step-item">
                    <div class="auth-step-num">1</div>
                    <div>
                        <strong>Create your account</strong>
                        <span>Fill in your basic details below</span>
                    </div>
                </div>
                <div class="auth-step-connector"></div>
                <div class="auth-step-item">
                    <div class="auth-step-num">2</div>
                    <div>
                        <strong>Verify your email</strong>
                        <span>Check your inbox for confirmation</span>
                    </div>
                </div>
                <div class="auth-step-connector"></div>
                <div class="auth-step-item">
                    <div class="auth-step-num">3</div>
                    <div>
                        <strong>Start your journey</strong>
                        <span>Book appointments & more</span>
                    </div>
                </div>
            </div>

            <div class="auth-left-decoration">
                <div class="auth-deco-circle auth-deco-1"></div>
                <div class="auth-deco-circle auth-deco-2"></div>
                <div class="auth-deco-circle auth-deco-3"></div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right-panel">
        <div class="auth-form-card" data-aos="fade-left">

            <div class="auth-form-header">
                <h1>Create Account</h1>
                <p>Fill in the details below to get started</p>
            </div>

            @if($errors->any())
                <div class="auth-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="auth-form-group">
                    <label for="name">
                        <i class="fa-solid fa-user"></i> Full Name
                    </label>
                    <div class="auth-input-wrap">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="John Doe"
                            value="{{ old('name') }}"
                            class="{{ $errors->has('name') ? 'auth-input-error' : '' }}"
                            autocomplete="name"
                        />
                    </div>
                    @error('name')
                        <span class="auth-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="auth-form-group">
                    <label for="email">
                        <i class="fa-solid fa-envelope"></i> Email Address
                    </label>
                    <div class="auth-input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="john@example.com"
                            value="{{ old('email') }}"
                            class="{{ $errors->has('email') ? 'auth-input-error' : '' }}"
                            autocomplete="email"
                        />
                    </div>
                    @error('email')
                        <span class="auth-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="auth-form-group">
                    <label for="phone">
                        <i class="fa-solid fa-phone"></i> Phone Number
                    </label>
                    <div class="auth-input-wrap">
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="+20 100 000 0000"
                            value="{{ old('phone') }}"
                            class="{{ $errors->has('phone') ? 'auth-input-error' : '' }}"
                            autocomplete="tel"
                        />
                    </div>
                    @error('phone')
                        <span class="auth-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="auth-form-group">
                    <label for="password">
                        <i class="fa-solid fa-lock"></i> Password
                    </label>
                    <div class="auth-input-wrap auth-password-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Min. 8 characters"
                            class="{{ $errors->has('password') ? 'auth-input-error' : '' }}"
                            autocomplete="new-password"
                        />
                        <button type="button" class="auth-toggle-pw" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <!-- Password Strength -->
                    <div class="auth-pw-strength" id="pwStrength" style="display:none;">
                        <div class="auth-pw-bar">
                            <div class="auth-pw-fill" id="pwFill"></div>
                        </div>
                        <span id="pwLabel">Weak</span>
                    </div>
                    @error('password')
                        <span class="auth-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="auth-form-group">
                    <label for="password_confirmation">
                        <i class="fa-solid fa-lock"></i> Confirm Password
                    </label>
                    <div class="auth-input-wrap auth-password-wrap">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repeat your password"
                            autocomplete="new-password"
                        />
                        <button type="button" class="auth-toggle-pw" onclick="togglePassword('password_confirmation', this)">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <span class="auth-match-msg" id="matchMsg" style="display:none;"></span>
                </div>

                <!-- Terms -->
                <div class="auth-terms-row">
                    <label class="auth-checkbox-label">
                        <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
                        <span class="auth-checkmark"></span>
                        I agree to the <a href="#" class="auth-terms-link">Terms of Service</a> and <a href="#" class="auth-terms-link">Privacy Policy</a>
                    </label>
                    @error('terms')
                        <span class="auth-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="auth-submit-btn" id="registerBtn">
                    <span class="auth-btn-text">
                        <i class="fa-solid fa-user-plus"></i> Create Account
                    </span>
                    <span class="auth-btn-loading" style="display:none;">
                        <i class="fa-solid fa-spinner fa-spin"></i> Creating...
                    </span>
                </button>

            </form>

            <div class="auth-divider"><span>or</span></div>

            <div class="auth-switch-link">
                Already have an account?
                <a href="{{ route('login') }}">Sign in <i class="fa-solid fa-arrow-right"></i></a>
            </div>

        </div>
    </div>

</div>

@endsection

@push('style')
<style>
/* ===================== LAYOUT ===================== */
.auth-page-wrapper {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
}

/* ===================== LEFT PANEL ===================== */
.auth-left-panel {
    background: linear-gradient(145deg, #003d6b 0%, #005f99 40%, #00a8e8 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
}
.auth-left-inner {
    position: relative;
    z-index: 2;
    color: #fff;
    max-width: 420px;
}
.auth-brand {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 50px;
}
.auth-brand-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
}
.auth-brand span { font-size: 1.4rem; font-weight: 800; letter-spacing: 0.5px; }
.auth-left-text { margin-bottom: 44px; }
.auth-left-text h2 { font-size: 2.2rem; font-weight: 900; line-height: 1.18; margin-bottom: 14px; }
.auth-left-text p { font-size: 0.93rem; opacity: 0.82; line-height: 1.8; }

/* Steps */
.auth-steps { display: flex; flex-direction: column; }
.auth-step-item { display: flex; align-items: center; gap: 16px; }
.auth-step-num {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; font-weight: 800; flex-shrink: 0;
}
.auth-step-item div { display: flex; flex-direction: column; }
.auth-step-item strong { font-size: 0.92rem; font-weight: 700; }
.auth-step-item span { font-size: 0.78rem; opacity: 0.7; margin-top: 1px; }
.auth-step-connector {
    width: 2px; height: 22px; background: rgba(255,255,255,0.2);
    margin: 5px 0 5px 17px;
}

/* Decorative Circles */
.auth-deco-circle {
    position: absolute; border-radius: 50%;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.07);
}
.auth-deco-1 { width: 340px; height: 340px; bottom: -90px; right: -90px; }
.auth-deco-2 { width: 200px; height: 200px; top: 30px; right: 20px; }
.auth-deco-3 { width: 110px; height: 110px; top: 220px; left: -35px; }

/* ===================== RIGHT PANEL ===================== */
.auth-right-panel {
    background: #f8f9fa;
    display: flex; align-items: center; justify-content: center;
    padding: 50px 50px;
    overflow-y: auto;
}
.auth-form-card { width: 100%; max-width: 460px; }
.auth-form-header { margin-bottom: 28px; }
.auth-form-header h1 { font-size: 2rem; font-weight: 900; color: #1a1a2e; margin-bottom: 6px; }
.auth-form-header p { color: #777; font-size: 0.92rem; }

/* Alerts */
.auth-alert-error {
    display: flex; align-items: center; gap: 10px;
    background: #fef2f2; color: #991b1b;
    border: 1px solid #fca5a5;
    border-radius: 10px; padding: 13px 16px;
    margin-bottom: 20px; font-size: 0.88rem; font-weight: 500;
}
.auth-alert-error i { font-size: 1rem; flex-shrink: 0; }

/* Form */
.auth-form { display: flex; flex-direction: column; gap: 16px; }
.auth-form-group { display: flex; flex-direction: column; gap: 7px; }
.auth-form-group label {
    font-size: 0.84rem; font-weight: 600; color: #333;
    display: flex; align-items: center; gap: 6px;
}
.auth-form-group label i { color: #00a8e8; font-size: 0.78rem; }

.auth-input-wrap { position: relative; }
.auth-input-wrap input {
    width: 100%;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    padding: 12px 16px; font-size: 0.9rem; color: #333;
    background: #fff; outline: none;
    transition: border-color 0.25s, box-shadow 0.25s;
    font-family: inherit;
}
.auth-password-wrap input { padding-right: 48px; }
.auth-input-wrap input:focus {
    border-color: #00a8e8;
    box-shadow: 0 0 0 4px rgba(0,168,232,0.1);
}
.auth-input-wrap input::placeholder { color: #b0b8c1; }
.auth-input-error { border-color: #ef4444 !important; background: #fff5f5 !important; }
.auth-error-msg {
    color: #ef4444; font-size: 0.78rem;
    display: flex; align-items: center; gap: 4px;
}

/* Password Toggle */
.auth-toggle-pw {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #999; font-size: 0.9rem; padding: 0; transition: color 0.2s;
}
.auth-toggle-pw:hover { color: #00a8e8; }

/* Password Strength */
.auth-pw-strength { display: flex; align-items: center; gap: 10px; margin-top: 2px; }
.auth-pw-bar { flex: 1; height: 4px; background: #e8ecf0; border-radius: 4px; overflow: hidden; }
.auth-pw-fill { height: 100%; width: 0; border-radius: 4px; transition: width 0.3s, background 0.3s; }
.auth-pw-strength span { font-size: 0.75rem; font-weight: 600; color: #888; white-space: nowrap; }

/* Match Message */
.auth-match-msg { font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }

/* Checkbox */
.auth-terms-row { margin-top: -2px; }
.auth-checkbox-label {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 0.84rem; color: #555; cursor: pointer; user-select: none;
    line-height: 1.5;
}
.auth-checkbox-label input[type="checkbox"] { display: none; }
.auth-checkmark {
    width: 18px; height: 18px; min-width: 18px; border-radius: 5px;
    border: 1.5px solid #cdd5e0; background: #fff;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; margin-top: 1px;
}
.auth-checkbox-label input:checked + .auth-checkmark {
    background: #00a8e8; border-color: #00a8e8;
}
.auth-checkbox-label input:checked + .auth-checkmark::after {
    content: '✓'; color: #fff; font-size: 0.7rem; font-weight: 700; line-height: 1;
}
.auth-terms-link { color: #00a8e8; text-decoration: none; font-weight: 600; }
.auth-terms-link:hover { text-decoration: underline; }

/* Submit Button */
.auth-submit-btn {
    background: linear-gradient(135deg, #00a8e8, #0077b6);
    color: #fff; border: none; border-radius: 50px;
    padding: 14px; font-size: 1rem; font-weight: 700;
    cursor: pointer; width: 100%; margin-top: 4px;
    transition: transform 0.25s, box-shadow 0.25s;
    box-shadow: 0 6px 20px rgba(0,120,182,0.35);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.auth-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,120,182,0.45); }
.auth-submit-btn:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

/* Divider */
.auth-divider {
    display: flex; align-items: center; gap: 14px;
    margin: 22px 0; color: #bbb; font-size: 0.82rem;
}
.auth-divider::before,
.auth-divider::after { content: ''; flex: 1; height: 1px; background: #e8ecf0; }

/* Switch Link */
.auth-switch-link { text-align: center; font-size: 0.9rem; color: #666; }
.auth-switch-link a {
    color: #00a8e8; font-weight: 700; text-decoration: none;
    margin-left: 4px; transition: color 0.2s;
}
.auth-switch-link a:hover { color: #0077b6; }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 900px) {
    .auth-page-wrapper { grid-template-columns: 1fr; }
    .auth-left-panel { display: none; }
    .auth-right-panel { padding: 50px 24px; min-height: 100vh; }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-regular fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-regular fa-eye';
    }
}

// Password Strength
document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const bar  = document.getElementById('pwFill');
    const lbl  = document.getElementById('pwLabel');
    const wrap = document.getElementById('pwStrength');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'flex';

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { w: '25%',  bg: '#ef4444', txt: 'Weak',   color: '#ef4444' },
        { w: '50%',  bg: '#f97316', txt: 'Fair',   color: '#f97316' },
        { w: '75%',  bg: '#eab308', txt: 'Good',   color: '#eab308' },
        { w: '100%', bg: '#22c55e', txt: 'Strong', color: '#22c55e' },
    ];
    const lvl = levels[score - 1] || levels[0];
    bar.style.width = lvl.w;
    bar.style.background = lvl.bg;
    lbl.textContent = lvl.txt;
    lbl.style.color = lvl.color;
});

// Confirm Password Match
document.getElementById('password_confirmation').addEventListener('input', function() {
    const pw  = document.getElementById('password').value;
    const msg = document.getElementById('matchMsg');
    if (!this.value) { msg.style.display = 'none'; return; }
    msg.style.display = 'flex';
    if (this.value === pw) {
        msg.innerHTML = '<i class="fa-solid fa-circle-check" style="color:#22c55e"></i> Passwords match';
        msg.style.color = '#22c55e';
    } else {
        msg.innerHTML = '<i class="fa-solid fa-circle-xmark" style="color:#ef4444"></i> Passwords do not match';
        msg.style.color = '#ef4444';
    }
});

// Submit Spinner
document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('registerBtn');
    btn.querySelector('.auth-btn-text').style.display = 'none';
    btn.querySelector('.auth-btn-loading').style.display = 'flex';
    btn.disabled = true;
});
</script>
@endpush