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
        Schema::create('video_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('discount')->default(0); // Porcentaje de descuento
            $table->json('images'); // Array de URLs de imágenes
            $table->json('genre'); // Array de géneros
            $table->json('platform'); // Array de plataformas
            $table->date('release_date')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->decimal('rating', 3, 2)->default(0); // Rating de 0 a 5
            $table->integer('stock')->default(0);
            $table->boolean('featured')->default(false);
            $table->json('requirements')->nullable(); // Requisitos mínimos y recomendados
            $table->timestamps();
            $table->softDeletes(); // Para no eliminar permanentemente

            // Índices para búsqueda
            $table->index('title');
            $table->index('featured');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_games');
    }
};
