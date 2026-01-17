<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @group Autenticación
 * 
 * APIs para autenticación de usuarios
 */
class AuthController extends Controller
{
    /**
     * Login
     * 
     * Genera un token de acceso para el usuario.
     * 
     * @bodyParam email string required El email del usuario. Example: admin@correo.com
     * @bodyParam password string required La contraseña. Example: 12345678
     * 
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "Admin",
     *     "email": "admin@correo.com"
     *   },
     *   "token": "1|abc123...",
     *   "modules": ["bebidas", "ingredientes"],
     *   "permissions": ["ver", "editar", "eliminar"]
     * }
     * 
     * @response 422 {
     *   "message": "Las credenciales son incorrectas."
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        // Obtener módulos y permisos del usuario
        $modules = $user->modules()->pluck('module')->toArray();
        $permissions = $user->permissions()->pluck('name')->toArray();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
            'modules' => $modules,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Logout
     * 
     * Revoca el token actual del usuario.
     * 
     * @authenticated
     * 
     * @response 200 {
     *   "message": "Token revocado exitosamente."
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revocado exitosamente.',
        ]);
    }

    /**
     * Usuario actual
     * 
     * Obtiene la información del usuario autenticado.
     * 
     * @authenticated
     * 
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "Admin",
     *     "email": "admin@correo.com"
     *   },
     *   "modules": ["bebidas", "ingredientes"],
     *   "permissions": ["ver", "editar", "eliminar"]
     * }
     */
    public function me(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'modules' => $user->modules()->pluck('module')->toArray(),
            'permissions' => $user->permissions()->pluck('name')->toArray(),
        ]);
    }
}
