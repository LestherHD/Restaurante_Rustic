<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesFuncionalesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles funcionales para el restaurante
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'descripcion' => 'Acceso total al sistema'
            ],
            [
                'name' => 'administrador',
                'guard_name' => 'web',
                'descripcion' => 'Gestión general del restaurante'
            ],
            [
                'name' => 'manejo_inventario',
                'guard_name' => 'web',
                'descripcion' => 'Gestión de bebidas, ingredientes, unidades de medida y movimientos de inventario'
            ],
            [
                'name' => 'gestion_cocina',
                'guard_name' => 'web',
                'descripcion' => 'Gestión de platos, recetas, categorías de menú y subrecetas'
            ],
            [
                'name' => 'mesero',
                'guard_name' => 'web',
                'descripcion' => 'Ver menú, crear pedidos'
            ],
            [
                'name' => 'cocinero',
                'guard_name' => 'web',
                'descripcion' => 'Ver pedidos y recetas'
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']]
            );
        }

        $this->command->info('✅ Roles funcionales creados correctamente');
    }
}
