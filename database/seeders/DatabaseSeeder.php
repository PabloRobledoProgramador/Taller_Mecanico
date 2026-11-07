<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->mecanico()->create([
            'name' => 'Mecánico',
            'email' => 'mecanico@example.com',
        ]);

        User::factory()->create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
        ]);
    }
}
