<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$user = User::first();
echo "Usuario: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";
echo "Tiene super_admin: " . ($user->hasRole('super_admin') ? 'SI' : 'NO') . "\n";
echo "Can create users: " . (\App\Filament\Resources\Users\UserResource::canCreate() ? 'SI' : 'NO') . "\n";
