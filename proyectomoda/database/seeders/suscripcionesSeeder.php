<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\suscripcione;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class suscripcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('suscripciones')->insert([
        'emprendedor_id' => 1,
        'precio_mensual' => 199.99,
        'fecha_inicio' => '2025-01-01',
        'fecha_fin' => '2025-02-01',
        'estado' => 'activo'
    ]);

    DB::table('suscripciones')->insert([
        'emprendedor_id' => 2,
        'precio_mensual' => 199.99,
        'fecha_inicio' => '2025-02-01',
        'fecha_fin' => '2025-03-01',
        'estado' => 'activo'
    ]);

    $dato = new suscripcione();
    $dato->emprendedor_id = 1;
    $dato->precio_mensual = 199.99;
    $dato->fecha_inicio = '2025-01-01';
    $dato->fecha_fin = '2025-02-01';
    $dato->estado = 'activo';
    $dato->save();

    $dato2 = new suscripcione();
    $dato2->emprendedor_id = 2;
    $dato2->precio_mensual = 199.99;
    $dato2->fecha_inicio = '2025-02-01';
    $dato2->fecha_fin = '2025-03-01';
    $dato2->estado = 'activo';
    $dato2->save();
}
}
