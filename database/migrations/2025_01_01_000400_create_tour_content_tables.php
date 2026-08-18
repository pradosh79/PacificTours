<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt_text', 160)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number');
            $table->string('title', 200);
            $table->longText('description')->nullable();
            $table->string('accommodation', 200)->nullable();
            $table->string('meals', 120)->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['tour_id', 'day_number']);
        });

        Schema::create('tour_inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('type', 12)->default('included'); // included|excluded
            $table->string('content', 255);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['tour_id', 'type']);
        });

        Schema::create('tour_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('content', 255);
            $table->string('icon', 60)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('question', 255);
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_departures', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->date('start_date')->index();
            $table->date('end_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->decimal('price_override', 12, 2)->nullable();
            $table->decimal('child_price_override', 12, 2)->nullable();
            $table->unsignedInteger('seats_total')->default(0);
            $table->unsignedInteger('seats_booked')->default(0);
            $table->unsignedInteger('seats_blocked')->default(0);
            $table->string('status', 20)->default('open')->index(); // open|closed|full|cancelled
            $table->string('guide_name', 160)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['tour_id', 'start_date']);
        });
    }

    public function down(): void
    {
        foreach (['tour_departures', 'tour_faqs', 'tour_highlights', 'tour_inclusions', 'tour_itineraries', 'tour_images'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
