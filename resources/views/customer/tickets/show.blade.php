@extends('customer.layout')
@section('heading', $ticket->ticket_number.' · '.$ticket->subject)

@section('panel')
<p class="small text-muted">
    {{ Str::headline($ticket->department) }} · {{ Str::headline($ticket->priority->value) }} priority ·
    <span class="badge text-bg-secondary">{{ Str::headline($ticket->status->value) }}</span>
</p>

@foreach ($ticket->messages as $message)
    <article class="border rounded p-3 mb-2 {{ $message->user_id === auth()->id() ? '' : 'bg-light' }}">
        <p class="small text-muted mb-1">
            {{ $message->user_id === auth()->id() ? 'You' : setting('general.company_name') }}
            · {{ $message->created_at->format('d M Y H:i') }}
        </p>
        <p class="mb-0">{{ $message->message }}</p>
        @foreach ($message->attachments as $attachment)
            <p class="small mb-0 mt-2">📎 {{ $attachment->original_name }}</p>
        @endforeach
    </article>
@endforeach

@if ($ticket->status !== \App\Enums\TicketStatus::Closed)
    <form method="POST" action="{{ route('customer.tickets.reply', $ticket->uuid) }}" class="mt-3">
        @csrf
        <textarea name="message" rows="4" class="form-control" required placeholder="Add a reply"></textarea>
        <button class="btn btn-sm btn-primary mt-2">Send reply</button>
    </form>
@else
    <p class="small text-muted mt-3">This ticket is closed. Open a new one if you need anything else.</p>
@endif
@endsection
