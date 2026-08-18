@extends('layouts.admin')
@section('title', 'Contact inbox')

@section('content')
<div class="panel">
    <header class="panel-head d-flex justify-content-between align-items-center">
        <form class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">All</option>
                @foreach (['new' => 'New', 'read' => 'Read', 'replied' => 'Replied'] as $v => $l)
                    <option value="{{ $v }}" @selected(request('status') === $v)>{{ $l }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
        <span class="small text-muted">{{ $unread }} unread</span>
    </header>

    <table class="table align-middle mb-0">
        <thead><tr><th>From</th><th>Subject</th><th>Received</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($messages as $message)
            <tr class="{{ $message->status === 'new' ? 'fw-semibold' : '' }}">
                <td>{{ $message->name }}<span class="d-block small text-muted fw-normal">{{ $message->email }}</span></td>
                <td>{{ $message->subject }}</td>
                <td class="small text-muted">{{ $message->created_at->diffForHumans() }}</td>
                <td><span class="badge text-bg-light">{{ ucfirst($message->status) }}</span></td>
                <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.messages.show', $message->id) }}">Open</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-5">Inbox is empty.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $messages->withQueryString()->links() }}</div>
</div>
@endsection
