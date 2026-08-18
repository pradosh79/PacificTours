<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, string $type = 'blog')
    {
        $posts = Post::published()
            ->type(PostType::from($type))
            ->with('category:id,name,slug')
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($s) => $s->where('slug', $request->category)))
            ->when($request->filled('q'), fn ($q) => $q->whereFullText(['title', 'excerpt', 'content'], $request->q))
            ->latest('published_at')
            ->paginate(9)->withQueryString();

        return view('web.pages.blog', [
            'posts'      => $posts,
            'type'       => $type,
            'categories' => PostCategory::where('is_active', true)->get(),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::published()->with(['category', 'author', 'tags', 'seo'])->where('slug', $slug)->firstOrFail();

        $post->incrementQuietly('views_count');

        return view('web.pages.post', [
            'post'    => $post,
            'related' => Post::published()->where('id', '!=', $post->id)
                ->where('post_category_id', $post->post_category_id)->limit(3)->get(),
        ]);
    }
}
