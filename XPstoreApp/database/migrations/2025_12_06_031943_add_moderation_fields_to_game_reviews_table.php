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
        Schema::table('game_reviews', function (Blueprint $table) {
            $table->enum('status', ['pendiente', 'aprobada', 'rechazada'])->default('aprobada')->after('is_verified_purchase');
            $table->enum('rejection_reason', ['lenguaje_ofensivo', 'spam', 'contenido_no_relacionado', 'insultos', 'otro'])->nullable()->after('status');
            $table->text('moderation_note')->nullable()->after('rejection_reason');
            $table->timestamp('moderated_at')->nullable()->after('moderation_note');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->onDelete('set null')->after('moderated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_reviews', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'moderation_note', 'moderated_at', 'moderated_by']);
        });
    }
};
