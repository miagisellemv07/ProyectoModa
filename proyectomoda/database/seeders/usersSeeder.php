<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class usersSeeder extends Seeder
{
    public function run(): void
{
    DB::table('users')->insert([
        'nombre' => 'Alondra',
        'apellido' => 'Salas',
        'email' => 'alondra@gmail.com',
        'password' => '123456',
        'tel' => '6561234567',
        'rol' => 'emprendedor'
    ]);

    DB::table('users')->insert([
        'nombre' => 'Carlos',
        'apellido' => 'Ramirez',
        'email' => 'carlos@gmail.com',
        'password' => '123456',
        'tel' => '6561111111',
        'rol' => 'cliente'
    ]);

    
    $dato = new user();
    $dato->nombre = 'Mia';
    $dato->apellido = 'Minjarez';
    $dato->email = 'mia@gmail.com';
    $dato->password = '123456';
    $dato->tel = '6569876543';
    $dato->rol = 'cliente';
    $dato->save();

    $dato2 = new user();
    $dato2->nombre = 'Luis';
    $dato2->apellido = 'Torres';
    $dato2->email = 'luis@gmail.com';
    $dato2->password = '123456';
    $dato2->tel = '6562222222';
    $dato2->rol = 'emprendedor';
    $dato2->save();
}
}