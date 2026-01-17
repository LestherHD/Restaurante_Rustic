<?php

namespace App\Filament\Resources\Ingredientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class IngredientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Ingrediente')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('unidadMedida.nombre')
                    ->label('Unidad')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('stock_actual')
                    ->label('Stock Actual')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->tieneStockBajo() ? 'danger' : 'success')
                    ->icon(fn ($record) => $record->tieneStockBajo() ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle'),
                
                TextColumn::make('stock_minimo')
                    ->label('Stock Mínimo')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->money('USD')
                    ->sortable(),
                
                IconColumn::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('Eliminados'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Ver'),
                EditAction::make()
                    ->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
