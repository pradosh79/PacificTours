<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 40)->default('general')->index(); // general|smtp|payment|theme|seo|social
            $table->string('key', 120);
            $table->longText('value')->nullable();
            $table->string('type', 20)->default('string');            // string|bool|int|json|file|encrypted
            $table->boolean('is_public')->default(false);
            $table->timestamps();
            $table->unique(['group', 'key']);
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->char('code', 3)->unique();
            $table->string('symbol', 8);
            $table->decimal('exchange_rate', 14, 6)->default(1);
            $table->string('position', 10)->default('left');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('code', 5)->unique();
            $table->string('flag')->nullable();
            $table->string('direction', 3)->default('ltr');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Generic translation store: keeps "French ready" without duplicating every table.
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->morphs('translatable');
            $table->string('locale', 5)->index();
            $table->string('field', 60);
            $table->longText('value')->nullable();
            $table->timestamps();
            $table->unique(['translatable_type', 'translatable_id', 'locale', 'field'], 'translations_unique');
        });
    }

    public function down(): void
    {
        foreach (['translations', 'languages', 'currencies', 'settings'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
