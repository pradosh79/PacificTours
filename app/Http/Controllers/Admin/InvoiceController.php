<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceService $invoices)
    {
        $this->middleware('permission:payment.view');
    }

    public function index(Request $request)
    {
        return view('admin.payments.invoices', [
            'invoices' => Invoice::with('booking:id,uuid,booking_number,customer_first_name,customer_last_name')
                ->when($request->filled('keyword'), fn ($q) => $q->where('invoice_number', 'like', "%{$request->keyword}%"))
                ->when($request->boolean('unpaid_only'), fn ($q) => $q->where('balance', '>', 0))
                ->latest('id')->paginate(25)->withQueryString(),
        ]);
    }

    public function download(Invoice $invoice)
    {
        return $this->invoices->download($invoice);
    }

    /** Force a fresh render — used after an admin edits booking money. */
    public function regenerate(Invoice $invoice)
    {
        $this->invoices->generatePdf($invoice->fresh('booking'));

        return back()->with('success', 'Invoice regenerated.');
    }
}
