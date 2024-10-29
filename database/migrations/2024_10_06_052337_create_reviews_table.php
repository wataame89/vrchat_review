<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 30);
            $table->string('body', 300);
            $table->integer('rank');
            $table->string('image_url')->nullable();
            $table->string('world_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('liked')->default(0);
            $table->integer('disliked')->default(0);
            $table->integer('reported')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
