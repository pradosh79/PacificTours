<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateInvoicePdf implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(public readonly int $invoiceId)
    {
        $this->onQueue('documents');
    }

    public function handle(InvoiceService $invoices): void
    {
        $invoice = Invoice::find($this->invoiceId);

        if ($invoice) {
            $invoices->generatePdf($invoice);
        }
    }
}
