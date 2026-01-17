# API REST - The Rustic

API RESTful con autenticación mediante tokens (Laravel Sanctum) para el sistema de gestión del restaurante.

## 📚 Documentación

**Documentación interactiva:** http://127.0.0.1:8000/docs

La documentación incluye:
- ✅ Endpoints disponibles
- ✅ Parámetros requeridos/opcionales
- ✅ Ejemplos de requests/responses
- ✅ Probador interactivo (try it out)
- ✅ Colección de Postman
- ✅ Especificación OpenAPI/Swagger

---

## 🔐 Autenticación

### 1. Login (Obtener Token)

**POST** `/api/login`

```json
{
  "email": "admin@correo.com",
  "password": "12345678"
}
```

**Respuesta:**
```json
{
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@correo.com"
  },
  "token": "1|abcdef123456...",
  "modules": ["bebidas", "ingredientes", "movimiento-inventarios"],
  "permissions": ["ver", "editar", "eliminar"]
}
```

### 2. Usar el Token

Incluye el token en el header de **todas** las peticiones protegidas:

```
Authorization: Bearer 1|abcdef123456...
```

### 3. Logout

**POST** `/api/logout`

Headers:
```
Authorization: Bearer {tu-token}
```

---

## 📋 Recursos Disponibles

### Bebidas

| Método | Endpoint | Descripción | Permiso |
|--------|----------|-------------|---------|
| GET | `/api/bebidas` | Listar bebidas | `ver` + módulo `bebidas` |
| GET | `/api/bebidas/{id}` | Ver bebida | `ver` + módulo `bebidas` |
| POST | `/api/bebidas` | Crear bebida | `editar` + módulo `bebidas` |
| PUT | `/api/bebidas/{id}` | Actualizar bebida | `editar` + módulo `bebidas` |
| DELETE | `/api/bebidas/{id}` | Eliminar bebida | `eliminar` + módulo `bebidas` |

**Ejemplo - Listar bebidas:**
```bash
curl -X GET http://127.0.0.1:8000/api/bebidas \
  -H "Authorization: Bearer tu-token-aqui"
```

**Ejemplo - Crear bebida:**
```bash
curl -X POST http://127.0.0.1:8000/api/bebidas \
  -H "Authorization: Bearer tu-token-aqui" \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Coca Cola",
    "marca": "Coca Cola",
    "presentacion": "Botella 600ml",
    "unidades_por_empaque": 24,
    "stock_actual": 100,
    "stock_minimo": 20,
    "costo_unitario": 10.50,
    "precio_venta": 15.00,
    "activo": true
  }'
```

---

## 🔧 Cómo Agregar Más Recursos

Para agregar un nuevo recurso (ej: Ingredientes), sigue este patrón:

### 1. Crear Controller

```bash
php artisan make:controller Api/IngredienteController
```

Copia la estructura de `BebidaController.php` y ajusta:
- Nombre del modelo
- Slug del módulo en `hasModule('ingredientes')`
- Campos de validación

### 2. Crear Resource

```bash
php artisan make:resource IngredienteResource
```

Define los campos que quieres exponer en el JSON.

### 3. Agregar Ruta

En `routes/api.php`:

```php
Route::apiResource('ingredientes', IngredienteController::class);
```

### 4. Regenerar Documentación

```bash
php artisan scribe:generate
```

---

## 🛡️ Sistema de Permisos

La API usa el mismo sistema de permisos que Filament:

1. **Permisos globales:** `ver`, `editar`, `eliminar`
2. **Módulos:** Cada usuario tiene módulos asignados (`bebidas`, `ingredientes`, etc.)
3. **Validación:** Cada endpoint verifica:
   - ✅ Usuario autenticado (token válido)
   - ✅ Permiso requerido (`ver` / `editar` / `eliminar`)
   - ✅ Acceso al módulo

**Ejemplo de respuesta sin permiso:**
```json
{
  "message": "No autorizado"
}
```

**Ejemplo sin módulo:**
```json
{
  "message": "No tiene acceso a este módulo"
}
```

---

## 📦 Paginación

Los endpoints de listado usan paginación automática:

```
GET /api/bebidas?page=2&per_page=20
```

**Respuesta:**
```json
{
  "data": [...],
  "links": {
    "first": "http://...",
    "last": "http://...",
    "prev": null,
    "next": "http://..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 73
  }
}
```

---

## 🧪 Probando la API

### Opción 1: Postman

1. Descarga la colección: `storage/app/private/scribe/collection.json`
2. Importa en Postman
3. Configura variable de entorno `token` con tu token

### Opción 2: cURL

```bash
# Login
TOKEN=$(curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@correo.com","password":"12345678"}' \
  | jq -r '.token')

# Listar bebidas
curl -X GET http://127.0.0.1:8000/api/bebidas \
  -H "Authorization: Bearer $TOKEN"
```

### Opción 3: Navegador (solo GET)

Instala extensión como "ModHeader" para agregar el header `Authorization`.

---

## 🚀 Próximos Recursos a Implementar

Siguiendo el mismo patrón, puedes agregar:

- ✅ **Bebidas** (implementado)
- ⏳ **Ingredientes**
- ⏳ **Unidades de Medida**
- ⏳ **Movimientos de Inventario**
- ⏳ **Platos**
- ⏳ **Recetas**
- ⏳ **Categorías de Menú**

---

## ⚙️ Configuración CORS

Si el frontend está en otro dominio/puerto, configura CORS en `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000'], // URL del frontend
'supports_credentials' => true,
```

---

## 📝 Notas Importantes

1. **Tokens no expiran** por defecto (puedes configurarlo en Sanctum)
2. **Un token por dispositivo** - El usuario puede tener múltiples tokens activos
3. **Revocación de tokens** - Al hacer logout solo se revoca el token actual
4. **Rate Limiting** - Laravel aplica límites de requests por minuto (configurable)
5. **Validación automática** - Laravel devuelve errores 422 con detalles de validación

---

## 🐛 Troubleshooting

### Token no funciona
- Verifica que el header sea: `Authorization: Bearer {token}`
- Asegúrate que la tabla `personal_access_tokens` existe
- Revisa que el usuario no haya sido eliminado

### 403 Forbidden
- Verifica que el usuario tenga el **permiso** correcto
- Verifica que el usuario tenga el **módulo** asignado
- Revisa los permisos en la tabla `user_modules`

### 500 Internal Server Error
- Revisa logs: `storage/logs/laravel.log`
- Ejecuta: `php artisan optimize:clear`

---

## 📚 Recursos Adicionales

- **Laravel Sanctum:** https://laravel.com/docs/sanctum
- **API Resources:** https://laravel.com/docs/eloquent-resources
- **Scribe (Documentación):** https://scribe.knuckles.wtf/

