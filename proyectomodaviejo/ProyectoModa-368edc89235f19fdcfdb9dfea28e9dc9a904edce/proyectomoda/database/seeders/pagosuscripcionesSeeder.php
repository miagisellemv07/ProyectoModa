<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\pagosuscripcione;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class pagosuscripcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('pagosuscripciones')->insert([
        'suscripcion_id' => 1,
        'monto' => 199.99,
        'metodo_pago' => 'efectivo',
        'fecha_pago' => '2025-01-05'
    ]);

    DB::table('pagosuscripciones')->insert([
        'suscripcion_id' => 2,
        'monto' => 199.99,
        'metodo_pago' => 'transferencia',
        'fecha_pago' => '2025-02-05'
    ]);

    $dato = new pagosuscripcione();
    $dato->suscripcion_id = 1;
    $dato->monto = 199.99;
    $dato->metodo_pago = 'efectivo';
    $dato->fecha_pago = '2025-01-05';
    $dato->save();

    $dato2 = new pagosuscripcione();
    $dato2->suscripcion_id = 2;
    $dato2->monto = 199.99;
    $dato2->metodo_pago = 'transferencia';
    $dato2->fecha_pago = '2025-02-05';
    $dato2->save();
}
}
