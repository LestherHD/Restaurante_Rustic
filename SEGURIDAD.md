# 🔒 Checklist de Seguridad - The Rustic

## ✅ Implementado

### 1. Autenticación
- ✅ Contraseñas hasheadas con bcrypt
- ✅ Tokens API (Laravel Sanctum)
- ✅ Logout revoca tokens
- ✅ Protección CSRF en formularios web

### 2. Control de Acceso
- ✅ Permisos granulares (ver/editar/eliminar)
- ✅ Módulos asignados por usuario
- ✅ Validación en cada endpoint API
- ✅ 403 Forbidden si no tiene acceso

### 3. Archivos/Uploads
- ✅ Solo imágenes permitidas
- ✅ Límite de tamaño (2MB)
- ✅ Nombres hasheados (evita conflictos)
- ✅ Directorio separado por tipo

## ⚠️ Pendiente para Producción

### 1. Variables de Entorno
```bash
# .env - NUNCA subir a Git
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... # Generar con: php artisan key:generate
```

### 2. HTTPS Obligatorio
```php
// En app/Providers/AppServiceProvider.php
public function boot()
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

### 3. Rate Limiting API
```php
// En routes/api.php
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // 60 requests por minuto
});
```

### 4. Validación Estricta de Archivos
```php
FileUpload::make('imagen')
    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
    ->maxSize(2048)
    ->image()
    ->preserveFilenames(false) // Hashea nombres
    ->disk('public');
```

### 5. Backup de Base de Datos
```bash
# Automatizar backups diarios
php artisan backup:run
```

### 6. Headers de Seguridad
```apache
# En .htaccess o nginx
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
```

### 7. Logs y Monitoreo
```php
// Loguear intentos de acceso no autorizado
Log::warning('Acceso denegado', [
    'user' => $user->email,
    'module' => $module,
    'ip' => $request->ip()
]);
```

## 🚫 Qué NO hacer

❌ Subir `.env` a Git
❌ Dejar `APP_DEBUG=true` en producción
❌ Exponer rutas sin autenticación
❌ Guardar contraseñas en texto plano
❌ Permitir cualquier tipo de archivo
❌ No validar entrada del usuario

## 📋 Antes de Subir a Servidor

```bash
# 1. Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# 2. Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Instalar solo dependencias de producción
composer install --optimize-autoloader --no-dev

# 4. Permisos correctos
chmod -R 755 storage bootstrap/cache
```

## 🔐 Para Imágenes Sensibles (Futuro)

Si en el futuro necesitas guardar documentos sensibles (contratos, facturas):

```php
// Disco privado
'disks' => [
    'private_documents' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
        'visibility' => 'private',
    ],
],

// Servir vía controlador autenticado
Route::get('/documents/{filename}', function($filename) {
    if (!auth()->user()->can('view-documents')) {
        abort(403);
    }
    return response()->file(storage_path('app/private/'.$filename));
})->middleware('auth:sanctum');
```

## 📝 Recomendaciones Finales

### Para tu caso (Restaurant):
- ✅ Imágenes de bebidas/platos → **Storage público** (ya está bien)
- ✅ Control de acceso → **API con tokens** (implementado)
- ✅ Contraseñas → **Bcrypt** (Laravel lo hace automático)
- ✅ Archivos subidos → **Validados y hasheados** (configurado)

### Lo importante es:
1. HTTPS en producción
2. `.env` seguro y no en Git
3. Rate limiting en API
4. Backups automáticos
5. Monitoreo de logs

**Las imágenes de productos NO necesitan encriptación** - son públicas por naturaleza (aparecerán en menús, apps, etc).
