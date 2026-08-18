<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Destination;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tour;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class RebuildSitemap implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('maintenance');
    }

    public function handle(): void
    {
        $urls = collect([['loc' => url('/'), 'priority' => '1.0', 'lastmod' => now()->toAtomString()]]);

        Tour::published()->select('slug', 'updated_at')->chunk(500, function ($tours) use ($urls): void {
            $tours->each(fn ($t) => $urls->push([
                'loc' => route('tours.show', $t->slug), 'priority' => '0.9', 'lastmod' => $t->updated_at->toAtomString(),
            ]));
        });

        Destination::active()->select('slug', 'updated_at')->get()
            ->each(fn ($d) => $urls->push(['loc' => route('destinations.show', $d->slug), 'priority' => '0.8', 'lastmod' => $d->updated_at->toAtomString()]));

        Post::published()->select('slug', 'updated_at')->get()
            ->each(fn ($p) => $urls->push(['loc' => route('blog.show', $p->slug), 'priority' => '0.6', 'lastmod' => $p->updated_at->toAtomString()]));

        Page::published()->select('slug', 'updated_at')->get()
            ->each(fn ($p) => $urls->push(['loc' => route('pages.show', $p->slug), 'priority' => '0.5', 'lastmod' => $p->updated_at->toAtomString()]));

        Storage::disk('public')->put('sitemap.xml', view('seo.sitemap', ['urls' => $urls])->render());
    }
}
