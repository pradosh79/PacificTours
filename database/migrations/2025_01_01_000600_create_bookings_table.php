<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('booking_number', 32)->unique();       // PT-2026-000123
            $table->foreignId('tour_id')->constrained()->restrictOnDelete();
            $table->foreignId('tour_departure_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Immutable snapshot of the buyer (guest checkout supported)
            $table->string('customer_first_name', 100);
            $table->string('customer_last_name', 100)->nullable();
            $table->string('customer_email');
            $table->string('customer_phone', 32)->nullable();
            $table->string('customer_country', 120)->nullable();
            $table->string('customer_address')->nullable();

            $table->date('travel_date')->index();
            $table->date('return_date')->nullable();
            $table->unsignedSmallInteger('adults')->default(1);
            $table->unsignedSmallInteger('children')->default(0);
            $table->unsignedSmallInteger('infants')->default(0);

            // Frozen pricing snapshot
            $table->decimal('adult_unit_price', 12, 2)->default(0);
            $table->decimal('child_unit_price', 12, 2)->default(0);
            $table->decimal('infant_unit_price', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tour_discount', 12, 2)->default(0);
            $table->decimal('coupon_discount', 12, 2)->default(0);
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->decimal('deposit_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->decimal('refunded_amount', 12, 2)->default(0);
            $table->char('currency', 3)->default('CAD');

            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 20)->default('pending')->index();
            $table->string('payment_status', 24)->default('unpaid')->index();
            $table->string('source', 20)->default('web');        // web|admin|api|phone
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->json('meta')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('cancellation_reason', 255)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'travel_date']);
            $table->index(['created_at', 'status']);
        });

        Schema::create('booking_travelers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('type', 12)->default('adult');
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('nationality', 120)->nullable();
            $table->string('passport_number', 64)->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('dietary_requirement', 160)->nullable();
            $table->text('special_request')->nullable();
            $table->timestamps();
            $table->index(['booking_id', 'type']);
        });

        Schema::create('booking_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('from_status', 20)->nullable();
            $table->string('to_status', 20);
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('note', 255)->nullable();
            $table->timestamps();
        });

        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('coupon_usages', fn (Blueprint $t) => $t->dropForeign(['booking_id']));
        Schema::dropIfExists('booking_status_histories');
        Schema::dropIfExists('booking_travelers');
        Schema::dropIfExists('bookings');
    }
};
