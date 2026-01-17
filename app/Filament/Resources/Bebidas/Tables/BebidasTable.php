<?php

namespace App\Filament\Resources\Bebidas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BebidasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-bebida.png')),
                
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('marca')
                    ->label('Marca')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('presentacion')
                    ->label('Presentacion')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('stock_display')
                    ->label('Stock')
                    ->state(function ($record) {
                        $empaques = $record->empaques_completos;
                        $sueltas = $record->unidades_sueltas;
                        $total = $record->stock_actual;
                        
                        if ($empaques > 0 && $sueltas > 0) {
                            return "{$empaques} cajas + {$sueltas} un. ({$total} total)";
                        } elseif ($empaques > 0) {
                            return "{$empaques} cajas ({$total} un.)";
                        } else {
                            return "{$total} unidades";
                        }
                    })
                    ->badge()
                    ->color(fn ($record) => $record->tieneStockBajo() ? 'danger' : 'success'),
                
                IconColumn::make('stock_status')
                    ->label('Alerta')
                    ->boolean()
                    ->state(fn ($record) => !$record->tieneStockBajo())
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('costo_unitario')
                    ->label('Costo')
                    ->money('USD')
                    ->sortable(),
                
                TextColumn::make('precio_venta')
                    ->label('Precio Venta')
                    ->money('USD')
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('margen_ganancia')
                    ->label('Margen')
                    ->suffix('%')
                    ->numeric(2)
                    ->sortable()
                    ->color(fn ($state) => $state > 50 ? 'success' : ($state > 30 ? 'warning' : 'danger'))
                    ->toggleable(),
                
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('nombre', 'asc');
    }
}
