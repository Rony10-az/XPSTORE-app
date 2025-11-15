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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_game_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5 estrellas
            $table->string('title');
            $table->text('content');
            $table->integer('helpful')->default(0); // Contador de "útil"
            $table->timestamps();

            // Un usuario solo puede hacer una reseña por juego
            $table->unique(['user_id', 'video_game_id']);

            // Índices
            $table->index('rating');
            $table->index('created_at');
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
