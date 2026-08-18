@extends('layouts.admin')
@section('title', 'Support tickets')

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex flex-wrap gap-2">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Number or subject" value="{{ request('keyword') }}">
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Any status</option>
                @foreach (\App\Enums\TicketStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ Str::headline($status->value) }}</option>
                @endforeach
            </select>
            <select name="priority" class="form-select form-select-sm w-auto">
                <option value="">Any priority</option>
                @foreach (['urgent', 'high', 'medium', 'low'] as $priority)
                    <option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ ucfirst($priority) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>

    <table class="table align-middle mb-0">
        <thead><tr><th>Ticket</th><th>Customer</th><th>Subject</th><th>Department</th><th>Priority</th><th>Status</th><th>Last reply</th></tr></thead>
        <tbody>
        @forelse ($tickets as $ticket)
            <tr>
                <td><a class="fw-semibold" href="{{ route('admin.tickets.show', $ticket->uuid) }}">{{ $ticket->ticket_number }}</a></td>
                <td>{{ $ticket->user?->full_name ?? $ticket->name }}<span class="d-block small text-muted">{{ $ticket->email }}</span></td>
                <td class="text-truncate" style="max-width:16rem">{{ $ticket->subject }}</td>
                <td>{{ Str::headline($ticket->department) }}</td>
                <td>
                    <span class="badge text-bg-{{ match($ticket->priority->value) { 'urgent' => 'danger', 'high' => 'warning', 'medium' => 'info', default => 'light' } }}">
                        {{ ucfirst($ticket->priority->value) }}
                    </span>
                </td>
                <td><span class="badge text-bg-light">{{ Str::headline($ticket->status->value) }}</span></td>
                <td class="small text-muted">{{ $ticket->last_reply_at?->diffForHumans() }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-5">No tickets.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $tickets->withQueryString()->links() }}</div>
</div>
@endsection
