<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ordenitem;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/
class ordenitemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('ordenitems')->insert([
        'orden_id' => 1,
        'producto_id' => 1,
        'tienda_id' => 1,
        'cantidad' => 2,
        'precio_unitario' => 399.99,
        'subtotal' => 799.98
    ]);

    DB::table('ordenitems')->insert([
        'orden_id' => 2,
        'producto_id' => 2,
        'tienda_id' => 2,
        'cantidad' => 1,
        'precio_unitario' => 199.99,
        'subtotal' => 199.99
    ]);

    $dato = new ordenitem();
    $dato->orden_id = 1;
    $dato->producto_id = 1;
    $dato->tienda_id = 1;
    $dato->cantidad = 1;
    $dato->precio_unitario = 399.99;
    $dato->subtotal = 399.99;
    $dato->save();

    $dato2 = new ordenitem();
    $dato2->orden_id = 2;
    $dato2->producto_id = 2;
    $dato2->tienda_id = 2;
    $dato2->cantidad = 2;
    $dato2->precio_unitario = 199.99;
    $dato2->subtotal = 399.98;
    $dato2->save();
}
}
