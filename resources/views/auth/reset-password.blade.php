@extends('auth.layout')
@section('title', 'Choose a new password')

@section('form')
<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3">
        <label class="form-label small">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $email) }}" required readonly>
    </div>
    <div class="mb-3">
        <label class="form-label small">New password</label>
        <input type="password" name="password" class="form-control" required autofocus autocomplete="new-password">
    </div>
    <div class="mb-3">
        <label class="form-label small">Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <button class="btn btn-primary w-100">Reset password</button>
</form>
@endsection
