<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_text_1');
            $table->string('hero_text_2');
            $table->string('hero_text_3');
            $table->string('shop_text_1');
            $table->string('shop_text_2');
            $table->string('shop_text_3');
            $table->string('event_text_1');
            $table->string('shop_img_1')->nullable();
            $table->string('shop_img_2')->nullable();
            $table->string('shop_img_3')->nullable();
            $table->string('shop_img_4')->nullable();
            $table->string('event_img')->nullable();
            $table->text('mission_text');
            $table->json('mission_bullets');
            $table->text('about_text');
            $table->json('selected_blog_posts');
            $table->json('selected_products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
