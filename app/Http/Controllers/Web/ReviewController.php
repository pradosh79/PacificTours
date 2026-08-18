<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Events\ReviewSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use App\Services\MediaService;

class ReviewController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function store(StoreReviewRequest $request)
    {
        $booking = $request->filled('booking_id') ? Booking::findOrFail($request->booking_id) : null;

        if ($booking) {
            $this->authorize('createFor', [Review::class, $booking]);
        }

        $review = Review::create($request->safe()->except('images') + [
            'user_id'              => $request->user()->id,
            'reviewer_name'        => $request->user()->full_name,
            'is_verified_purchase' => (bool) $booking,
        ]);

        foreach ($request->file('images', []) as $image) {
            $review->images()->create(['path' => $this->media->store($image, 'reviews')]);
        }

        ReviewSubmitted::dispatch($review);

        return back()->with('success', 'Thanks for the review — it appears once our team approves it.');
    }
}
