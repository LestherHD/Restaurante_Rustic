<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Estructura de user_modules ===\n";
$columns = DB::select("DESCRIBE user_modules");
foreach ($columns as $col) {
    echo "{$col->Field} - {$col->Type}\n";
}

echo "\n=== Limpiar permisos viejos ===\n";
DB::table('permissions')->truncate();
echo "Permisos eliminados\n";

echo "\n=== Crear permisos simples ===\n";
$permisos = ['ver', 'editar', 'eliminar'];
foreach ($permisos as $permiso) {
    DB::table('permissions')->insert([
        'name' => $permiso,
        'guard_name' => 'web',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "✅ {$permiso}\n";
}

echo "\n=== Limpiar role_has_permissions ===\n";
DB::table('role_has_permissions')->truncate();
echo "Relaciones limpiadas\n";

echo "\nListo! Ahora recarga el navegador\n";
