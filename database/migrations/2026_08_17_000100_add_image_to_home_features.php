<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Home page features can now use either a built-in named icon OR an uploaded
 * image. If both are set the image wins (the Blade check is `image ?? icon`).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_features', function (Blueprint $table): void {
            $table->string('image', 255)->nullable()->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('home_features', function (Blueprint $table): void {
            $table->dropColumn('image');
        });
    }
};
