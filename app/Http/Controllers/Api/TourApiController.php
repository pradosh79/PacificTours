<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Services\SearchService;
use Illuminate\Http\Request;

class TourApiController extends Controller
{
    public function __construct(
        private readonly SearchService $search,
        private readonly TourRepositoryInterface $tours,
    ) {}

    public function index(Request $request)
    {
        return TourResource::collection($this->search->tours($request->all(), (int) $request->integer('per_page', 12)));
    }

    public function show(string $slug)
    {
        $tour = $this->tours->findBySlug($slug) ?? abort(404);

        return new TourResource($tour);
    }

    public function featured()
    {
        return TourResource::collection($this->tours->featured(8));
    }

    public function facets()
    {
        return $this->ok($this->search->facets());
    }
}
