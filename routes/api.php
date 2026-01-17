<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BebidaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas (sin autenticación)
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Bebidas
    Route::apiResource('bebidas', BebidaController::class);
    
    // Agregar más recursos aquí siguiendo el mismo patrón
    // Route::apiResource('ingredientes', IngredienteController::class);
    // Route::apiResource('platos', PlatoController::class);
    // Route::apiResource('recetas', RecetaController::class);
    // Route::apiResource('movimientos', MovimientoInventarioController::class);
});
