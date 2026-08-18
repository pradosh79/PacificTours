<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->uuid,
            'invoice_number' => $this->invoice_number,
            'issued_at'      => $this->issued_at->toDateString(),
            'due_at'         => $this->due_at?->toDateString(),
            'total'          => (float) $this->total,
            'amount_paid'    => (float) $this->amount_paid,
            'balance'        => $this->balance,
            'status'         => $this->status,
            'download_url'   => route('customer.invoices.download', $this->uuid),
        ];
    }
}
