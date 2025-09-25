<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder de usuarios (ya existente)
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 🔹 Seeder de cotizaciones
        $this->call([
            \Database\Seeders\CotizacionSeeder::class,
        ]);
    }
}
