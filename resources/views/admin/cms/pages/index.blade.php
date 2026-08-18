@extends('layouts.admin')
@section('title', 'Pages')
@section('actions')<a class="btn btn-sm btn-primary" href="{{ route('admin.pages.create') }}">New page</a>@endsection

@section('content')
<div class="panel">
    <table class="table align-middle mb-0">
        <thead><tr><th>Title</th><th>Slug</th><th>Template</th><th>Status</th><th>Updated</th><th></th></tr></thead>
        <tbody>
        @forelse ($pages as $page)
            <tr>
                <td class="fw-semibold">
                    {{ $page->title }}
                    @if ($page->is_system)<span class="badge text-bg-light ms-1">system</span>@endif
                </td>
                <td><code>/{{ $page->slug }}</code></td>
                <td>{{ $page->template }}</td>
                <td><span class="badge text-bg-{{ $page->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($page->status) }}</span></td>
                <td class="small text-muted">{{ $page->updated_at->diffForHumans() }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.pages.edit', $page->uuid) }}">Edit</a>
                    @unless ($page->is_system)
                        <form class="d-inline" method="POST" action="{{ route('admin.pages.destroy', $page->uuid) }}"
                              onsubmit="return confirm('Delete this page?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    @endunless
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-5">No pages yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $pages->links() }}</div>
</div>
@endsection
