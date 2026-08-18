@extends('layouts.admin')
@section('title', 'Reviews')

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex gap-2">
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">All statuses</option>
                @foreach (\App\Enums\ReviewStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ Str::headline($status->value) }}</option>
                @endforeach
            </select>
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Search text" value="{{ request('keyword') }}">
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>

    <ul class="list-unstyled mb-0">
        @forelse ($reviews as $review)
            <li class="border-bottom p-3">
                <div class="d-flex justify-content-between gap-3 flex-wrap">
                    <div>
                        <p class="mb-1">
                            <strong>{{ $review->reviewer_name }}</strong>
                            · {{ $review->rating }}/5
                            @if ($review->is_verified_purchase)<span class="badge text-bg-success">Verified</span>@endif
                            <span class="badge text-bg-light">{{ Str::headline($review->status->value) }}</span>
                        </p>
                        <p class="small text-muted mb-1">
                            {{ $review->tour?->title }} · {{ $review->created_at->format('d M Y') }}
                        </p>
                        <p class="mb-1">{{ $review->comment }}</p>
                        @if ($review->admin_reply)
                            <p class="small text-muted mb-0">↳ Our reply: {{ $review->admin_reply }}</p>
                        @endif
                    </div>

                    <div class="d-flex gap-1 align-items-start">
                        @if ($review->status !== \App\Enums\ReviewStatus::Approved)
                            <form method="POST" action="{{ route('admin.reviews.approve', $review->uuid) }}">@csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>
                        @endif
                        @if ($review->status !== \App\Enums\ReviewStatus::Rejected)
                            <form method="POST" action="{{ route('admin.reviews.reject', $review->uuid) }}">@csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-secondary">Reject</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review->uuid) }}" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>

                <form class="d-flex gap-2 mt-2" method="POST" action="{{ route('admin.reviews.reply', $review->uuid) }}">
                    @csrf
                    <input name="admin_reply" class="form-control form-control-sm" placeholder="Public reply" value="{{ $review->admin_reply }}">
                    <button class="btn btn-sm btn-outline-secondary">Reply</button>
                </form>
            </li>
        @empty
            <li class="p-5 text-center text-muted">No reviews to moderate.</li>
        @endforelse
    </ul>
    <div class="panel-foot">{{ $reviews->withQueryString()->links() }}</div>
</div>
@endsection
