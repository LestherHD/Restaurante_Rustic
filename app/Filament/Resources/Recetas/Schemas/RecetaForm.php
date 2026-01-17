<?php

namespace App\Filament\Resources\Recetas\Schemas;

use App\Models\Ingrediente;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class RecetaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la Subreceta')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Ej: Crema de Jalapeno, Salsa BBQ')
                    ->columnSpan(2),
                
                TextInput::make('version')
                    ->label('Version')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->columnSpan(1),
                
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->rows(3)
                    ->placeholder('Notas sobre la preparacion, tiempo de coccion, etc.')
                    ->columnSpan(3),
                
                Repeater::make('detalles')
                    ->label('Ingredientes')
                    ->relationship()
                    ->schema([
                        Select::make('ingrediente_id')
                            ->label('Ingrediente')
                            ->relationship('ingrediente', 'nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $ingrediente = Ingrediente::find($state);
                                if ($ingrediente) {
                                    $cantidad = $get('cantidad') ?? 0;
                                    $costo = $cantidad * $ingrediente->costo_unitario;
                                    $set('costo_calculado', $costo);
                                }
                            })
                            ->columnSpan(2),
                        
                        TextInput::make('cantidad')
                            ->label('Cantidad')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->step(0.01)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $ingrediente = Ingrediente::find($get('ingrediente_id'));
                                if ($ingrediente) {
                                    $costo = $state * $ingrediente->costo_unitario;
                                    $set('costo_calculado', $costo);
                                }
                            })
                            ->columnSpan(1),
                        
                        TextInput::make('costo_calculado')
                            ->label('Costo')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->prefix('$')
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->addActionLabel('Agregar ingrediente')
                    ->columnSpan(3)
                    ->live(),
                
                Placeholder::make('costo_total')
                    ->label('Costo Total de la Subreceta')
                    ->content(function ($get) {
                        $detalles = $get('detalles') ?? [];
                        $total = 0;
                        foreach ($detalles as $detalle) {
                            $ingrediente = Ingrediente::find($detalle['ingrediente_id'] ?? null);
                            $cantidad = $detalle['cantidad'] ?? 0;
                            $total += $cantidad * ($ingrediente?->costo_unitario ?? 0);
                        }
                        return '$' . number_format($total, 2);
                    })
                    ->columnSpan(2),
                
                Toggle::make('estado')
                    ->label('Activo')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
