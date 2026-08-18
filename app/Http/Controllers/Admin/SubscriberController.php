<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\Page::class);

        return view('admin.cms.subscribers', [
            'subscribers' => Subscriber::when($request->filled('keyword'), fn ($q) => $q->where('email', 'like', "%{$request->keyword}%"))
                ->when($request->boolean('active_only'), fn ($q) => $q->whereNull('unsubscribed_at'))
                ->latest('id')->paginate(50)->withQueryString(),
            'stats' => [
                'total'  => Subscriber::count(),
                'active' => Subscriber::whereNull('unsubscribed_at')->count(),
            ],
        ]);
    }

    /** Streamed so a 200k-row list never exhausts memory. */
    public function export(): StreamedResponse
    {
        $this->authorize('viewAny', \App\Models\Page::class);

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['Email', 'Name', 'Subscribed', 'Unsubscribed']);

            Subscriber::orderBy('id')->chunk(1000, function ($chunk) use ($handle): void {
                foreach ($chunk as $subscriber) {
                    fputcsv($handle, [
                        $subscriber->email,
                        $subscriber->name,
                        $subscriber->created_at->toDateString(),
                        $subscriber->unsubscribed_at?->toDateString(),
                    ]);
                }
            });

            fclose($handle);
        }, 'subscribers-'.now()->toDateString().'.csv', ['Content-Type' => 'text/csv']);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber removed.');
    }
}
