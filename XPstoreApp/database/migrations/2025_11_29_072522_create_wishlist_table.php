<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();

            // Usuario dueño del wishlist
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            /**
             * UNIVERSAL ITEM:
             * - "item_id": ID del producto (videojuego, marketplace, streaming)
             * - "item_type": tipo del producto
             *   ej: "video_game", "market_item", "streaming_code"
             */
            $table->unsignedBigInteger('item_id');
            $table->string('item_type');  // video_game | market_item | streaming_code

            // Evita duplicados por usuario + item
            $table->unique(['user_id', 'item_id', 'item_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
