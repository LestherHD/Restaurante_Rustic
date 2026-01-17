<?php

namespace App\Traits;

/**
 * Trait para autorización basada en módulos y permisos globales
 */
trait HasResourceAuthorization
{
    /**
     * Obtener el slug del módulo del recurso
     */
    protected static function getModuloSlug(): string
    {
        // Obtener el namespace completo del Resource
        $fullClassName = static::class;
        
        // Extraer el nombre de la carpeta del namespace
        // Ej: App\Filament\Resources\Bebidas\BebidaResource -> Bebidas
        preg_match('/Resources\\\\([^\\\\]+)\\\\/', $fullClassName, $matches);
        
        if (isset($matches[1])) {
            $folderName = $matches[1];
            
            // Convertir a slug (ej: "Bebidas" -> "bebidas", "MovimientoInventarios" -> "movimiento-inventarios")
            $slug = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $folderName));
            
            return $slug;
        }
        
        // Fallback: usar el nombre de la clase
        $className = class_basename(static::class);
        $moduleName = str_replace('Resource', '', $className);
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $moduleName));
    }

    /**
     * Verificar si puede ver cualquier registro
     */
    public static function canViewAny(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Verificar si tiene el módulo asignado y permiso de ver
        return $user->hasModule(static::getModuloSlug()) && $user->hasPermissionTo('ver');
    }

    /**
     * Verificar si puede ver un registro específico
     */
    public static function canView($record): bool
    {
        return static::canViewAny();
    }

    /**
     * Verificar si puede crear registros
     */
    public static function canCreate(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->hasModule(static::getModuloSlug()) && $user->hasPermissionTo('editar');
    }

    /**
     * Verificar si puede editar un registro
     */
    public static function canEdit($record): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->hasModule(static::getModuloSlug()) && $user->hasPermissionTo('editar');
    }

    /**
     * Verificar si puede eliminar un registro
     */
    public static function canDelete($record): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return $user->hasModule(static::getModuloSlug()) && $user->hasPermissionTo('eliminar');
    }

    /**
     * Verificar si puede eliminar múltiples registros
     */
    public static function canDeleteAny(): bool
    {
        return static::canDelete(null);
    }
}
