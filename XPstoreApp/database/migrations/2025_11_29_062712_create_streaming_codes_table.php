<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('streaming_codes', function (Blueprint $table) {
            $table->id();

            // Tipo de servicio (Netflix, HBO, Crunchyroll)
            $table->string('service');

            // Duración del plan (1 mes, 3 meses, 12 meses)
            $table->string('duration');

            // Código real que recibe el usuario
            $table->string('code')->unique();

            // Cantidad disponible
            $table->integer('stock')->default(0);

            // Precio de venta
            $table->decimal('price', 10, 2);

            // “is_active” para deshabilitar temporalmente
            $table->boolean('is_active')->default(true);

            // Imagen del servicio
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('streaming_codes');
    }


    /**
     * Reverse the migrations.
     */
};
