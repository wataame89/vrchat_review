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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title',20);
            $table->string('body',200);
            $table->integer('rank');
            $table->string('world_id');
            $table->integer('user_id');
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
