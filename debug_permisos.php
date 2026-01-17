<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

$user = User::where('email', 'inve@correo.com')->first();

if (!$user) {
    echo "Usuario no encontrado\n";
    exit;
}

echo "=== Usuario: {$user->name} ===\n\n";

echo "Módulos asignados en BD:\n";
$modules = DB::table('user_modules')->where('user_id', $user->id)->get();
foreach ($modules as $mod) {
    echo "  - {$mod->module}\n";
}

echo "\nPermisos asignados:\n";
$permisos = $user->permissions;
foreach ($permisos as $perm) {
    echo "  - {$perm->name}\n";
}

echo "\n=== Testing BebidaResource ===\n";
$bebidaResourceClass = 'App\\Filament\\Resources\\Bebidas\\BebidaResource';
preg_match('/Resources\\\\([^\\\\]+)\\\\/', $bebidaResourceClass, $matches);
echo "Namespace completo: " . $bebidaResourceClass . "\n";
echo "Match encontrado: " . ($matches[1] ?? 'NINGUNO') . "\n";
$slug = isset($matches[1]) ? strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $matches[1])) : 'ERROR';
echo "Slug detectado: " . $slug . "\n";

echo "\n=== Testing MovimientoInventarioResource ===\n";
$movimientoResourceClass = 'App\\Filament\\Resources\\MovimientoInventarios\\MovimientoInventarioResource';
preg_match('/Resources\\\\([^\\\\]+)\\\\/', $movimientoResourceClass, $matches2);
echo "Namespace completo: " . $movimientoResourceClass . "\n";
echo "Match encontrado: " . ($matches2[1] ?? 'NINGUNO') . "\n";
$slug2 = isset($matches2[1]) ? strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $matches2[1])) : 'ERROR';
echo "Slug detectado: " . $slug2 . "\n";

echo "\nUsuario tiene módulo 'bebidas'? " . ($user->hasModule('bebidas') ? 'SI' : 'NO') . "\n";
echo "Usuario tiene módulo 'movimiento-inventarios'? " . ($user->hasModule('movimiento-inventarios') ? 'SI' : 'NO') . "\n";
echo "Usuario tiene permiso 'ver'? " . ($user->hasPermissionTo('ver') ? 'SI' : 'NO') . "\n";
