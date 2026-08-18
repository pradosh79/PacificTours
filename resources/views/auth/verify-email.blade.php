@extends('auth.layout')
@section('title', 'Verify your email')

@section('form')
<p class="small text-muted">
    We sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
    Click it to finish setting up your account.
</p>
<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button class="btn btn-primary w-100">Resend the link</button>
</form>
<form method="POST" action="{{ route('logout') }}" class="mt-2">
    @csrf
    <button class="btn btn-link w-100 small">Sign out</button>
</form>
@endsection
