<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceService $invoices) {}

    public function index(Request $request)
    {
        return view('customer.invoices', [
            'invoices' => Invoice::whereHas('booking', fn ($q) => $q->where('user_id', $request->user()->id))
                ->with('booking:id,uuid,booking_number,tour_id')
                ->latest('id')->paginate(15),
        ]);
    }

    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice->booking);

        return $this->invoices->download($invoice);
    }
}
