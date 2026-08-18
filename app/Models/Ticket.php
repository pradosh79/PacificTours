<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'ticket_number', 'user_id', 'booking_id', 'name', 'email', 'subject',
        'department', 'priority', 'status', 'assigned_to', 'last_reply_at', 'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'priority'      => TicketPriority::class,
            'status'        => TicketStatus::class,
            'last_reply_at' => 'datetime',
            'closed_at'     => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class)->oldest('id');
    }
}
