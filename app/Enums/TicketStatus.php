<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketStatus: string
{
    case Open           = 'open';
    case AwaitingReply  = 'awaiting_reply';
    case AnsweredByStaff = 'answered';
    case Closed         = 'closed';
}
