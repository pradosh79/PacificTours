@extends('layouts.admin')
@section('title', $page->exists ? 'Edit page' : 'New page')

@section('content')
<form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page->uuid) : route('admin.pages.store') }}">
    @csrf
    @if ($page->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <section class="panel">
                <div class="panel-body row g-2">
                    <div class="col-md-8"><label class="form-label small">Title</label><input name="title" class="form-control" value="{{ old('title', $page->title) }}" required></div>
                    <div class="col-md-4">
                        <label class="form-label small">Slug</label>
                        <input name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" @disabled($page->is_system)>
                        @if ($page->is_system)<p class="form-text small">System pages keep their slug — other pages link to it.</p>@endif
                    </div>
                    <div class="col-12"><label class="form-label small">Content</label><textarea name="content" rows="16" class="form-control" data-editor>{{ old('content', $page->content) }}</textarea></div>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">SEO</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-12"><label class="form-label small">Meta title</label><input name="seo[meta_title]" class="form-control" value="{{ old('seo.meta_title', $page->seo?->meta_title) }}"></div>
                    <div class="col-12"><label class="form-label small">Meta description</label><textarea name="seo[meta_description]" rows="2" class="form-control">{{ old('seo.meta_description', $page->seo?->meta_description) }}</textarea></div>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="panel">
                <div class="panel-body">
                    <label class="form-label small">Template</label>
                    <select name="template" class="form-select mb-3">
                        @foreach (['default', 'contact', 'visa', 'insurance'] as $template)
                            <option value="{{ $template }}" @selected(old('template', $page->template) === $template)>{{ Str::headline($template) }}</option>
                        @endforeach
                    </select>

                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select mb-3">
                        <option value="draft" @selected(old('status', $page->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $page->status) === 'published')>Published</option>
                    </select>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="footer" @checked(old('show_in_footer', $page->show_in_footer))>
                        <label class="form-check-label small" for="footer">Link from the footer</label>
                    </div>

                    <button class="btn btn-primary w-100">{{ $page->exists ? 'Save page' : 'Create page' }}</button>
                    @if ($page->exists)
                        <a class="btn btn-link w-100 mt-1" href="{{ route('pages.show', $page->slug) }}" target="_blank">Preview</a>
                    @endif
                </div>
            </section>
        </div>
    </div>
</form>
@endsection
