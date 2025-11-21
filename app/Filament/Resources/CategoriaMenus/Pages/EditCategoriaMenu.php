<?php

namespace App\Filament\Resources\CategoriaMenus\Pages;

use App\Filament\Resources\CategoriaMenus\CategoriaMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoriaMenu extends EditRecord
{
    protected static string $resource = CategoriaMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
