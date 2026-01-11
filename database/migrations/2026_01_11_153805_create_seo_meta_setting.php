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
        Schema::create('seo_meta_setting', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keyword');
            $table->string('type');
            $table->string('og-title');
            $table->string('og-description');
            $table->string('og-image');
            $table->string('twitter-title');
            $table->string('twitter-description');
            $table->string('twitter-image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_meta_setting');
    }
};
