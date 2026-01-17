<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BebidaSeeder extends Seeder
{
    public function run(): void
    {
        $bebidas = [
            // Refrescos en lata
            [
                'nombre' => 'Coca Cola',
                'marca' => 'Coca Cola',
                'presentacion' => 'Lata 355ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 96,
                'stock_minimo' => 24,
                'costo_unitario' => 0.80,
                'precio_venta' => 1.50,
            ],
            [
                'nombre' => 'Coca Cola Zero',
                'marca' => 'Coca Cola',
                'presentacion' => 'Lata 355ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 48,
                'stock_minimo' => 24,
                'costo_unitario' => 0.80,
                'precio_venta' => 1.50,
            ],
            [
                'nombre' => 'Sprite',
                'marca' => 'Coca Cola',
                'presentacion' => 'Lata 355ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 48,
                'stock_minimo' => 24,
                'costo_unitario' => 0.75,
                'precio_venta' => 1.50,
            ],
            [
                'nombre' => 'Fanta Naranja',
                'marca' => 'Coca Cola',
                'presentacion' => 'Lata 355ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 24,
                'stock_minimo' => 12,
                'costo_unitario' => 0.75,
                'precio_venta' => 1.50,
            ],

            // Cervezas
            [
                'nombre' => 'Corona Extra',
                'marca' => 'Corona',
                'presentacion' => 'Botella 355ml',
                'unidades_por_empaque' => 12,
                'stock_actual' => 60,
                'stock_minimo' => 24,
                'costo_unitario' => 1.20,
                'precio_venta' => 2.50,
            ],
            [
                'nombre' => 'Modelo Especial',
                'marca' => 'Modelo',
                'presentacion' => 'Botella 355ml',
                'unidades_por_empaque' => 12,
                'stock_actual' => 48,
                'stock_minimo' => 24,
                'costo_unitario' => 1.15,
                'precio_venta' => 2.50,
            ],
            [
                'nombre' => 'Victoria',
                'marca' => 'Modelo',
                'presentacion' => 'Botella 355ml',
                'unidades_por_empaque' => 12,
                'stock_actual' => 36,
                'stock_minimo' => 12,
                'costo_unitario' => 1.10,
                'precio_venta' => 2.50,
            ],
            [
                'nombre' => 'Tecate Light',
                'marca' => 'Tecate',
                'presentacion' => 'Lata 355ml',
                'unidades_por_empaque' => 12,
                'stock_actual' => 24,
                'stock_minimo' => 12,
                'costo_unitario' => 1.00,
                'precio_venta' => 2.00,
            ],

            // Agua
            [
                'nombre' => 'Agua Ciel',
                'marca' => 'Ciel',
                'presentacion' => 'Botella 600ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 120,
                'stock_minimo' => 48,
                'costo_unitario' => 0.30,
                'precio_venta' => 0.75,
            ],
            [
                'nombre' => 'Agua Ciel',
                'marca' => 'Ciel',
                'presentacion' => 'Botella 1.5L',
                'unidades_por_empaque' => 12,
                'stock_actual' => 24,
                'stock_minimo' => 12,
                'costo_unitario' => 0.50,
                'precio_venta' => 1.25,
            ],

            // Jugos
            [
                'nombre' => 'Jugo Del Valle Naranja',
                'marca' => 'Del Valle',
                'presentacion' => 'Tetra Pack 1L',
                'unidades_por_empaque' => 12,
                'stock_actual' => 24,
                'stock_minimo' => 12,
                'costo_unitario' => 1.50,
                'precio_venta' => 3.00,
            ],
            [
                'nombre' => 'Jugo Del Valle Manzana',
                'marca' => 'Del Valle',
                'presentacion' => 'Tetra Pack 1L',
                'unidades_por_empaque' => 12,
                'stock_actual' => 12,
                'stock_minimo' => 6,
                'costo_unitario' => 1.50,
                'precio_venta' => 3.00,
            ],

            // Bebidas energéticas
            [
                'nombre' => 'Red Bull',
                'marca' => 'Red Bull',
                'presentacion' => 'Lata 250ml',
                'unidades_por_empaque' => 24,
                'stock_actual' => 48,
                'stock_minimo' => 12,
                'costo_unitario' => 1.80,
                'precio_venta' => 3.50,
            ],
        ];

        foreach ($bebidas as $bebida) {
            DB::table('bebidas')->insert([
                'nombre' => $bebida['nombre'],
                'marca' => $bebida['marca'],
                'presentacion' => $bebida['presentacion'],
                'unidades_por_empaque' => $bebida['unidades_por_empaque'],
                'stock_actual' => $bebida['stock_actual'],
                'stock_minimo' => $bebida['stock_minimo'],
                'costo_unitario' => $bebida['costo_unitario'],
                'precio_venta' => $bebida['precio_venta'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
