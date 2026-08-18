<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\TourCategoryResource;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Http\Request;

class CatalogApiController extends Controller
{
    public function categories()
    {
        return TourCategoryResource::collection(
            TourCategory::active()->root()->withCount('tours')->orderBy('sort_order')->get()
        );
    }

    public function destinations()
    {
        return DestinationResource::collection(
            Destination::active()->with('country:id,name')->withCount('tours')->orderBy('name')->get()
        );
    }

    public function reviews(Request $request, string $slug)
    {
        $tour = Tour::published()->where('slug', $slug)->firstOrFail();

        return ReviewResource::collection(
            Review::approved()->where('tour_id', $tour->id)->with('images')
                ->latest('id')->paginate((int) $request->integer('per_page', 10))
        );
    }

    public function settings()
    {
        // Public config the future SPA/Figma frontend needs at boot.
        return $this->ok([
            'company'   => setting('general.company_name'),
            'email'     => setting('general.company_email'),
            'phone'     => setting('general.company_phone'),
            'currency'  => setting('theme.currency', 'CAD'),
            'locales'   => \App\Models\Language::active()->get(['code', 'name', 'direction']),
            'gateways'  => app(\App\Services\Payment\PaymentGatewayManager::class)->enabled(),
        ]);
    }
}
