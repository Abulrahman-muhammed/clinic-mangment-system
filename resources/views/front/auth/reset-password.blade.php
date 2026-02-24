@extends('front.inc.master')

@section('title')
Reset Password
@endsection

@section('content')

<div class="d-flex flex-column gap-3 account-form mx-auto mt-5">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h5>Reset Password</h5>
    <p class="text-muted" style="font-size: 0.9rem;">
        Enter your new password below.
    </p>

    <form class="form" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="form-label required-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', request('email')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label required-label" for="password">New Password</label>
            <div class="position-relative">
                <input type="password" class="form-control pe-5" id="password" name="password">
                <button type="button" class="rp-eye-btn" onclick="rpToggle('password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label required-label" for="password_confirmation">Confirm Password</label>
            <div class="position-relative">
                <input type="password" class="form-control pe-5" id="password_confirmation" name="password_confirmation">
                <button type="button" class="rp-eye-btn" onclick="rpToggle('password_confirmation', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            <span class="rp-match-msg" id="matchMsg" style="display:none;"></span>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Reset Password
        </button>
    </form>

    <div class="d-flex justify-content-center gap-2 flex-column flex-lg-row flex-md-row flex-sm-column">
        <span>Remember your password?</span>
        <a class="link" href="{{ route('login') }}">Back to login</a>
    </div>

</div>

@endsection

@push('style')
<style>
.account-form {
    max-width: 420px;
    width: 100%;
    padding: 40px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 50px rgba(0,30,80,0.08);
    margin-top: 80px !important;
    margin-bottom: 80px !important;
}

.rp-eye-btn {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #94a3b8; font-size: 0.88rem; padding: 0;
    transition: color 0.2s;
}
.rp-eye-btn:hover { color: #00a8e8; }

.rp-match-msg {
    font-size: 0.78rem; font-weight: 600;
    display: flex; align-items: center; gap: 4px;
    margin-top: 5px;
}

@media (max-width: 480px) {
    .account-form { padding: 24px; margin-top: 40px !important; }
}
</style>
@endpush
@push('scripts')
<script>
function rpToggle(id, btn) {
    const inp = document.getElementById(id);
    const i   = btn.querySelector('i');
    inp.type  = inp.type === 'password' ? 'text' : 'password';
    i.className = inp.type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
}

document.getElementById('password_confirmation').addEventListener('input', function() {
    const msg   = document.getElementById('matchMsg');
    const match = this.value === document.getElementById('password').value;
    if (!this.value) { msg.style.display = 'none'; return; }
    msg.style.display = 'flex';
    msg.innerHTML = match
        ? '<i class="fa-solid fa-circle-check" style="color:#22c55e"></i> Passwords match'
        : '<i class="fa-solid fa-circle-xmark" style="color:#ef4444"></i> Passwords do not match';
    msg.style.color = match ? '#22c55e' : '#ef4444';
});
</script>
@endpush