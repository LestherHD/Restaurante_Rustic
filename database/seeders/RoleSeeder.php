<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Administrador',
            'description' => 'Usuario con todos los permisos y acceso completo al sistema.',
            'activo' => true,
        ]);
        Role::firstOrCreate([
            'name' => 'Mesero',
            'description' => 'Usuario con permisos limitados para tareas diarias.',
            'activo' => true,
        ]);
    }
}
