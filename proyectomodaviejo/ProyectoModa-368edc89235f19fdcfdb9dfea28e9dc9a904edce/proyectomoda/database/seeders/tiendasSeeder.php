<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\tienda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class tiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tiendas')->insert([
            'emprendedor_id' => 1,
            'nombre' => 'Moda Salas',
            'logo' => 'logo1.png',
            'descripcion' => 'Tienda de ropa',
            'categoria' => 'Ropa'
        ]);

        DB::table('tiendas')->insert([
            'emprendedor_id' => 2,
            'nombre' => 'Torres Store',
            'logo' => 'logo2.png',
            'descripcion' => 'Tienda deportiva',
            'categoria' => 'Deportes'
        ]);

        $dato = new tienda();
        $dato->emprendedor_id = 3;
        $dato->nombre = 'Moda Salas';
        $dato->logo = 'logo1.png';
        $dato->descripcion = 'Tienda de ropa';
        $dato->categoria = 'Ropa';
        $dato->save();

        $dato2 = new tienda();
        $dato2->emprendedor_id = 4;
        $dato2->nombre = 'Torres Store';
        $dato2->logo = 'logo2.png';
        $dato2->descripcion = 'Tienda deportiva';
        $dato2->categoria = 'Deportes';
        $dato2->save();
    }
}