<?php

namespace App\Filament\Resources\Permisos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermisosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('guard_name')
                    ->required(),
            ]);
    }
}
