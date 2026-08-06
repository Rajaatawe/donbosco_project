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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->string('slug')->unique();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->json('location');
            $table->string('cover_image')->nullable();
            $table->enum('status',  ['draft', 'published', 'hidden', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
