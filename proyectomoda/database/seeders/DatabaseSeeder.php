<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call(usersSeeder::class);
        $this->call(emprendedoresSeeder::class);
        $this->call(clientesSeeder::class);
        $this->call(suscripcionesSeeder::class);
        $this->call(pagosuscripcionesSeeder::class);
        $this->call(tiendasSeeder::class);
        $this->call(productosSeeder::class);
        $this->call(carritosSeeder::class);
        $this->call(ordenesSeeder::class);
        $this->call(ordenitemsSeeder::class);
        $this->call(pagoordenesSeeder::class);
    }
}
