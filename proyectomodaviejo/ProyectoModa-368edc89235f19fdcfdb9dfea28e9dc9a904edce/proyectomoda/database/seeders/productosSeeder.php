<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\producto;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class productosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('productos')->insert([
        'nombre' => 'Vestido',
        'descripcion' => 'Vestido elegante',
        'precio' => 399.99,
        'stock' => 20,
        'tienda_id' => 1
    ]);

    DB::table('productos')->insert([
        'nombre' => 'Playera',
        'descripcion' => 'Playera deportiva',
        'precio' => 199.99,
        'stock' => 30,
        'tienda_id' => 2
    ]);

    $dato = new producto();
    $dato->nombre = 'Vestido';
    $dato->descripcion = 'Vestido elegante';
    $dato->precio = 399.99;
    $dato->stock = 20;
    $dato->tienda_id = 1;
    $dato->save();

    $dato2 = new producto();
    $dato2->nombre = 'Playera';
    $dato2->descripcion = 'Playera deportiva';
    $dato2->precio = 199.99;
    $dato2->stock = 30;
    $dato2->tienda_id = 2;
    $dato2->save();
}
}
