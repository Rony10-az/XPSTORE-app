<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar el ENUM de la columna 'action' para incluir 'marcar_pendiente'
        DB::statement("ALTER TABLE `review_moderation_histories` MODIFY COLUMN `action` ENUM('aprobar', 'rechazar', 'editar', 'ocultar', 'marcar_pendiente') NOT NULL COMMENT 'Acción realizada'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el ENUM a los valores originales
        DB::statement("ALTER TABLE `review_moderation_histories` MODIFY COLUMN `action` ENUM('aprobar', 'rechazar', 'editar', 'ocultar') NOT NULL COMMENT 'Acción realizada'");
    }
};
