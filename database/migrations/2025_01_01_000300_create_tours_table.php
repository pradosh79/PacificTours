<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code', 32)->unique();                 // PT-TOUR-000123
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->foreignId('tour_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();

            $table->string('summary', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('travel_information')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('cancellation_policy')->nullable();
            $table->longText('visa_requirements')->nullable();

            $table->unsignedSmallInteger('duration_days')->default(1);
            $table->unsignedSmallInteger('duration_nights')->default(0);
            $table->string('tour_type', 40)->default('group');    // group|private|custom
            $table->string('difficulty', 20)->default('easy');
            $table->string('pickup_location')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('meeting_point')->nullable();

            $table->decimal('base_price', 12, 2)->default(0);      // adult
            $table->decimal('child_price', 12, 2)->default(0);
            $table->decimal('infant_price', 12, 2)->default(0);
            $table->string('discount_type', 20)->default('none');
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->decimal('sale_price', 12, 2)->default(0)->index(); // denormalised for sorting/filtering
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->string('deposit_type', 20)->default('disabled');
            $table->decimal('deposit_value', 12, 2)->default(0);
            $table->char('currency', 3)->default('CAD');

            $table->unsignedInteger('max_seats')->default(0);
            $table->unsignedInteger('min_booking')->default(1);
            $table->unsignedInteger('max_booking')->default(20);
            $table->unsignedSmallInteger('booking_cutoff_hours')->default(48);

            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->string('video_url')->nullable();
            $table->decimal('map_latitude', 10, 7)->nullable();
            $table->decimal('map_longitude', 10, 7)->nullable();

            $table->string('status', 20)->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_popular')->default(false)->index();
            $table->boolean('is_recommended')->default(false)->index();

            $table->decimal('average_rating', 3, 2)->default(0)->index();
            $table->unsignedInteger('reviews_count')->default(0);
            $table->unsignedInteger('bookings_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_featured', 'sale_price']);
            $table->fullText(['title', 'summary', 'description']);
        });

        Schema::create('tour_tag', function (Blueprint $table) {
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['tour_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_tag');
        Schema::dropIfExists('tours');
    }
};
