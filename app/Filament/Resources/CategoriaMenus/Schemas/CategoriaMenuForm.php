<?php

namespace App\Filament\Resources\CategoriaMenus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoriaMenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                Toggle::make('visible_publico')
                    ->required(),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
