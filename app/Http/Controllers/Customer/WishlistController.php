<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.wishlist', [
            'tours' => $request->user()->wishlists()->with('tour.destination')->latest('id')->paginate(12),
        ]);
    }

    public function toggle(Request $request, Tour $tour)
    {
        $existing = $request->user()->wishlists()->where('tour_id', $tour->id)->first();

        $existing
            ? $existing->delete()
            : $request->user()->wishlists()->create(['tour_id' => $tour->id]);

        return $this->ok([
            'saved' => ! $existing,
            'count' => $request->user()->wishlists()->count(),
        ], $existing ? 'Removed from your saved tours.' : 'Saved for later.');
    }
}
