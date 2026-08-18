<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Services\SearchService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function __construct(
        private readonly SearchService $search,
        private readonly TourRepositoryInterface $tours,
    ) {}

    public function index(Request $request)
    {
        $tours = $this->search->tours($request->all(), 12);

        // Infinite scroll and filter changes re-render only the grid.
        return $request->ajax()
            ? view('web.tours.partials.grid', compact('tours'))->render()
            : view('web.tours.index', [
                'tours'  => $tours,
                'facets' => $this->search->facets(),
                'query'  => $request->all(),
            ]);
    }

    public function show(string $slug)
    {
        $tour = $this->tours->findBySlug($slug) ?? abort(404);

        $tour->incrementQuietly('views_count');

        return view('web.tours.show', [
            'tour'    => $tour,
            'related' => $this->tours->related($tour),
        ]);
    }

    public function suggest(Request $request)
    {
        $request->validate(['q' => ['required', 'string', 'min:2', 'max:60']]);

        return $this->ok($this->search->suggest($request->string('q')->toString()));
    }

    /** Live availability for the date picker on the detail page. */
    public function availability(Request $request, string $slug)
    {
        $tour = $this->tours->findBySlug($slug) ?? abort(404);

        return $this->ok(
            $tour->departures()->open()->orderBy('start_date')->get()
                ->map(fn ($d) => [
                    'id'        => $d->uuid,
                    'date'      => $d->start_date->toDateString(),
                    'available' => $d->seats_available,
                    'price'     => (float) ($d->price_override ?? $tour->sale_price),
                ])
        );
    }
}
