<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use App\Support\NumberGenerator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function createFor(Booking $booking): Invoice
    {
        return $booking->invoice()->create([
            'invoice_number'   => NumberGenerator::invoice(),
            'issued_at'        => today(),
            'due_at'           => today()->addDays((int) setting('general.invoice_due_days', 7)),
            'subtotal'         => $booking->subtotal,
            'discount_total'   => (float) $booking->tour_discount + (float) $booking->coupon_discount,
            'tax_total'        => $booking->tax_total,
            'total'            => $booking->grand_total,
            'currency'         => $booking->currency,
            'status'           => 'unpaid',
            'billing_snapshot' => [
                'name'    => $booking->customer_name,
                'email'   => $booking->customer_email,
                'phone'   => $booking->customer_phone,
                'address' => $booking->customer_address,
                'country' => $booking->customer_country,
            ],
        ]);
    }

    /** Renders and stores the PDF, returning the storage path. Queued after confirmation. */
    public function generatePdf(Invoice $invoice): string
    {
        $invoice->loadMissing(['booking.tour', 'booking.travelers']);

        $pdf  = Pdf::loadView('pdf.invoice', ['invoice' => $invoice, 'booking' => $invoice->booking]);
        $path = 'invoices/'.$invoice->created_at->format('Y/m').'/'.$invoice->invoice_number.'.pdf';

        Storage::disk('local')->put($path, $pdf->output());
        $invoice->update(['pdf_path' => $path]);

        return $path;
    }

    public function download(Invoice $invoice)
    {
        if (! $invoice->pdf_path || ! Storage::disk('local')->exists($invoice->pdf_path)) {
            $this->generatePdf($invoice);
        }

        return Storage::disk('local')->download($invoice->fresh()->pdf_path, $invoice->invoice_number.'.pdf');
    }
}
