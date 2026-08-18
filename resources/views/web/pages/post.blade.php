@extends('layouts.app')
@section('content')
<article class="container py-5" style="max-width:760px">
    <p class="small text-muted">{{ $post->published_at?->format('d F Y') }} · {{ $post->category?->name }}</p>
    <h1 class="h3">{{ $post->title }}</h1>
    @if ($post->thumbnail)
        <img src="{{ upload_url($post->thumbnail) }}" alt="" class="w-100 rounded my-4">
    @endif
    <div>{!! $post->content !!}</div>

    @if ($related->isNotEmpty())
        <section class="mt-5">
            <h2 class="h5">Keep reading</h2>
            <ul class="list-unstyled">
                @foreach ($related as $item)
                    <li class="py-1"><a href="{{ route('blog.show', $item->slug) }}">{{ $item->title }}</a></li>
                @endforeach
            </ul>
        </section>
    @endif
</article>
@endsection
