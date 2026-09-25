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
        Schema::table('game_codes', function (Blueprint $table) {
            $table->enum('status', ['disponible', 'usado', 'vencido'])->default('disponible')->after('used');
            $table->timestamp('used_at')->nullable()->after('status');
            $table->string('batch')->nullable()->after('used_at');

            // Índices para mejorar rendimiento
            $table->index('status');
            $table->index('batch');
            $table->index('used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_codes', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['batch']);
            $table->dropIndex(['used_at']);
            $table->dropColumn(['status', 'used_at', 'batch']);
        });
    }
};
