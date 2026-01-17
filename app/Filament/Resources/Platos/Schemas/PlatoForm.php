<?php

namespace App\Filament\Resources\Platos\Schemas;

use App\Models\CategoriaMenu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlatoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Plato')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Ej: Skillet El Rey, Crema de Jalapeno')
                    ->columnSpan(2),
                
                Select::make('categoria_id')
                    ->label('Categoria')
                    ->relationship('categoria', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(100),
                        Toggle::make('visible_publico')
                            ->label('Visible al publico')
                            ->default(true),
                    ])
                    ->columnSpan(1),
                
                Textarea::make('descripcion')
                    ->label('Descripcion')
                    ->required()
                    ->rows(3)
                    ->placeholder('Describe los ingredientes principales y caracteristicas del plato')
                    ->columnSpanFull(),
                
                TextInput::make('precio_venta')
                    ->label('Precio de Venta')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->columnSpan(1),
                
                TextInput::make('costo_produccion')
                    ->label('Costo de Produccion')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Se calcula automaticamente desde la receta')
                    ->columnSpan(1),
                
                Toggle::make('visible_en_menu')
                    ->label('Visible en Menu Publico')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
                
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
