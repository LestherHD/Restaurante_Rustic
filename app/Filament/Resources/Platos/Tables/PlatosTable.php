<?php

namespace App\Filament\Resources\Platos\Tables;

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

class PlatosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Plato')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('precio_venta')
                    ->label('Precio Venta')
                    ->money('USD')
                    ->sortable(),
                
                TextColumn::make('costo_produccion')
                    ->label('Costo')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('margen')
                    ->label('Margen')
                    ->getStateUsing(fn ($record) => $record->precio_venta - $record->costo_produccion)
                    ->money('USD')
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->toggleable(),
                
                IconColumn::make('visible_en_menu')
                    ->label('Visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('gray'),
                
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
