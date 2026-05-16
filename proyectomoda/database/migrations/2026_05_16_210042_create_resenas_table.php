<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('resenas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->cascadeOnDelete();

            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnDelete();

            $table->integer('calificacion');

            $table->text('comentario');

            $table->integer('puntos_ganados')
                  ->default(10);

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }

};