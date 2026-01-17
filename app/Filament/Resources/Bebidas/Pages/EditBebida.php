<?php

namespace App\Filament\Resources\Bebidas\Pages;

use App\Filament\Resources\Bebidas\BebidaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditBebida extends EditRecord
{
    protected static string $resource = BebidaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
