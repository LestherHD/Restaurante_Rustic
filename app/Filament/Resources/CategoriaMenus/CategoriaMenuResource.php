<?php

namespace App\Filament\Resources\CategoriaMenus;

use App\Filament\Resources\CategoriaMenus\Pages\CreateCategoriaMenu;
use App\Filament\Resources\CategoriaMenus\Pages\EditCategoriaMenu;
use App\Filament\Resources\CategoriaMenus\Pages\ListCategoriaMenus;
use App\Filament\Resources\CategoriaMenus\Schemas\CategoriaMenuForm;
use App\Filament\Resources\CategoriaMenus\Tables\CategoriaMenusTable;
use App\Models\CategoriaMenu;
use App\Traits\HasResourceAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CategoriaMenuResource extends Resource
{
    use HasResourceAuthorization;
    protected static array $allowedRoles = ['super_admin', 'administrador', 'gestion_cocina'];

    protected static ?string $model = CategoriaMenu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static  UnitEnum|string|null $navigationGroup = 'Menus';

    public static function form(Schema $schema): Schema
    {
        return CategoriaMenuForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriaMenusTable::configure($table);
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
            'index' => ListCategoriaMenus::route('/'),
            'create' => CreateCategoriaMenu::route('/create'),
            'edit' => EditCategoriaMenu::route('/{record}/edit'),
        ];
    }
}
