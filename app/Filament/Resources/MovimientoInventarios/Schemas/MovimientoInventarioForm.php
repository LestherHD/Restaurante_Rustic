<?php

namespace App\Filament\Resources\MovimientoInventarios\Schemas;

use App\Models\Bebida;
use App\Models\Ingrediente;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MovimientoInventarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('inventariable')
                    ->label('Producto')
                    ->types([
                        MorphToSelect\Type::make(Bebida::class)
                            ->titleAttribute('nombre')
                            ->label('Bebida'),
                        MorphToSelect\Type::make(Ingrediente::class)
                            ->titleAttribute('nombre')
                            ->label('Ingrediente'),
                    ])
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->columnSpan(2),
                
                // Campo para ingresar cajas (solo visible para Bebidas)
                TextInput::make('cantidad_cajas')
                    ->label('Cantidad de Cajas/Empaques')
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->dehydrated()
                    ->suffix(function ($get) {
                        $bebidaId = $get('inventariable_id');
                        if ($bebidaId) {
                            $bebida = Bebida::find($bebidaId);
                            if ($bebida) {
                                return "cajas ({$bebida->unidades_por_empaque} un. c/u)";
                            }
                        }
                        return 'cajas';
                    })
                    ->helperText(function ($get) {
                        $cajas = $get('cantidad_cajas');
                        $bebidaId = $get('inventariable_id');
                        if ($cajas && $bebidaId) {
                            $bebida = Bebida::find($bebidaId);
                            if ($bebida) {
                                $total = $cajas * $bebida->unidades_por_empaque;
                                return "= {$total} unidades totales";
                            }
                        }
                        return null;
                    })
                    ->visible(fn ($get) => 
                        $get('inventariable_type') === 'App\\Models\\Bebida'
                    )
                    ->required(fn ($get) => 
                        $get('inventariable_type') === 'App\\Models\\Bebida'
                    )
                    ->columnSpan(2),
                
                Select::make('tipo_movimiento')
                    ->label('Tipo de Movimiento')
                    ->options([
                        'entrada' => 'Entrada',
                        'salida' => 'Salida',
                        'ajuste' => 'Ajuste',
                    ])
                    ->required()
                    ->live()
                    ->columnSpan(1),
                
                // Campo para cantidad (visible solo para ingredientes, oculto para bebidas)
                TextInput::make('cantidad')
                    ->label(function ($get) {
                        $tipo = $get('inventariable_type');
                        $id = $get('inventariable_id');
                        
                        if ($tipo && $id && $tipo === 'App\\Models\\Ingrediente') {
                            $producto = Ingrediente::with('unidadMedida')->find($id);
                            if ($producto && $producto->unidadMedida) {
                                return "Cantidad ({$producto->unidadMedida->abreviatura})";
                            }
                        }
                        return 'Cantidad';
                    })
                    ->required(fn ($get) => $get('inventariable_type') === 'App\\Models\\Ingrediente')
                    ->numeric()
                    ->minValue(0.01)
                    ->step(0.01)
                    ->suffix(function ($get) {
                        $tipo = $get('inventariable_type');
                        $id = $get('inventariable_id');
                        
                        if ($tipo && $id && $tipo === 'App\\Models\\Ingrediente') {
                            $ingrediente = Ingrediente::with('unidadMedida')->find($id);
                            if ($ingrediente && $ingrediente->unidadMedida) {
                                return $ingrediente->unidadMedida->abreviatura;
                            }
                        }
                        return '';
                    })
                    ->visible(fn ($get) => $get('inventariable_type') === 'App\\Models\\Ingrediente')
                    ->columnSpan(2),
                
                Select::make('motivo')
                    ->label('Motivo')
                    ->options(function ($get) {
                        $tipo = $get('tipo_movimiento');
                        
                        if ($tipo === 'entrada') {
                            return [
                                'Compra' => 'Compra',
                                'Devolucion' => 'Devolucion',
                                'Donacion' => 'Donacion',
                            ];
                        } elseif ($tipo === 'salida') {
                            return [
                                'Venta' => 'Venta',
                                'Merma' => 'Merma',
                                'Robo' => 'Robo',
                                'Caducidad' => 'Caducidad',
                            ];
                        } else {
                            return [
                                'Correccion inventario' => 'Correccion inventario',
                                'Error registro' => 'Error registro',
                            ];
                        }
                    })
                    ->required()
                    ->columnSpan(1),
                
                DatePicker::make('fecha_movimiento')
                    ->label('Fecha del Movimiento')
                    ->required()
                    ->default(now())
                    ->maxDate(now())
                    ->columnSpan(1),
                
                Textarea::make('comentario')
                    ->label('Comentario')
                    ->rows(3)
                    ->placeholder('Detalles adicionales del movimiento...')
                    ->columnSpan(2),
            ])
            ->columns(2);
    }
}
