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
        Schema::create('game_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_game_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned(); // 1-5 estrellas
            $table->text('comment');
            $table->boolean('is_verified_purchase')->default(false);
            $table->timestamps();

            // Permitir múltiples reseñas por usuario por juego
            // Sin restricción unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_reviews');
    }
};
