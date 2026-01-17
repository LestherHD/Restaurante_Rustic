<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse que existan los roles primero
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@rustic.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Asignar roles
        $admin->syncRoles(['super_admin', 'administrador']);

        $this->command->info('✅ Usuario administrador creado/actualizado con roles: super_admin, administrador');
    }
}
