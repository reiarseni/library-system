<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador para acceso al sistema
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Crear un usuario normal para pruebas
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'user@biblioteca.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);

        // Crear usuarios adicionales para pruebas (todos con rol 'user')
        User::factory()->count(8)->create([
            'role' => 'user',
        ]);
    }
}