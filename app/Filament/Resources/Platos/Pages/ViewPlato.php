<?php

namespace App\Filament\Resources\Platos\Pages;

use App\Filament\Resources\Platos\PlatoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlato extends ViewRecord
{
    protected static string $resource = PlatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
