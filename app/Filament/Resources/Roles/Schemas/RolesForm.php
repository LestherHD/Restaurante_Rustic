<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RolesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Rol')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Rol')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Ejemplo: manejo_inventario, mesero, cocinero'),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                
                Section::make('Permisos')
                    ->schema([
                        CheckboxList::make('permissions')
                            ->label('Permisos Asignados')
                            ->relationship('permissions', 'name')
                            ->options(
                                Permission::all()->groupBy(function($permission) {
                                    // Agrupar por recurso (view_user, create_user -> User)
                                    $parts = explode('_', $permission->name);
                                    return count($parts) > 1 ? ucfirst($parts[1]) : 'Otros';
                                })->map(fn ($group) => $group->pluck('name', 'id'))->toArray()
                            )
                            ->columns(3)
                            ->helperText('Selecciona qué acciones puede realizar este rol'),
                    ]),
            ]);
    }
}
