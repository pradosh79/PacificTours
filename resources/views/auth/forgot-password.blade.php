@extends('auth.layout')
@section('title', 'Reset your password')

@section('form')
<p class="small text-muted">Enter your email and we'll send a reset link.</p>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    <button class="btn btn-primary w-100">Send reset link</button>
</form>
@endsection

@section('footer-link')<a href="{{ route('login') }}">Back to sign in</a>@endsection
