<?php

namespace App\Filament\Resources\Ingredientes\Schemas;

use App\Models\Ingrediente;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IngredienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('unidad_medida_id')
                    ->numeric(),
                TextEntry::make('stock_actual')
                    ->numeric(),
                TextEntry::make('stock_minimo')
                    ->numeric(),
                TextEntry::make('costo_unitario')
                    ->numeric(),
                IconEntry::make('activo')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Ingrediente $record): bool => $record->trashed()),
            ]);
    }
}
