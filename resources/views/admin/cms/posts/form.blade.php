@extends('layouts.admin')
@section('title', $post->exists ? 'Edit post' : 'New post')

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $post->exists ? route('admin.posts.update', $post->uuid) : route('admin.posts.store') }}">
    @csrf
    @if ($post->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <section class="panel">
                <div class="panel-body row g-2">
                    <div class="col-md-8"><label class="form-label small">Title</label><input name="title" class="form-control" value="{{ old('title', $post->title) }}" required></div>
                    <div class="col-md-4"><label class="form-label small">Slug</label><input name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" placeholder="auto"></div>
                    <div class="col-12"><label class="form-label small">Excerpt</label><textarea name="excerpt" rows="2" class="form-control" maxlength="500">{{ old('excerpt', $post->excerpt) }}</textarea></div>
                    <div class="col-12"><label class="form-label small">Content</label><textarea name="content" rows="18" class="form-control" data-editor required>{{ old('content', $post->content) }}</textarea></div>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">SEO</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-12"><label class="form-label small">Meta title</label><input name="seo[meta_title]" class="form-control" value="{{ old('seo.meta_title', $post->seo?->meta_title) }}"></div>
                    <div class="col-12"><label class="form-label small">Meta description</label><textarea name="seo[meta_description]" rows="2" class="form-control">{{ old('seo.meta_description', $post->seo?->meta_description) }}</textarea></div>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="panel">
                <div class="panel-body">
                    <label class="form-label small">Type</label>
                    <select name="type" class="form-select mb-3">
                        @foreach (\App\Enums\PostType::cases() as $type)
                            <option value="{{ $type->value }}" @selected(old('type', $post->type?->value) === $type->value)>{{ Str::headline($type->value) }}</option>
                        @endforeach
                    </select>

                    <label class="form-label small">Category</label>
                    <select name="post_category_id" class="form-select mb-3">
                        <option value="">—</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label class="form-label small">Tags</label>
                    <select name="tags[]" class="form-select mb-3" multiple size="5">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @selected($post->exists && $post->tags->contains($tag))>{{ $tag->name }}</option>
                        @endforeach
                    </select>

                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select mb-3">
                        <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                    </select>

                    <label class="form-label small">Publish date</label>
                    <input type="datetime-local" name="published_at" class="form-control mb-3"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                    <p class="form-text small">Leave blank and publishing uses the current time.</p>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="feat" @checked(old('is_featured', $post->is_featured))>
                        <label class="form-check-label small" for="feat">Featured</label>
                    </div>

                    <button class="btn btn-primary w-100">{{ $post->exists ? 'Save post' : 'Create post' }}</button>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Cover image</h2></header>
                <div class="panel-body">
                    <input type="file" name="thumbnail" accept="image/*" class="form-control mb-2">
                    @if ($post->thumbnail)<img src="{{ upload_url($post->thumbnail) }}" alt="" class="img-fluid rounded">@endif
                </div>
            </section>
        </div>
    </div>
</form>
@endsection
