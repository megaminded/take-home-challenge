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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('category')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('author')->nullable();
            $table->string('image_url')->nullable();
            $table->string('source_url')->unique();
            $table->dateTime('publishedAt');
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
