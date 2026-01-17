<?php

namespace App\Filament\Resources\Ingredientes\Schemas;

use App\Models\UnidadMedida;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IngredienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Ingrediente')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Ej: Lechuga, Tomate, Carne de res'),
                
                Select::make('unidad_medida_id')
                    ->label('Unidad de Medida')
                    ->relationship('unidadMedida', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('abreviatura')
                            ->required()
                            ->maxLength(10),
                    ]),
                
                TextInput::make('stock_actual')
                    ->label('Stock Actual')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->suffix('unidades')
                    ->minValue(0),
                
                TextInput::make('stock_minimo')
                    ->label('Stock Minimo')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->suffix('unidades')
                    ->minValue(0)
                    ->helperText('Cuando el stock actual sea igual o menor a este valor, se generara una alerta'),
                
                TextInput::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01),
                
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
