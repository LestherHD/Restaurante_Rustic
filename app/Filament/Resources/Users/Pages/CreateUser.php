<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\UserModule;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        // Guardar módulos asignados
        $modules = $this->data['user_modules'] ?? [];
        
        foreach ($modules as $module) {
            UserModule::create([
                'user_id' => $this->record->id,
                'module' => $module,
            ]);
        }
    }
}
