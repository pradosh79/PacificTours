@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">{{ $type === 'news' ? 'News' : 'Journal' }}</h1>

    <div class="row g-4">
        <div class="col-lg-9">
            <div class="row g-3">
                @forelse ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <article class="border rounded overflow-hidden h-100">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ upload_url($post->thumbnail) }}" alt="" class="w-100" style="height:150px;object-fit:cover" loading="lazy">
                            </a>
                            <div class="p-3">
                                <p class="small text-muted mb-1">{{ $post->published_at?->format('d M Y') }} · {{ $post->category?->name }}</p>
                                <h2 class="h6"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
                                <p class="small text-muted mb-0">{{ Str::limit($post->excerpt, 90) }}</p>
                            </div>
                        </article>
                    </div>
                @empty
                    <p class="text-muted">Nothing published yet.</p>
                @endforelse
            </div>
            <div class="mt-4">{{ $posts->links() }}</div>
        </div>

        <aside class="col-lg-3">
            <h2 class="h6">Categories</h2>
            <ul class="list-unstyled small">
                @foreach ($categories as $category)
                    <li><a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </aside>
    </div>
</div>
@endsection
