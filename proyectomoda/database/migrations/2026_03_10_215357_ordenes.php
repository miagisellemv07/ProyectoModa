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
        Schema::create('ordenes', function (Blueprint $table) {

    $table->id();
    $table->foreignId('cliente_id')->references('id')->on('clientes');
    $table->string('numero_orden');
    $table->string('estado');
    $table->decimal('total',10,2);
    $table->string('direccion_envio');
    $table->string('telefono');
    $table->text('notas');
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
