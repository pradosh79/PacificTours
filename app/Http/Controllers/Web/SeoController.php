<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    public function sitemap()
    {
        abort_unless(Storage::disk('public')->exists('sitemap.xml'), 404);

        return response(Storage::disk('public')->get('sitemap.xml'), 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /customer',
            'Disallow: /checkout',
            'Sitemap: '.url('sitemap.xml'),
        ];

        return response(implode(PHP_EOL, $lines), 200, ['Content-Type' => 'text/plain']);
    }
}
