<?php

namespace App\Filament\Resources\Platos;

use App\Filament\Resources\Platos\Pages\CreatePlato;
use App\Filament\Resources\Platos\Pages\EditPlato;
use App\Filament\Resources\Platos\Pages\ListPlatos;
use App\Filament\Resources\Platos\Pages\ViewPlato;
use App\Filament\Resources\Platos\Schemas\PlatoForm;
use App\Filament\Resources\Platos\Schemas\PlatoInfolist;
use App\Filament\Resources\Platos\Tables\PlatosTable;
use App\Models\Plato;
use App\Traits\HasResourceAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PlatoResource extends Resource
{
    use HasResourceAuthorization;
    protected static array $allowedRoles = ['super_admin', 'administrador', 'gestion_cocina'];

    protected static ?string $model = Plato::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static UnitEnum|string|null $navigationGroup = 'Menus';

    protected static ?string $modelLabel = 'Plato';

    protected static ?string $pluralModelLabel = 'Platos';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlatoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlatoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlatosTable::configure($table);
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
            'index' => ListPlatos::route('/'),
            'create' => CreatePlato::route('/create'),
            'view' => ViewPlato::route('/{record}'),
            'edit' => EditPlato::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
