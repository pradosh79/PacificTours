<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\HomeFeature;
use App\Models\Testimonial;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(private readonly TourRepositoryInterface $tours) {}

    public function __invoke()
    {
        /*
         * Sections shown on the client-approved Vancouver homepage. Every block
         * is either database-driven or driven by editable admin settings, so
         * marketing can update copy/photos without a deploy.
         */
        $data = Cache::remember('home:payload:'.app()->getLocale(), now()->addMinutes(10), fn () => [
            // Search band dropdown + fallback for the destinations grid
            'destinations'         => Destination::active()->orderBy('sort_order')->get(),

            // Popular Destinations block (4 cards). Featured first, then top up.
            'popularDestinations'  => Destination::active()->featured()->withCount('tours')
                ->orderBy('sort_order')->limit(4)->get()
                ->pipe(function ($list) {
                    if ($list->count() < 4) {
                        $list = $list->merge(
                            Destination::active()->whereNotIn('id', $list->pluck('id'))
                                ->withCount('tours')->orderBy('sort_order')
                                ->limit(4 - $list->count())->get()
                        );
                    }

                    return $list;
                }),

            // Featured Tour Packages carousel (up to 8)
            'featuredTours'        => $this->tours->featured(8),

            // "Why Pacific Tours" 6-tile grid — fully admin-editable table
            'homeFeatures'         => HomeFeature::active()->get(),

            // Testimonials — active only. Circular carousel needs ≥4 to fill front/peek/left/right.
            'testimonials'         => Testimonial::active()->limit(8)->get(),
        ]);

        return view('web.home', $data);
    }
}
