<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\emprendedore;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class emprendedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    DB::table('emprendedores')->insert([
        'usuario_id' => 1,
        'nombre_marca' => 'Moda Salas'
    ]);

    DB::table('emprendedores')->insert([
        'usuario_id' => 4,
        'nombre_marca' => 'Ropa Torres'
    ]);

    $dato = new emprendedore();
    $dato->usuario_id = 1;
    $dato->nombre_marca = 'Moda Salas';
    $dato->save();

    $dato2 = new emprendedore();
    $dato2->usuario_id = 4;
    $dato2->nombre_marca = 'Ropa Torres';
    $dato2->save();
}
}