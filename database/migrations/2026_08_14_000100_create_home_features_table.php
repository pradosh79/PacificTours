<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin-manageable "Why book with us" list shown on the homepage. Deliberately
 * small — icon + title + description + order — because a full CMS block editor
 * is overkill for six items that change once a year.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_features', function (Blueprint $table): void {
            $table->id();
            $table->string('icon', 40)->default('check');   // maps to components/icon.blade.php
            $table->string('title', 120);
            $table->string('description', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_features');
    }
};
