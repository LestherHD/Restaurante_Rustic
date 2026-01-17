<?php

namespace App\Filament\Resources\Recetas\Tables;

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

class RecetasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Subreceta')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('version')
                    ->label('V.')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                
                TextColumn::make('detalles_count')
                    ->label('Ingredientes')
                    ->counts('detalles')
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('costo_total')
                    ->label('Costo Total')
                    ->money('USD')
                    ->getStateUsing(function ($record) {
                        $total = 0;
                        foreach ($record->detalles as $detalle) {
                            if ($detalle->ingrediente) {
                                $total += $detalle->cantidad * $detalle->ingrediente->costo_unitario;
                            }
                        }
                        return $total;
                    })
                    ->sortable(),
                
                IconColumn::make('estado')
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
                    ForceDeleteBulkAction::make()
                        ->label('Eliminar permanentemente'),
                    RestoreBulkAction::make()
                        ->label('Restaurar seleccionados'),
                ]),
            ])
            ->defaultSort('nombre', 'asc');
    }
}
