<?php

namespace App\Filament\Resources\Bebidas;

use App\Filament\Resources\Bebidas\Pages\CreateBebida;
use App\Filament\Resources\Bebidas\Pages\EditBebida;
use App\Filament\Resources\Bebidas\Pages\ListBebidas;
use App\Filament\Resources\Bebidas\Schemas\BebidaForm;
use App\Filament\Resources\Bebidas\Tables\BebidasTable;
use App\Models\Bebida;
use App\Traits\HasResourceAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BebidaResource extends Resource
{
    use HasResourceAuthorization;

    protected static ?string $model = Bebida::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static ?string $navigationLabel = 'Bebidas';

    protected static ?string $modelLabel = 'Bebida';

    protected static ?string $pluralModelLabel = 'Bebidas';

    protected static UnitEnum|string|null $navigationGroup = 'Inventario';

    // Roles permitidos para este recurso
    protected static array $allowedRoles = ['super_admin', 'administrador', 'manejo_inventario'];

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BebidaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BebidasTable::configure($table);
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
            'index' => ListBebidas::route('/'),
            'create' => CreateBebida::route('/create'),
            'edit' => EditBebida::route('/{record}/edit'),
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
