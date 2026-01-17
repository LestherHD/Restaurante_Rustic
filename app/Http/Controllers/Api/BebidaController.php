<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BebidaResource;
use App\Models\Bebida;
use Illuminate\Http\Request;

/**
 * @group Bebidas
 * 
 * APIs para gestión de bebidas
 */
class BebidaController extends Controller
{
    /**
     * Listar bebidas
     * 
     * Obtiene todas las bebidas con paginación.
     * 
     * @authenticated
     * 
     * @queryParam page integer Número de página. Example: 1
     * @queryParam per_page integer Elementos por página. Example: 15
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Coca Cola",
     *       "descripcion": "Refresco de cola",
     *       "unidad_medida_id": 1,
     *       "unidades_por_empaque": 24,
     *       "precio_compra": 150.00,
     *       "created_at": "2026-01-15T10:00:00.000000Z"
     *     }
     *   ],
     *   "links": {...},
     *   "meta": {...}
     * }
     */
    public function index(Request $request)
    {
        // Verificar permiso
        if (!$request->user()->hasPermissionTo('ver')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Verificar módulo
        if (!$request->user()->hasModule('bebidas')) {
            return response()->json(['message' => 'No tiene acceso a este módulo'], 403);
        }

        $perPage = $request->get('per_page', 15);
        $bebidas = Bebida::paginate($perPage);

        return BebidaResource::collection($bebidas);
    }

    /**
     * Ver bebida
     * 
     * Obtiene los detalles de una bebida específica.
     * 
     * @authenticated
     * 
     * @urlParam id integer required El ID de la bebida. Example: 1
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "nombre": "Coca Cola",
     *     "descripcion": "Refresco de cola",
     *     "unidad_medida_id": 1,
     *     "unidades_por_empaque": 24,
     *     "precio_compra": 150.00,
     *     "created_at": "2026-01-15T10:00:00.000000Z"
     *   }
     * }
     */
    public function show(Request $request, Bebida $bebida)
    {
        if (!$request->user()->hasPermissionTo('ver')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if (!$request->user()->hasModule('bebidas')) {
            return response()->json(['message' => 'No tiene acceso a este módulo'], 403);
        }

        return new BebidaResource($bebida);
    }

    /**
     * Crear bebida
     * 
     * Crea una nueva bebida.
     * 
     * @authenticated
     * 
     * @bodyParam nombre string required Nombre de la bebida. Example: Coca Cola
     * @bodyParam descripcion string Descripción de la bebida. Example: Refresco de cola
     * @bodyParam unidad_medida_id integer required ID de la unidad de medida. Example: 1
     * @bodyParam unidades_por_empaque integer required Unidades por empaque. Example: 24
     * @bodyParam precio_compra number required Precio de compra. Example: 150.00
     * 
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "nombre": "Coca Cola",
     *     "descripcion": "Refresco de cola",
     *     "unidad_medida_id": 1,
     *     "unidades_por_empaque": 24,
     *     "precio_compra": 150.00,
     *     "created_at": "2026-01-15T10:00:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request)
    {
        if (!$request->user()->hasPermissionTo('editar')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if (!$request->user()->hasModule('bebidas')) {
            return response()->json(['message' => 'No tiene acceso a este módulo'], 403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string|max:255',
            'unidades_por_empaque' => 'required|integer|min:1',
            'stock_actual' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
            'costo_unitario' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'imagen' => 'nullable|string',
            'activo' => 'nullable|boolean',
        ]);

        $bebida = Bebida::create($validated);

        return new BebidaResource($bebida);
    }

    /**
     * Actualizar bebida
     * 
     * Actualiza una bebida existente.
     * 
     * @authenticated
     * 
     * @urlParam id integer required El ID de la bebida. Example: 1
     * @bodyParam nombre string Nombre de la bebida. Example: Coca Cola
     * @bodyParam descripcion string Descripción de la bebida. Example: Refresco de cola
     * @bodyParam unidad_medida_id integer ID de la unidad de medida. Example: 1
     * @bodyParam unidades_por_empaque integer Unidades por empaque. Example: 24
     * @bodyParam precio_compra number Precio de compra. Example: 150.00
     */
    public function update(Request $request, Bebida $bebida)
    {
        if (!$request->user()->hasPermissionTo('editar')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if (!$request->user()->hasModule('bebidas')) {
            return response()->json(['message' => 'No tiene acceso a este módulo'], 403);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'marca' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string|max:255',
            'unidades_por_empaque' => 'sometimes|integer|min:1',
            'stock_actual' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
            'costo_unitario' => 'sometimes|numeric|min:0',
            'precio_venta' => 'sometimes|numeric|min:0',
            'imagen' => 'nullable|string',
            'activo' => 'nullable|boolean',
        ]);

        $bebida->update($validated);

        return new BebidaResource($bebida);
    }

    /**
     * Eliminar bebida
     * 
     * Elimina una bebida.
     * 
     * @authenticated
     * 
     * @urlParam id integer required El ID de la bebida. Example: 1
     * 
     * @response 200 {
     *   "message": "Bebida eliminada exitosamente"
     * }
     */
    public function destroy(Request $request, Bebida $bebida)
    {
        if (!$request->user()->hasPermissionTo('eliminar')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if (!$request->user()->hasModule('bebidas')) {
            return response()->json(['message' => 'No tiene acceso a este módulo'], 403);
        }

        $bebida->delete();

        return response()->json(['message' => 'Bebida eliminada exitosamente']);
    }
}
