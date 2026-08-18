@extends('layouts.admin')
@section('title', 'Newsletter subscribers')
@section('actions')<a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.subscribers.export') }}">Export CSV</a>@endsection

@section('content')
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><article class="stat-card"><p class="stat-value">{{ number_format($stats['total']) }}</p><p class="stat-label">Total</p></article></div>
    <div class="col-6 col-md-3"><article class="stat-card"><p class="stat-value">{{ number_format($stats['active']) }}</p><p class="stat-label">Active</p></article></div>
</div>

<div class="panel">
    <header class="panel-head">
        <form class="d-flex gap-2">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Search email" value="{{ request('keyword') }}">
            <div class="form-check align-self-center">
                <input class="form-check-input" type="checkbox" name="active_only" value="1" id="ao" @checked(request('active_only'))>
                <label class="form-check-label small" for="ao">Active only</label>
            </div>
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>
    <table class="table table-sm align-middle mb-0">
        <thead><tr><th>Email</th><th>Name</th><th>Subscribed</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($subscribers as $subscriber)
            <tr>
                <td>{{ $subscriber->email }}</td>
                <td>{{ $subscriber->name ?: '—' }}</td>
                <td class="small text-muted">{{ $subscriber->created_at->format('d M Y') }}</td>
                <td>{!! $subscriber->unsubscribed_at ? '<span class="badge text-bg-secondary">Unsubscribed</span>' : '<span class="badge text-bg-success">Active</span>' !!}</td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" onsubmit="return confirm('Remove this subscriber?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-5">No subscribers yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $subscribers->withQueryString()->links() }}</div>
</div>
@endsection
