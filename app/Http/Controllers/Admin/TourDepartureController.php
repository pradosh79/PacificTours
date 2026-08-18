<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourDeparture;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Departures are inventory, so this screen is where seats actually come from.
 * Editing seats_total is guarded: you can never drop capacity below what is
 * already sold.
 */
class TourDepartureController extends Controller
{
    public function index(Tour $tour)
    {
        $this->authorize('view', $tour);

        return view('admin.tours.departures', [
            'tour'       => $tour,
            'departures' => $tour->departures()->orderBy('start_date')->paginate(30),
        ]);
    }

    public function store(Request $request, Tour $tour)
    {
        $this->authorize('update', $tour);

        $data = $request->validate([
            'start_date'     => ['required', 'date', 'after:today'],
            'seats_total'    => ['required', 'integer', 'min:1'],
            'price_override' => ['nullable', 'numeric', 'min:0'],
            'status'         => ['required', 'in:open,closed,cancelled'],
        ]);

        $tour->departures()->create([
            ...$data,
            'end_date' => Carbon::parse($data['start_date'])->addDays(max(0, $tour->duration_days - 1)),
        ]);

        return back()->with('success', 'Departure added.');
    }

    /** Generate a recurring schedule — the fast way to open a season. */
    public function generate(Request $request, Tour $tour)
    {
        $this->authorize('update', $tour);

        $data = $request->validate([
            'from'        => ['required', 'date', 'after:today'],
            'until'       => ['required', 'date', 'after:from'],
            'weekdays'    => ['required', 'array', 'min:1'],
            'weekdays.*'  => ['integer', 'between:0,6'],
            'seats_total' => ['required', 'integer', 'min:1'],
        ]);

        $created = 0;

        DB::transaction(function () use ($tour, $data, &$created): void {
            $cursor = Carbon::parse($data['from']);
            $until  = Carbon::parse($data['until']);

            while ($cursor->lte($until)) {
                if (in_array($cursor->dayOfWeek, $data['weekdays'], true)
                    && ! $tour->departures()->whereDate('start_date', $cursor)->exists()) {
                    $tour->departures()->create([
                        'start_date'  => $cursor->copy(),
                        'end_date'    => $cursor->copy()->addDays(max(0, $tour->duration_days - 1)),
                        'seats_total' => $data['seats_total'],
                        'status'      => 'open',
                    ]);
                    $created++;
                }

                $cursor->addDay();
            }
        });

        return back()->with('success', "{$created} departures created.");
    }

    public function update(Request $request, TourDeparture $departure)
    {
        $this->authorize('update', $departure->tour);

        $data = $request->validate([
            'seats_total'    => ['required', 'integer', 'min:'.$departure->seats_booked],
            'seats_blocked'  => ['nullable', 'integer', 'min:0'],
            'price_override' => ['nullable', 'numeric', 'min:0'],
            'status'         => ['required', 'in:open,closed,cancelled,full'],
        ], [
            'seats_total.min' => "You cannot set capacity below the {$departure->seats_booked} seats already sold.",
        ]);

        $departure->update($data);

        return back()->with('success', 'Departure updated.');
    }

    public function destroy(TourDeparture $departure)
    {
        $this->authorize('update', $departure->tour);

        abort_if(
            $departure->seats_booked > 0,
            409,
            'This departure has bookings. Close it instead of deleting it, so the history is kept.'
        );

        $departure->delete();

        return back()->with('success', 'Departure removed.');
    }
}
