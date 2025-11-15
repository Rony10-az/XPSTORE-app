<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('game_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_game_id')
                ->constrained('video_games')
                ->onDelete('cascade');
            $table->string('code')->unique();
            $table->boolean('used')->default(false); // si ya fue canjeado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_codes');
    }
};
