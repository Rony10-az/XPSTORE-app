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
            // Hacer nullable el campo activation_code
            $table->string('activation_code')->nullable()->change();

            // Remover la restricción unique ya que puede haber múltiples null
            $table->dropUnique(['activation_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_purchases', function (Blueprint $table) {
            // Revertir a no nullable
            $table->string('activation_code')->nullable(false)->change();

            // Restaurar unique
            $table->unique('activation_code');
        });
    }
};
