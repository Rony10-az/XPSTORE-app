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
        Schema::create('market_items', function (Blueprint $table) {
            $table->id();

            // Relación con el videojuego al que pertenece el ítem
            $table->foreignId('video_game_id')
                ->constrained('video_games')
                ->cascadeOnDelete();

            // Datos principales del ítem
            $table->string('title');                      // Nombre del ítem
            $table->enum('type', ['skin', 'weapon', 'item', 'bundle'])
                ->default('item');                     // Tipo de ítem
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary'])
                ->default('common');                   // Rareza

            $table->text('description')->nullable();

            // Imagen guardada en storage (public/market/...)
            $table->string('image')->nullable();

            // Precio del ítem
            $table->decimal('price', 10, 2);

            // Stock: null = infinito; número = limitado
            $table->unsignedInteger('stock')->nullable();

            // Atributos extra (ej: {'damage': 20, 'skinColor': 'red'})
            $table->json('attributes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_items');
    }
};
