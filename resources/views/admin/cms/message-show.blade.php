@extends('layouts.admin')
@section('title', $message->subject)

@section('content')
<div class="panel mb-3">
    <div class="panel-body">
        <p class="small text-muted">
            From <strong>{{ $message->name }}</strong> &lt;{{ $message->email }}&gt;
            @if ($message->phone) · {{ $message->phone }} @endif
            · {{ $message->created_at->format('d M Y H:i') }}
        </p>
        <p class="mb-0">{{ $message->message }}</p>
    </div>
</div>

@if ($message->reply)
    <div class="panel mb-3">
        <header class="panel-head"><h2 class="h6 mb-0">Our reply</h2></header>
        <div class="panel-body">
            <p class="small text-muted">{{ $message->replied_at?->format('d M Y H:i') }}</p>
            <p class="mb-0">{{ $message->reply }}</p>
        </div>
    </div>
@endif

<div class="panel">
    <header class="panel-head"><h2 class="h6 mb-0">Reply by email</h2></header>
    <form class="panel-body" method="POST" action="{{ route('admin.messages.reply', $message->id) }}">
        @csrf
        <textarea name="reply" rows="6" class="form-control mb-2" required>{{ $message->reply }}</textarea>
        <button class="btn btn-sm btn-primary">Send reply</button>
    </form>
</div>
@endsection
