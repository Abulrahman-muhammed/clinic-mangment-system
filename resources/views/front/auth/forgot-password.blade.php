@extends('front.inc.master')

@section('title')
Forgot Password
@endsection

@section('content')

<div class="d-flex flex-column gap-3 account-form mx-auto mt-5">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h5>Forgot Password</h5>
    <p class="text-muted" style="font-size: 0.9rem;">
        Enter your email address and we'll send you a link to reset your password.
    </p>

    <form class="form" action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label required-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Send Reset Link
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
}

@media (max-width: 480px) {
    .account-form {
        padding: 24px;
        margin-top: 40px !important;
    }
}
</style>
@endpush