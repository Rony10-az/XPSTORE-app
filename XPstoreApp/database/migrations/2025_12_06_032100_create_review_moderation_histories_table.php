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
        Schema::create('review_moderation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_review_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('action', ['aprobar', 'rechazar', 'editar', 'ocultar'])->comment('Acción realizada');
            $table->enum('previous_status', ['pendiente', 'aprobada', 'rechazada'])->nullable();
            $table->enum('new_status', ['pendiente', 'aprobada', 'rechazada'])->nullable();
            $table->string('rejection_reason')->nullable()->comment('Motivo de rechazo si aplica');
            $table->text('note')->nullable()->comment('Nota del admin sobre la acción');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_moderation_histories');
    }
};
