<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosGranularesSeeder extends Seeder
{
    public function run(): void
    {
        // Permisos globales simples
        $permisos = ['ver', 'editar', 'eliminar'];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(
                ['name' => $permiso, 'guard_name' => 'web']
            );
        }

        $this->command->info('✅ Permisos globales creados: ver, editar, eliminar');
    }
}
