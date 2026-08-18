<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->string('name', 160)->nullable();
            $table->string('type', 20)->default('percentage');   // percentage|fixed
            $table->decimal('value', 12, 2);
            $table->decimal('min_spend', 12, 2)->nullable();
            $table->decimal('max_discount', 12, 2)->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('usage_limit_per_user')->default(1);
            $table->unsignedInteger('used_count')->default(0);
            $table->json('applicable_tour_ids')->nullable();
            $table->json('applicable_category_ids')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booking_id')->nullable();
            $table->decimal('discount_amount', 12, 2);
            $table->timestamps();
            $table->index(['coupon_id', 'user_id']);
        });

        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160);
            $table->string('discount_type', 20)->default('percentage');
            $table->decimal('discount_value', 12, 2);
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('flash_sale_tour', function (Blueprint $table) {
            $table->foreignId('flash_sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->primary(['flash_sale_id', 'tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sale_tour');
        Schema::dropIfExists('flash_sales');
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
    }
};
