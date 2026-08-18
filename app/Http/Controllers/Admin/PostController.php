<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function __construct(private readonly MediaService $media)
    {
        $this->middleware('permission:cms.view')->only(['index', 'create', 'edit']);
        $this->middleware('permission:cms.create')->only('store');
        $this->middleware('permission:cms.update')->only('update');
        $this->middleware('permission:cms.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        return view('admin.cms.posts.index', [
            'posts' => Post::with(['category:id,name', 'author:id,first_name,last_name'])
                ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
                ->when($request->filled('keyword'), fn ($q) => $q->where('title', 'like', "%{$request->keyword}%"))
                ->latest('id')->paginate(20)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.cms.posts.form', $this->formData(new Post));
    }

    public function edit(Post $post)
    {
        return view('admin.cms.posts.form', $this->formData($post->load(['tags', 'seo'])));
    }

    public function store(Request $request)
    {
        $post = Post::create($this->validated($request));
        $this->afterSave($post, $request);

        return redirect()->route('admin.posts.edit', $post->uuid)->with('success', 'Post created.');
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->validated($request, $post));
        $this->afterSave($post, $request);

        return back()->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    private function formData(Post $post): array
    {
        return [
            'post'       => $post,
            'categories' => PostCategory::where('is_active', true)->orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:220'],
            'slug'             => ['nullable', 'string', Rule::unique('posts', 'slug')->ignore($post?->id)],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'type'             => ['required', Rule::enum(PostType::class)],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['required', 'string'],
            'thumbnail'        => ['nullable', 'image', 'max:4096'],
            'status'           => ['required', 'in:draft,published'],
            'published_at'     => ['nullable', 'date'],
            'is_featured'      => ['boolean'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->media->replace($post?->thumbnail, $request->file('thumbnail'), 'posts');
        }

        // Publishing without an explicit date means "now".
        if ($data['status'] === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        $data['author_id'] = $post?->author_id ?? auth()->id();

        return $data;
    }

    private function afterSave(Post $post, Request $request): void
    {
        $post->tags()->sync($request->input('tags', []));
        $post->syncSeo($request->input('seo', []));
    }
}
