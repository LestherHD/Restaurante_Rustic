<?php

namespace App\Filament\Resources\Bebidas\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BebidaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Coca Cola')
                    ->columnSpan(2),
                
                TextInput::make('marca')
                    ->label('Marca')
                    ->maxLength(255)
                    ->placeholder('Coca Cola')
                    ->columnSpan(1),
                
                TextInput::make('presentacion')
                    ->label('Presentacion')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Lata 355ml')
                    ->columnSpan(1),
                
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->directory('bebidas')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames(false) // Hashea nombres para evitar conflictos
                    ->columnSpan(2),
                
                TextInput::make('unidades_por_empaque')
                    ->label('Unidades por Empaque')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->suffix('unidades')
                    ->helperText('Cuantas unidades trae cada caja o paquete')
                    ->columnSpan(1),
                
                TextInput::make('stock_actual')
                    ->label('Stock Actual')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->suffix('unidades')
                    ->columnSpan(1),
                
                TextInput::make('stock_minimo')
                    ->label('Stock Minimo')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->suffix('unidades')
                    ->helperText('Alerta cuando el stock baje de este nivel')
                    ->columnSpan(1),
                
                TextInput::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0)
                    ->helperText('Costo por unidad individual')
                    ->columnSpan(1),
                
                TextInput::make('precio_venta')
                    ->label('Precio de Venta')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0)
                    ->helperText('Precio al publico')
                    ->columnSpan(1),
                
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}
