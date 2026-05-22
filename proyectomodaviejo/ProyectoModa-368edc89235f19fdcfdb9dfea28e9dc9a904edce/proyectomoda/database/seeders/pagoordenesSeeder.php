<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\pagoordene;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class pagoordenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('pagoordenes')->insert([
        'orden_id' => 1,
        'monto' => 799.98,
        'metodo_pago' => 'efectivo',
        'estado' => 'pagado',
        'fecha_pago' => '2025-01-05'
    ]);

    DB::table('pagoordenes')->insert([
        'orden_id' => 2,
        'monto' => 199.99,
        'metodo_pago' => 'transferencia',
        'estado' => 'pagado',
        'fecha_pago' => '2025-01-06'
    ]);

    $dato = new pagoordene();
    $dato->orden_id = 1;
    $dato->monto = 799.98;
    $dato->metodo_pago = 'efectivo';
    $dato->estado = 'pagado';
    $dato->fecha_pago = '2025-01-05';
    $dato->save();

    $dato2 = new pagoordene();
    $dato2->orden_id = 2;
    $dato2->monto = 199.99;
    $dato2->metodo_pago = 'transferencia';
    $dato2->estado = 'pagado';
    $dato2->fecha_pago = '2025-01-06';
    $dato2->save();
}
}
