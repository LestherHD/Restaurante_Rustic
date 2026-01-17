<?php

namespace App\Filament\Resources\MovimientoInventarios;

use App\Filament\Resources\MovimientoInventarios\Pages\CreateMovimientoInventario;
use App\Filament\Resources\MovimientoInventarios\Pages\EditMovimientoInventario;
use App\Filament\Resources\MovimientoInventarios\Pages\ListMovimientoInventarios;
use App\Filament\Resources\MovimientoInventarios\Schemas\MovimientoInventarioForm;
use App\Filament\Resources\MovimientoInventarios\Tables\MovimientoInventariosTable;
use App\Models\MovimientoInventario;
use App\Traits\HasResourceAuthorization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class MovimientoInventarioResource extends Resource
{
    use HasResourceAuthorization;

    protected static ?string $model = MovimientoInventario::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static ?string $recordTitleAttribute = 'motivo';

    protected static ?string $navigationLabel = 'Movimientos';

    protected static ?string $modelLabel = 'Movimiento';

    // Roles permitidos para este recurso
    protected static array $allowedRoles = ['super_admin', 'administrador', 'manejo_inventario'];

    protected static ?string $pluralModelLabel = 'Movimientos de Inventario';

    protected static UnitEnum|string|null $navigationGroup = 'Inventario';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return MovimientoInventarioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MovimientoInventariosTable::configure($table);
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
            'index' => ListMovimientoInventarios::route('/'),
            'create' => CreateMovimientoInventario::route('/create'),
            'edit' => EditMovimientoInventario::route('/{record}/edit'),
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
