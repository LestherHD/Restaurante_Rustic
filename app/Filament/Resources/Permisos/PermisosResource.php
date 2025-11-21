<?php

namespace App\Filament\Resources\Permisos;

use App\Filament\Resources\Permisos\Pages\CreatePermisos;
use App\Filament\Resources\Permisos\Pages\EditPermisos;
use App\Filament\Resources\Permisos\Pages\ListPermisos;
use App\Filament\Resources\Permisos\Schemas\PermisosForm;
use App\Filament\Resources\Permisos\Tables\PermisosTable;
use App\Models\Permisos;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PermisosResource extends Resource
{
    protected static ?string $model = Permisos::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static  UnitEnum|string|null $navigationGroup = 'Filament Shield';

    public static function form(Schema $schema): Schema
    {
        return PermisosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermisosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermisos::route('/'),
            'create' => CreatePermisos::route('/create'),
            'edit' => EditPermisos::route('/{record}/edit'),
        ];
    }
}
