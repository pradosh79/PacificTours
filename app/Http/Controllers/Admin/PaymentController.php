<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentRepositoryInterface $payments,
        private readonly PaymentService $service,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\Booking::class);

        $payments = $this->payments->query()
            ->with(['booking:id,uuid,booking_number,customer_email', 'user:id,first_name,last_name'])
            ->when($request->filled('gateway'), fn ($q) => $q->where('gateway', $request->gateway))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('keyword'), fn ($q) => $q->where('transaction_id', 'like', "%{$request->keyword}%"))
            ->latest('id')->paginate(25)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.tour', 'logs', 'refunds']);

        return view('admin.payments.show', compact('payment'));
    }

    public function refund(Request $request, Payment $payment)
    {
        $this->authorize('refund', $payment->booking);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:'.$payment->refundable_amount],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $refund = $this->service->refund($payment, (float) $data['amount'], $data['reason'] ?? null);

        return back()->with(
            $refund->status === 'completed' ? 'success' : 'error',
            $refund->status === 'completed' ? 'Refund processed.' : 'The gateway rejected the refund.'
        );
    }

    public function logs(Payment $payment)
    {
        return $this->ok($payment->logs()->latest('id')->limit(50)->get());
    }
}
