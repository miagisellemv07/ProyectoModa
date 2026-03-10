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
        Schema::create('ordenitems', function (Blueprint $table) {

    $table->id();
    $table->foreignId('orden_id')->references('id')->on('ordenes');
    $table->foreignId('producto_id')->references('id')->on('productos');
    $table->foreignId('tienda_id')->references('id')->on('tiendas');
    $table->integer('cantidad');
    $table->decimal('precio_unitario',10,2);
    $table->decimal('subtotal',10,2);
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
