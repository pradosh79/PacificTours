@extends('customer.layout')
@section('heading', 'Support')

@section('panel')
<section class="border rounded p-3 mb-3">
    <h2 class="h6">Open a ticket</h2>
    <form method="POST" action="{{ route('customer.tickets.store') }}" enctype="multipart/form-data" class="row g-2">
        @csrf
        <div class="col-md-6"><label class="form-label small">Subject</label><input name="subject" class="form-control form-control-sm" required></div>
        <div class="col-md-3">
            <label class="form-label small">Department</label>
            <select name="department" class="form-select form-select-sm">
                @foreach (['general' => 'General', 'booking' => 'Booking', 'payment' => 'Payment', 'visa' => 'Visa'] as $v => $l)
                    <option value="{{ $v }}">{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">Priority</label>
            <select name="priority" class="form-select form-select-sm">
                @foreach (['low', 'medium', 'high', 'urgent'] as $p)
                    <option value="{{ $p }}" @selected($p === 'medium')>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12"><label class="form-label small">Message</label><textarea name="message" rows="4" class="form-control form-control-sm" required></textarea></div>
        <div class="col-12"><label class="form-label small">Attachments (max 3)</label><input type="file" name="attachments[]" multiple class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.pdf"></div>
        <div class="col-12"><button class="btn btn-sm btn-primary mt-2">Open ticket</button></div>
    </form>
</section>

<table class="table table-sm align-middle">
    <thead><tr><th>Ticket</th><th>Subject</th><th>Status</th><th>Last reply</th></tr></thead>
    <tbody>
    @forelse ($tickets as $ticket)
        <tr>
            <td><a href="{{ route('customer.tickets.show', $ticket->uuid) }}">{{ $ticket->ticket_number }}</a></td>
            <td>{{ $ticket->subject }}</td>
            <td><span class="badge text-bg-secondary">{{ Str::headline($ticket->status->value) }}</span></td>
            <td class="small text-muted">{{ $ticket->last_reply_at?->diffForHumans() }}</td>
        </tr>
    @empty
        <tr><td colspan="4" class="text-muted text-center py-4">No tickets yet.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $tickets->links() }}
@endsection
