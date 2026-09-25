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
        Schema::table('user_purchases', function (Blueprint $table) {
            // Hacer video_game_id nullable ya que ahora puede ser marketplace o streaming
            $table->foreignId('video_game_id')->nullable()->change();

            // Agregar relaciones para marketplace y streaming
            $table->foreignId('market_item_id')
                ->nullable()
                ->constrained('market_items')
                ->onDelete('cascade');

            $table->foreignId('streaming_code_id')
                ->nullable()
                ->constrained('streaming_codes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_purchases', function (Blueprint $table) {
            $table->dropForeign(['market_item_id']);
            $table->dropForeign(['streaming_code_id']);
            $table->dropColumn(['market_item_id', 'streaming_code_id']);

            // Revertir video_game_id a no nullable
            $table->foreignId('video_game_id')->nullable(false)->change();
        });
    }
};
