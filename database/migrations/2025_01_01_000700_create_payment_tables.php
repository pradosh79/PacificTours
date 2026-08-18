<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('invoice_number', 32)->unique();       // INV-2026-000123
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->date('issued_at');
            $table->date('due_at')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->char('currency', 3)->default('CAD');
            $table->string('status', 20)->default('unpaid')->index();
            $table->string('pdf_path')->nullable();
            $table->json('billing_snapshot')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('gateway', 32)->index();
            $table->string('type', 20)->default('full');
            $table->string('transaction_id')->nullable()->index();
            $table->string('gateway_reference')->nullable();      // PaymentIntent / Order id
            $table->decimal('amount', 12, 2);
            $table->decimal('gateway_fee', 12, 2)->default(0);
            $table->char('currency', 3)->default('CAD');
            $table->decimal('exchange_rate', 12, 6)->default(1);
            $table->string('status', 20)->default('initiated')->index();
            $table->json('gateway_payload')->nullable();
            $table->string('failure_reason', 255)->nullable();
            $table->timestamp('paid_at')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['gateway', 'transaction_id']);
        });

        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('gateway', 32)->index();
            $table->string('event', 80)->index();
            $table->string('direction', 12)->default('outgoing'); // outgoing|incoming|webhook
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('reason', 255)->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->string('gateway_refund_id')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('gateway', 32)->index();
            $table->string('event_id')->index();
            $table->string('type', 120);
            $table->json('payload');
            $table->timestamp('processed_at')->nullable();
            $table->string('status', 20)->default('received');
            $table->text('error')->nullable();
            $table->timestamps();
            $table->unique(['gateway', 'event_id']);   // idempotency guard
        });
    }

    public function down(): void
    {
        foreach (['webhook_events', 'refunds', 'payment_logs', 'payments', 'invoices'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
