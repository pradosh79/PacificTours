@extends('auth.layout')
@section('title', 'Create your account')

@section('form')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="row g-2">
        <div class="col-6 mb-3">
            <label class="form-label small">First name</label>
            <input name="first_name" class="form-control" value="{{ old('first_name') }}" required autofocus>
        </div>
        <div class="col-6 mb-3">
            <label class="form-label small">Last name</label>
            <input name="last_name" class="form-control" value="{{ old('last_name') }}">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label small">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email">
    </div>
    <div class="mb-3">
        <label class="form-label small">Phone</label>
        <input name="phone" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
        <label class="form-label small">Password</label>
        <input type="password" name="password" class="form-control" required autocomplete="new-password">
        <p class="form-text small">At least 10 characters, with upper and lower case and a number.</p>
    </div>
    <div class="mb-3">
        <label class="form-label small">Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="terms" value="1" id="terms" required>
        <label class="form-check-label small" for="terms">
            I accept the <a href="{{ route('pages.show', 'terms-conditions') }}" target="_blank">terms</a>
            and <a href="{{ route('pages.show', 'privacy-policy') }}" target="_blank">privacy policy</a>.
        </label>
    </div>
    <button class="btn btn-primary w-100">Create account</button>
</form>
@endsection

@section('footer-link')
    Already have an account? <a href="{{ route('login') }}">Sign in</a>
@endsection
