<?php

namespace App\Filament\Resources\Platos\Schemas;

use App\Models\Plato;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PlatoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('descripcion')
                    ->columnSpanFull(),
                TextEntry::make('precio_venta')
                    ->numeric(),
                TextEntry::make('costo_produccion')
                    ->numeric(),
                IconEntry::make('visible_en_menu')
                    ->boolean(),
                TextEntry::make('categoria_id')
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
                    ->visible(fn (Plato $record): bool => $record->trashed()),
            ]);
    }
}
