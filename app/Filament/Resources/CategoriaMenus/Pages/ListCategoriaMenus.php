<?php

namespace App\Filament\Resources\CategoriaMenus\Pages;

use App\Filament\Resources\CategoriaMenus\CategoriaMenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoriaMenus extends ListRecords
{
    protected static string $resource = CategoriaMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
