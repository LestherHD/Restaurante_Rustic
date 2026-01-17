<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\UserModule;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cargar módulos asignados
        $data['user_modules'] = $this->record->modules->pluck('module')->toArray();
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Eliminar módulos anteriores
        $this->record->modules()->delete();
        
        // Guardar nuevos módulos
        $modules = $this->data['user_modules'] ?? [];
        
        foreach ($modules as $module) {
            UserModule::create([
                'user_id' => $this->record->id,
                'module' => $module,
            ]);
        }
    }
}
