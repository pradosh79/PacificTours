<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\TourStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTourRequest;
use App\Http\Requests\Admin\UpdateTourRequest;
use App\Models\Country;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Services\TourService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function __construct(
        private readonly TourRepositoryInterface $tours,
        private readonly TourService $service,
    ) {
        $this->authorizeResource(Tour::class, 'tour');
    }

    public function index(Request $request)
    {
        $tours = $this->tours->paginate(
            perPage: (int) $request->integer('per_page', 20),
            filters: $request->only(['keyword', 'category', 'status', 'featured', 'sort']),
            relations: ['category:id,name', 'destination:id,name'],
        );

        return $request->ajax()
            ? view('admin.tours.partials.table', compact('tours'))->render()
            : view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.form', ['tour' => new Tour] + $this->formData());
    }

    public function store(StoreTourRequest $request)
    {
        $tour = $this->service->create($request->validated());

        return redirect()
            ->route('admin.tours.edit', $tour->uuid)
            ->with('success', "Tour {$tour->code} created.");
    }

    public function edit(Tour $tour)
    {
        $tour->load(['images', 'itineraries', 'inclusions', 'highlights', 'faqs', 'departures', 'seo', 'tags']);

        return view('admin.tours.form', compact('tour') + $this->formData());
    }

    public function update(UpdateTourRequest $request, Tour $tour)
    {
        $this->service->update($tour, $request->validated());

        return back()->with('success', 'Tour updated.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();

        return back()->with('success', 'Tour moved to trash.');
    }

    public function duplicate(Tour $tour)
    {
        $this->authorize('create', Tour::class);

        $copy = $this->service->duplicate($tour);

        return redirect()->route('admin.tours.edit', $copy->uuid)->with('success', 'Tour duplicated as a draft.');
    }

    public function toggle(Request $request, Tour $tour)
    {
        $this->authorize('update', $tour);

        $this->service->toggle($tour, $request->string('flag')->toString());

        return $this->ok(message: 'Updated.');
    }

    /** Bulk status change / delete from the DataTable header. */
    public function bulk(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', 'in:delete,publish,pause,archive,feature,unfeature'],
            'ids'    => ['required', 'array', 'min:1'],
            'ids.*'  => ['integer', 'exists:tours,id'],
        ]);

        $this->authorize('update', Tour::class);

        $count = match ($data['action']) {
            'delete'    => $this->tours->bulkDelete($data['ids']),
            'publish'   => $this->tours->bulkUpdate($data['ids'], ['status' => TourStatus::Published->value, 'published_at' => now()]),
            'pause'     => $this->tours->bulkUpdate($data['ids'], ['status' => TourStatus::Paused->value]),
            'archive'   => $this->tours->bulkUpdate($data['ids'], ['status' => TourStatus::Archived->value]),
            'feature'   => $this->tours->bulkUpdate($data['ids'], ['is_featured' => true]),
            'unfeature' => $this->tours->bulkUpdate($data['ids'], ['is_featured' => false]),
        };

        return $this->ok(['affected' => $count], "{$count} tour(s) updated.");
    }

    private function formData(): array
    {
        return [
            'categories'   => TourCategory::active()->orderBy('name')->get(['id', 'name']),
            'destinations' => Destination::active()->orderBy('name')->get(['id', 'name']),
            'countries'    => Country::active()->orderBy('name')->get(['id', 'name']),
            'statuses'     => TourStatus::cases(),
        ];
    }
}
