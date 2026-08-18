<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->string('template', 60)->default('default');   // default|home|contact|visa|insurance
            $table->longText('content')->nullable();
            $table->json('sections')->nullable();                 // section builder payload
            $table->string('banner')->nullable();
            $table->boolean('is_system')->default(false);         // system pages cannot be deleted
            $table->boolean('show_in_footer')->default(false);
            $table->string('status', 20)->default('published')->index();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('location', 40)->unique();             // header|footer|mega|top
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->string('label', 160);
            $table->string('type', 30)->default('custom');        // custom|page|tour|category|destination|blog
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('url')->nullable();
            $table->string('icon', 60)->nullable();
            $table->string('target', 12)->default('_self');
            $table->boolean('is_mega')->default(false);
            $table->unsignedTinyInteger('mega_column')->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('area', 40)->index();                  // footer_1..footer_4|sidebar
            $table->string('type', 40)->default('text');          // text|links|contact|newsletter|social
            $table->string('title', 160)->nullable();
            $table->json('content')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->default('home_slider')->index();
            $table->string('title', 200)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('image');
            $table->string('mobile_image')->nullable();
            $table->string('button_text', 60)->nullable();
            $table->string('button_url')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('designation', 160)->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('content');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category', 80)->default('general')->index();
            $table->string('question', 255);
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160);
            $table->string('slug', 180)->unique();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption', 200)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('slug', 180)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type', 12)->default('blog')->index(); // blog|news
            $table->foreignId('post_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->string('excerpt', 500)->nullable();
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('banner')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->fullText(['title', 'excerpt', 'content']);
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name', 160)->nullable();
            $table->string('token', 64)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('email');
            $table->string('phone', 32)->nullable();
            $table->string('subject', 200)->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false)->index();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();
            $table->morphs('seoable');
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_keywords', 300)->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title', 200)->nullable();
            $table->string('og_description', 300)->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card', 40)->default('summary_large_image');
            $table->json('schema_markup')->nullable();
            $table->string('robots', 60)->default('index,follow');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'seo_meta', 'contact_messages', 'subscribers', 'post_tag', 'posts', 'post_categories',
            'gallery_images', 'galleries', 'faqs', 'testimonials', 'banners', 'widgets',
            'menu_items', 'menus', 'pages',
        ] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
