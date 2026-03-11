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
        Schema::create('pagosuscripciones', function (Blueprint $table) {

    $table->id();
    $table->foreignId('suscripcion_id')->references('id')->on('suscripciones');
    $table->decimal('monto',10,2);
    $table->enum('metodo_pago',['efectivo','transferencia']);
    $table->date('fecha_pago');
    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
