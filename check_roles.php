<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Contenido de model_has_roles ===\n";
$roles = DB::table('model_has_roles')->get();

if ($roles->isEmpty()) {
    echo "⚠️ VACÍA - No hay roles asignados!\n\n";
} else {
    foreach ($roles as $role) {
        echo "Role ID: {$role->role_id} -> Model: {$role->model_type} (ID: {$role->model_id})\n";
    }
}

echo "\n=== Roles disponibles ===\n";
$allRoles = DB::table('roles')->get();
foreach ($allRoles as $r) {
    echo "ID: {$r->id} - Nombre: {$r->name}\n";
}

echo "\n=== Usuario Administrador ===\n";
$user = \App\Models\User::first();
echo "ID: {$user->id}\n";
echo "Nombre: {$user->name}\n";
echo "Roles asignados: " . $user->roles->pluck('name')->implode(', ') . "\n";
