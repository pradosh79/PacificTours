<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Tour;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlashSaleController extends Controller
{
    public function __construct(private readonly PricingService $pricing)
    {
        $this->middleware('permission:coupon.view')->only('index');
        $this->middleware('permission:coupon.create')->only('store');
        $this->middleware('permission:coupon.update')->only(['update', 'syncTours']);
        $this->middleware('permission:coupon.delete')->only('destroy');
    }

    public function index()
    {
        return view('admin.cms.flash-sales', [
            'sales' => FlashSale::withCount('tours')->latest('id')->paginate(20),
            'tours' => Tour::published()->orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request)
    {
        $sale = FlashSale::create($this->validated($request));
        $sale->tours()->sync($request->input('tour_ids', []));
        $this->refreshPrices($sale);

        return back()->with('success', 'Flash sale created.');
    }

    public function update(Request $request, FlashSale $sale)
    {
        $sale->update($this->validated($request));
        $sale->tours()->sync($request->input('tour_ids', []));
        $this->refreshPrices($sale);

        return back()->with('success', 'Flash sale updated.');
    }

    public function destroy(FlashSale $sale)
    {
        $tours = $sale->tours()->pluck('tours.id');
        $sale->delete();

        Tour::whereIn('id', $tours)->each(fn (Tour $tour) => $this->pricing->refreshSalePrice($tour));

        return back()->with('success', 'Flash sale removed and prices restored.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'           => ['required', 'string', 'max:160'],
            'discount_type'  => ['required', Rule::in(['percentage', 'fixed'])],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'starts_at'      => ['required', 'date'],
            'ends_at'        => ['required', 'date', 'after:starts_at'],
            'is_active'      => ['boolean'],
            'tour_ids'       => ['nullable', 'array'],
            'tour_ids.*'     => ['exists:tours,id'],
        ]);
    }

    /** Denormalised sale_price keeps the catalogue query cheap; recompute it here. */
    private function refreshPrices(FlashSale $sale): void
    {
        $sale->tours->each(fn (Tour $tour) => $this->pricing->refreshSalePrice($tour));
    }
}
