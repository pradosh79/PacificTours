<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactRequest;
use App\Models\ContactMessage;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::published()->with('seo')->where('slug', $slug)->firstOrFail();

        // A page picks its own Blade template; unknown templates fall back safely.
        $view = view()->exists("web.pages.{$page->template}") ? "web.pages.{$page->template}" : 'web.pages.default';

        return view($view, compact('page'));
    }

    public function destinations()
    {
        return view('web.pages.destinations', [
            'destinations' => Destination::active()->withCount('tours')->orderBy('name')->paginate(24),
        ]);
    }

    public function destination(string $slug)
    {
        $destination = Destination::active()->with('seo')->where('slug', $slug)->firstOrFail();

        return view('web.pages.destination', [
            'destination' => $destination,
            'tours'       => $destination->tours()->published()->paginate(12),
        ]);
    }

    public function faqs()
    {
        return view('web.pages.faqs', ['groups' => Faq::active()->get()->groupBy('category')]);
    }

    public function gallery()
    {
        return view('web.pages.gallery', ['galleries' => Gallery::with('images')->where('is_active', true)->get()]);
    }

    public function contact()
    {
        return view('web.pages.contact');
    }

    public function submitContact(ContactRequest $request)
    {
        ContactMessage::create($request->safe()->except('website') + ['ip_address' => $request->ip()]);

        return back()->with('success', 'Thanks — we will reply within one business day.');
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name'  => ['nullable', 'string', 'max:160'],
        ]);

        Subscriber::updateOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'] ?? null, 'token' => Str::random(48), 'ip_address' => $request->ip(), 'unsubscribed_at' => null]
        );

        return $request->wantsJson()
            ? $this->ok(message: 'You are on the list.')
            : back()->with('success', 'You are on the list.');
    }
}
