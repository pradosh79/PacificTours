<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Exceptions\PaymentException;
use Illuminate\Contracts\Container\Container;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGatewayContract> */
    private array $resolved = [];

    public function __construct(private readonly Container $app) {}

    public function driver(string $key): PaymentGatewayContract
    {
        $class = config("travel.gateways.{$key}") ?? throw PaymentException::gatewayNotConfigured($key);

        return $this->resolved[$key] ??= $this->app->make($class);
    }

    /** @return array<string, string> gateway key => display label, filtered by settings */
    public function enabled(): array
    {
        return collect(config('travel.gateways'))
            ->keys()
            ->filter(fn (string $key) => (bool) setting("payment.{$key}_enabled", $key === 'stripe'))
            ->mapWithKeys(fn (string $key) => [$key => \App\Enums\PaymentGateway::from($key)->label()])
            ->toArray();
    }
}
