@extends('layouts.admin')
@section('title', 'Blog & news')
@section('actions')<a class="btn btn-sm btn-primary" href="{{ route('admin.posts.create') }}">New post</a>@endsection

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex gap-2">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Search titles" value="{{ request('keyword') }}">
            <select name="type" class="form-select form-select-sm w-auto">
                <option value="">All types</option>
                @foreach (\App\Enums\PostType::cases() as $type)
                    <option value="{{ $type->value }}" @selected(request('type') === $type->value)>{{ Str::headline($type->value) }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Any status</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>

    <table class="table align-middle mb-0">
        <thead><tr><th>Title</th><th>Type</th><th>Category</th><th>Author</th><th>Published</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($posts as $post)
            <tr>
                <td class="fw-semibold"><a href="{{ route('admin.posts.edit', $post->uuid) }}">{{ $post->title }}</a></td>
                <td>{{ Str::headline($post->type->value) }}</td>
                <td>{{ $post->category?->name ?? '—' }}</td>
                <td>{{ $post->author?->full_name ?? '—' }}</td>
                <td class="small text-muted">{{ $post->published_at?->format('d M Y') ?? '—' }}</td>
                <td><span class="badge text-bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($post->status) }}</span></td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.posts.destroy', $post->uuid) }}" onsubmit="return confirm('Delete this post?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-5">Nothing published yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $posts->withQueryString()->links() }}</div>
</div>
@endsection
