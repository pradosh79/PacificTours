@extends('layouts.admin')
@section('title', $ticket->ticket_number.' · '.$ticket->subject)

@section('actions')
    @if ($ticket->status !== \App\Enums\TicketStatus::Closed)
        <form method="POST" action="{{ route('admin.tickets.close', $ticket->uuid) }}">@csrf @method('PATCH')
            <button class="btn btn-sm btn-outline-secondary">Close ticket</button>
        </form>
    @endif
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        @foreach ($ticket->messages as $message)
            <article class="panel mb-2 {{ $message->is_staff ? 'border-primary' : '' }}">
                <div class="panel-body">
                    <p class="small text-muted mb-1">
                        {{ $message->is_staff ? ($message->user?->full_name.' (staff)') : $ticket->user?->full_name }}
                        · {{ $message->created_at->format('d M Y H:i') }}
                    </p>
                    <p class="mb-0">{{ $message->message }}</p>
                    @foreach ($message->attachments as $attachment)
                        <p class="small mb-0 mt-2">📎 {{ $attachment->original_name }} ({{ round($attachment->size / 1024) }} KB)</p>
                    @endforeach
                </div>
            </article>
        @endforeach

        @if ($ticket->status !== \App\Enums\TicketStatus::Closed)
            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Reply</h2></header>
                <form class="panel-body" method="POST" action="{{ route('admin.tickets.reply', $ticket->uuid) }}" enctype="multipart/form-data">
                    @csrf
                    <textarea name="message" rows="5" class="form-control mb-2" required></textarea>
                    <input type="file" name="attachments[]" multiple class="form-control form-control-sm mb-2" accept=".jpg,.jpeg,.png,.pdf">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="close" value="1" id="close">
                        <label class="form-check-label small" for="close">Close the ticket after sending</label>
                    </div>
                    <button class="btn btn-sm btn-primary">Send reply</button>
                </form>
            </section>
        @endif
    </div>

    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Ticket</h2></header>
            <dl class="panel-body row small mb-0">
                <dt class="col-5">Status</dt><dd class="col-7">{{ Str::headline($ticket->status->value) }}</dd>
                <dt class="col-5">Priority</dt><dd class="col-7">{{ ucfirst($ticket->priority->value) }}</dd>
                <dt class="col-5">Department</dt><dd class="col-7">{{ Str::headline($ticket->department) }}</dd>
                <dt class="col-5">Opened</dt><dd class="col-7">{{ $ticket->created_at->format('d M Y') }}</dd>
                @if ($ticket->booking)
                    <dt class="col-5">Booking</dt>
                    <dd class="col-7"><a href="{{ route('admin.bookings.show', $ticket->booking->uuid) }}">{{ $ticket->booking->booking_number }}</a></dd>
                @endif
            </dl>
        </section>

        @if ($ticket->user)
            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Customer</h2></header>
                <dl class="panel-body row small mb-0">
                    <dt class="col-5">Name</dt><dd class="col-7"><a href="{{ route('admin.users.show', $ticket->user->uuid) }}">{{ $ticket->user->full_name }}</a></dd>
                    <dt class="col-5">Email</dt><dd class="col-7">{{ $ticket->user->email }}</dd>
                    <dt class="col-5">Phone</dt><dd class="col-7">{{ $ticket->user->phone ?: '—' }}</dd>
                </dl>
            </section>
        @endif
    </div>
</div>
@endsection
