<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\MediaService;
use App\Support\NumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function index(Request $request)
    {
        return view('customer.tickets.index', [
            'tickets' => $request->user()->tickets()->latest('id')->paginate(15),
        ]);
    }

    public function show(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->user_id === $request->user()->id, 403);

        return view('customer.tickets.show', ['ticket' => $ticket->load('messages.attachments')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'       => ['required', 'string', 'max:220'],
            'department'    => ['required', 'in:general,booking,payment,visa'],
            'priority'      => ['required', 'in:low,medium,high,urgent'],
            'booking_id'    => ['nullable', 'exists:bookings,id'],
            'message'       => ['required', 'string', 'max:5000'],
            'attachments'   => ['nullable', 'array', 'max:3'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $ticket = DB::transaction(function () use ($request, $data): Ticket {
            $ticket = Ticket::create([
                'ticket_number' => NumberGenerator::ticket(),
                'user_id'       => $request->user()->id,
                'booking_id'    => $data['booking_id'] ?? null,
                'name'          => $request->user()->full_name,
                'email'         => $request->user()->email,
                'subject'       => $data['subject'],
                'department'    => $data['department'],
                'priority'      => $data['priority'],
                'status'        => TicketStatus::Open,
                'last_reply_at' => now(),
            ]);

            $message = $ticket->messages()->create([
                'user_id' => $request->user()->id,
                'message' => $data['message'],
            ]);

            foreach ($request->file('attachments', []) as $file) {
                $message->attachments()->create([
                    'path'          => $this->media->store($file, 'tickets', 'local'),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                ]);
            }

            return $ticket;
        });

        return redirect()->route('customer.tickets.show', $ticket->uuid)
            ->with('success', "Ticket {$ticket->ticket_number} opened.");
    }

    public function reply(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->user_id === $request->user()->id, 403);

        $ticket->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->validate(['message' => ['required', 'string', 'max:5000']])['message'],
        ]);

        $ticket->update(['status' => TicketStatus::AwaitingReply, 'last_reply_at' => now()]);

        return back();
    }
}
