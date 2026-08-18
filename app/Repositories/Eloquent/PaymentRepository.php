<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function findByTransaction(string $gateway, string $transactionId): ?Payment
    {
        return $this->query()->where('gateway', $gateway)->where('transaction_id', $transactionId)->first();
    }

    public function latest(int $limit = 10): Collection
    {
        return $this->query()->succeeded()
            ->with(['booking:id,booking_number,customer_first_name,customer_last_name'])
            ->latest('paid_at')->limit($limit)->get();
    }

    public function revenueBetween(string $from, string $to): float
    {
        return (float) $this->query()->succeeded()
            ->whereBetween('paid_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->sum('amount');
    }
}
