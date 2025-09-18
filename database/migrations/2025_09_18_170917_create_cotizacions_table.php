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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->string('moneda_origen')->default('USD');
            $table->string('moneda_destino')->default('ARS');
            $table->decimal('tasa', 15, 4); // Ejemplo: 1 USD = 950.2500 ARS
            $table->json('respuesta_completa')->nullable(); // Guarda el JSON completo de la API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
