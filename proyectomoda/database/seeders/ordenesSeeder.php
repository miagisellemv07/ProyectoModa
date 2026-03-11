<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ordene;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class ordenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
/**
 * Run the database seeds.
 */
public function run(): void
{
    DB::table('ordenes')->insert([
        'cliente_id' => 1,
        'numero_orden' => 'ORD001',
        'estado' => 'pendiente',
        'total' => 799.98,
        'direccion_envio' => 'Av Tecnologico',
        'telefono' => '6561234567',
        'notas' => 'Entrega rápida'
    ]);

    DB::table('ordenes')->insert([
        'cliente_id' => 1,
        'numero_orden' => 'ORD002',
        'estado' => 'pagado',
        'total' => 199.99,
        'direccion_envio' => 'Av Juarez',
        'telefono' => '6569876543',
        'notas' => 'Sin comentarios'
    ]);

    $dato = new ordene();
    $dato->cliente_id = 1;
    $dato->numero_orden = 'ORD003';
    $dato->estado = 'pendiente';
    $dato->total = 399.99;
    $dato->direccion_envio = 'Av Tecnologico';
    $dato->telefono = '6561234567';
    $dato->notas = 'Entrega rápida';
    $dato->save();

    $dato2 = new ordene();
    $dato2->cliente_id = 1;
    $dato2->numero_orden = 'ORD004';
    $dato2->estado = 'pagado';
    $dato2->total = 199.99;
    $dato2->direccion_envio = 'Av Juarez';
    $dato2->telefono = '6569876543';
    $dato2->notas = 'Sin comentarios';
    $dato2->save();
}
}
