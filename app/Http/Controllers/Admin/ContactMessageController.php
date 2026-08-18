<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\Page::class);

        return view('admin.cms.messages', [
            'messages' => ContactMessage::when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
                ->latest('id')->paginate(25)->withQueryString(),
            'unread' => ContactMessage::where('status', 'new')->count(),
        ]);
    }

    public function show(ContactMessage $message)
    {
        $this->authorize('viewAny', \App\Models\Page::class);

        $message->fill(['status' => 'read', 'read_at' => now()])->saveQuietly();

        return view('admin.cms.message-show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $data = $request->validate(['reply' => ['required', 'string', 'max:5000']]);

        \Illuminate\Support\Facades\Mail::raw($data['reply'], function ($mail) use ($message): void {
            $mail->to($message->email)
                ->subject('Re: '.$message->subject)
                ->from(setting('mail.from_address', config('mail.from.address')), setting('general.company_name'));
        });

        $message->update([
            'status'     => 'replied',
            'reply'      => $data['reply'],
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Message deleted.');
    }
}
