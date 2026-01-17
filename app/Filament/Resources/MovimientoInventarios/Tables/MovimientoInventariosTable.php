<?php

namespace App\Filament\Resources\MovimientoInventarios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MovimientoInventariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha_movimiento')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                
                TextColumn::make('inventariable_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => $state === 'App\\Models\\Bebida' ? 'Bebida' : 'Ingrediente')
                    ->badge()
                    ->color(fn ($state) => $state === 'App\\Models\\Bebida' ? 'info' : 'success'),
                
                TextColumn::make('inventariable.nombre')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('tipo_movimiento')
                    ->label('Movimiento')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'entrada' => 'success',
                        'salida' => 'danger',
                        'ajuste' => 'warning',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                
                TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->numeric(2)
                    ->suffix(' un.')
                    ->color(fn ($record) => $record->tipo_movimiento === 'entrada' ? 'success' : 'danger')
                    ->weight('bold'),
                
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->searchable()
                    ->wrap(),
                
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->toggleable()
                    ->default('Sistema'),
                
                TextColumn::make('comentario')
                    ->label('Comentario')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipo_movimiento')
                    ->label('Tipo de Movimiento')
                    ->options([
                        'entrada' => 'Entrada',
                        'salida' => 'Salida',
                        'ajuste' => 'Ajuste',
                    ]),
                
                SelectFilter::make('inventariable_type')
                    ->label('Tipo de Producto')
                    ->options([
                        'App\\Models\\Bebida' => 'Bebidas',
                        'App\\Models\\Ingrediente' => 'Ingredientes',
                    ]),
                
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
            ->defaultSort('fecha_movimiento', 'desc');
    }
}
