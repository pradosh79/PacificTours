@extends('layouts.admin')
@section('title', 'Notifications')

@section('actions')
    <form method="POST" action="{{ route('admin.notifications.read-all') }}">@csrf
        <button class="btn btn-sm btn-outline-secondary">Mark all read</button>
    </form>
@endsection

@section('content')
<div class="panel">
    <ul class="list-unstyled mb-0">
        @forelse ($notifications as $notification)
            <li class="border-bottom p-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                <div class="d-flex justify-content-between gap-3">
                    <div>
                        <a class="fw-semibold" href="{{ $notification->data['url'] ?? '#' }}">{{ $notification->data['title'] ?? 'Notification' }}</a>
                        <span class="d-block small text-muted">{{ $notification->data['message'] ?? '' }}</span>
                    </div>
                    <span class="small text-muted text-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </li>
        @empty
            <li class="p-5 text-center text-muted">Nothing here yet.</li>
        @endforelse
    </ul>
    <div class="panel-foot">{{ $notifications->links() }}</div>
</div>
@endsection
