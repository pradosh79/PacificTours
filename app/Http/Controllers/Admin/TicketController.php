<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\MediaService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private readonly MediaService $media)
    {
        $this->middleware('permission:ticket.view')->only(['index', 'show']);
        $this->middleware('permission:ticket.reply')->only('reply');
        $this->middleware('permission:ticket.close')->only('close');
    }

    public function index(Request $request)
    {
        return view('admin.tickets.index', [
            'tickets' => Ticket::with('user:id,first_name,last_name,email')
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
                ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->priority))
                ->when($request->filled('department'), fn ($q) => $q->where('department', $request->department))
                ->when($request->filled('keyword'), fn ($q) => $q->where(fn ($s) => $s
                    ->where('ticket_number', 'like', "%{$request->keyword}%")
                    ->orWhere('subject', 'like', "%{$request->keyword}%")))
                ->orderByRaw("FIELD(priority, 'urgent','high','medium','low')")
                ->latest('last_reply_at')
                ->paginate(20)->withQueryString(),
        ]);
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', [
            'ticket' => $ticket->load(['messages.attachments', 'messages.user', 'user.profile', 'booking']),
        ]);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'message'       => ['required', 'string', 'max:5000'],
            'attachments'   => ['nullable', 'array', 'max:3'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'close'         => ['boolean'],
        ]);

        $message = $ticket->messages()->create([
            'user_id'  => auth()->id(),
            'message'  => $data['message'],
            'is_staff' => true,
        ]);

        foreach ($request->file('attachments', []) as $file) {
            $message->attachments()->create([
                'path'          => $this->media->store($file, 'tickets', 'local'),
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);
        }

        $ticket->update([
            'status'        => ! empty($data['close']) ? TicketStatus::Closed : TicketStatus::Answered,
            'last_reply_at' => now(),
            'assigned_to'   => $ticket->assigned_to ?? auth()->id(),
        ]);

        return back()->with('success', 'Reply sent.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $ticket->update($request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]));

        return back()->with('success', 'Ticket assigned.');
    }

    public function close(Ticket $ticket)
    {
        $ticket->update(['status' => TicketStatus::Closed]);

        return back()->with('success', 'Ticket closed.');
    }
}
