<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\cliente;
use Illuminate\Support\Facades\DB;/*conexion*/
use Illuminate\Support\Facades\Hash;/*conexion*/

class clientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    DB::table('clientes')->insert([
        'usuario_id' => 2,
        'direccion' => 'Av Tecnologico'
    ]);

    DB::table('clientes')->insert([
        'usuario_id' => 3,
        'direccion' => 'Av Juarez'
    ]);

    $dato = new cliente();
    $dato->usuario_id = 2;
    $dato->direccion = 'Av Tecnologico';
    $dato->save();

    $dato2 = new cliente();
    $dato2->usuario_id = 3;
    $dato2->direccion = 'Av Juarez';
    $dato2->save();
}
    }

