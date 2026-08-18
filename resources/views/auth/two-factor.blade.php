@extends('auth.layout')
@section('title', 'Two-factor verification')

@section('form')
<p class="small text-muted">Enter the six-digit code from your authenticator app.</p>
<form method="POST" action="{{ route('two-factor.verify') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small">Authentication code</label>
        <input name="code" class="form-control text-center" inputmode="numeric" autocomplete="one-time-code"
               maxlength="6" pattern="[0-9]{6}" required autofocus>
    </div>
    <button class="btn btn-primary w-100">Verify</button>
</form>
@endsection
