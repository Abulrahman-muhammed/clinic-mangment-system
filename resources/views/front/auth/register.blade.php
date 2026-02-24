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
    <link rel="stylesheet" href="{{ asset('front-assets/css/register.css') }}" />
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