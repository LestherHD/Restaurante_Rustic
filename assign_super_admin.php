<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

$user = User::first();
$role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
$user->assignRole($role);

echo "✅ Usuario '{$user->name}' ahora es super_admin\n";
echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
