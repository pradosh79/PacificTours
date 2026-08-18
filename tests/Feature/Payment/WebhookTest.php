<?php

declare(strict_types=1);

namespace Tests\Feature\Payment;

use App\Models\WebhookEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_unsigned_webhook_is_rejected(): void
    {
        $this->postJson('/webhooks/stripe', ['type' => 'checkout.session.completed'])
            ->assertStatus(400);

        $this->assertSame(0, WebhookEvent::count());
    }

    public function test_an_unknown_gateway_is_rejected(): void
    {
        $this->postJson('/webhooks/not-a-gateway', [])->assertStatus(400);
    }

    public function test_the_same_event_id_is_only_stored_once(): void
    {
        WebhookEvent::create([
            'gateway'  => 'stripe',
            'event_id' => 'evt_123',
            'type'     => 'checkout.session.completed',
            'payload'  => [],
        ]);

        // The unique (gateway, event_id) index is the replay guard.
        $this->expectException(\Illuminate\Database\QueryException::class);

        WebhookEvent::create([
            'gateway'  => 'stripe',
            'event_id' => 'evt_123',
            'type'     => 'checkout.session.completed',
            'payload'  => [],
        ]);
    }
}
