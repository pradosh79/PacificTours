<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Review::class);

        $reviews = Review::with(['tour:id,title,slug', 'user:id,first_name,last_name', 'images'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('keyword'), fn ($q) => $q->where('comment', 'like', "%{$request->keyword}%"))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin.cms.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $this->authorize('approve', $review);

        $review->update([
            'status'      => ReviewStatus::Approved,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Review published.');
    }

    public function reject(Request $request, Review $review)
    {
        $this->authorize('approve', $review);

        $review->update(['status' => ReviewStatus::Rejected, 'admin_reply' => $request->input('admin_reply')]);

        return back()->with('success', 'Review rejected.');
    }

    public function reply(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $review->update($request->validate(['admin_reply' => ['required', 'string', 'max:1000']]));

        return back()->with('success', 'Reply posted.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
