<?php

namespace App\Filament\Resources\Bebidas\Pages;

use App\Filament\Resources\Bebidas\BebidaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBebidas extends ListRecords
{
    protected static string $resource = BebidaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
