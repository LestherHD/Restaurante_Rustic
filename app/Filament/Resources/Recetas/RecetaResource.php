<?php

namespace App\Filament\Resources\Recetas;

use App\Filament\Resources\Recetas\Pages\CreateReceta;
use App\Filament\Resources\Recetas\Pages\EditReceta;
use App\Filament\Resources\Recetas\Pages\ListRecetas;
use App\Filament\Resources\Recetas\Pages\ViewReceta;
use App\Filament\Resources\Recetas\Schemas\RecetaForm;
use App\Filament\Resources\Recetas\Schemas\RecetaInfolist;
use App\Filament\Resources\Recetas\Tables\RecetasTable;
use App\Models\Receta;
use App\Traits\HasResourceAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class RecetaResource extends Resource
{
    use HasResourceAuthorization;
    protected static array $allowedRoles = ['super_admin', 'administrador', 'gestion_cocina'];

    protected static ?string $model = Receta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static UnitEnum|string|null $navigationGroup = 'Menus';

    protected static ?string $modelLabel = 'Subreceta';

    protected static ?string $pluralModelLabel = 'Subrecetas';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return RecetaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RecetaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecetasTable::configure($table);
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
            'index' => ListRecetas::route('/'),
            'create' => CreateReceta::route('/create'),
            'view' => ViewReceta::route('/{record}'),
            'edit' => EditReceta::route('/{record}/edit'),
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
