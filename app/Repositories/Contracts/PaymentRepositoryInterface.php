<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

interface PaymentRepositoryInterface extends RepositoryInterface
{
    public function findByTransaction(string $gateway, string $transactionId): ?Payment;

    public function latest(int $limit = 10): Collection;

    public function revenueBetween(string $from, string $to): float;
}
