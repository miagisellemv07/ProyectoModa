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
        Schema::create('tiendas', function (Blueprint $table) {

    $table->id();
    $table->foreignId('emprendedor_id')->references('id')->on('emprendedores');
    $table->string('nombre');
    $table->string('logo');
    $table->text('descripcion');
    $table->string('categoria');
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
