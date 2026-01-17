<?php

namespace App\Filament\Resources\UnidadMedidas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnidadMedidaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Ej: Kilogramo, Litro, Unidad'),
                
                TextInput::make('abreviatura')
                    ->label('Abreviatura')
                    ->required()
                    ->maxLength(10)
                    ->placeholder('Ej: kg, L, u'),
                
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
