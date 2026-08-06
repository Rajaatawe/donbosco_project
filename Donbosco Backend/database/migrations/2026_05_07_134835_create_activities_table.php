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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_category_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null')
            ->cascadeOnUpdate();
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('summary');
            $table->json('content');
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft', 'published','hidden','archived'])->default('draft');
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
        Schema::dropIfExists('activities');
    }
};

