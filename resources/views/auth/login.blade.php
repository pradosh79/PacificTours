@extends('auth.layout')
@section('title', 'Sign in')

@section('form')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="email">
    </div>
    <div class="mb-3">
        <label class="form-label small">Password</label>
        <input type="password" name="password" class="form-control" required autocomplete="current-password">
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Stay signed in</label>
        </div>
        <a class="small" href="{{ route('password.request') }}">Forgot password?</a>
    </div>
    <button class="btn btn-primary w-100">Sign in</button>
</form>
@endsection

@section('footer-link')
    New here? <a href="{{ route('register') }}">Create an account</a>
@endsection
