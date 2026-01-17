<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;

class UserForm
{
    /**
     * Detectar automáticamente los módulos disponibles
     */
    protected static function getAvailableModules(): array
    {
        $modules = [];
        $resourcesPath = app_path('Filament/Resources');
        
        // Obtener todos los directorios de recursos
        $directories = File::directories($resourcesPath);
        
        foreach ($directories as $dir) {
            $moduleName = basename($dir);
            
            // Convertir nombre de directorio a slug consistente
            // Ejemplo: "Bebidas" -> "bebidas", "MovimientoInventarios" -> "movimiento-inventarios"
            $moduleSlug = preg_replace('/([a-z])([A-Z])/', '$1-$2', $moduleName);
            $moduleSlug = strtolower($moduleSlug);
            
            // Etiqueta legible (capitalizar primera letra de cada palabra)
            $moduleLabel = ucwords(str_replace('-', ' ', $moduleSlug));
            
            $modules[$moduleSlug] = $moduleLabel;
        }
        
        return $modules;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                    
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                    
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->revealable()
                    ->helperText('Dejar en blanco al editar para mantener la actual'),
                
                // Módulos detectados automáticamente
                CheckboxList::make('user_modules')
                    ->label('Módulos con Acceso')
                    ->options(static::getAvailableModules())
                    ->columns(3)
                    ->columnSpanFull(),
                
                // Permisos globales (solo 3)
                CheckboxList::make('permissions')
                    ->label('Permisos')
                    ->relationship('permissions', 'name')
                    ->options(Permission::all()->pluck('name', 'id'))
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
