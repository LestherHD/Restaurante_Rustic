<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredienteSeeder extends Seeder
{
    public function run(): void
    {
        $ingredientes = [
            // Lacteos y cremosos (en onzas) - PRECIO POR ONZA
            ['nombre' => 'Media crema', 'unidad_medida_id' => 6, 'costo_unitario' => 0.0625, 'stock_actual' => 500.00, 'stock_minimo' => 100.00],
            ['nombre' => 'Queso parmesano', 'unidad_medida_id' => 6, 'costo_unitario' => 0.30, 'stock_actual' => 300.00, 'stock_minimo' => 50.00],
            ['nombre' => 'Mantequilla', 'unidad_medida_id' => 6, 'costo_unitario' => 0.15, 'stock_actual' => 200.00, 'stock_minimo' => 50.00],
            ['nombre' => 'Queso cheddar', 'unidad_medida_id' => 6, 'costo_unitario' => 0.20, 'stock_actual' => 400.00, 'stock_minimo' => 80.00],
            
            // Vegetales (en onzas) - PRECIO POR ONZA
            ['nombre' => 'Jalapeno', 'unidad_medida_id' => 6, 'costo_unitario' => 0.08, 'stock_actual' => 150.00, 'stock_minimo' => 30.00],
            ['nombre' => 'Cilantro', 'unidad_medida_id' => 6, 'costo_unitario' => 0.50, 'stock_actual' => 80.00, 'stock_minimo' => 20.00],
            ['nombre' => 'Cebolla', 'unidad_medida_id' => 6, 'costo_unitario' => 0.04, 'stock_actual' => 500.00, 'stock_minimo' => 80.00],
            ['nombre' => 'Tomate', 'unidad_medida_id' => 6, 'costo_unitario' => 0.06, 'stock_actual' => 400.00, 'stock_minimo' => 80.00],
            ['nombre' => 'Lechuga', 'unidad_medida_id' => 6, 'costo_unitario' => 0.05, 'stock_actual' => 300.00, 'stock_minimo' => 50.00],
            ['nombre' => 'Papa', 'unidad_medida_id' => 6, 'costo_unitario' => 0.08, 'stock_actual' => 800.00, 'stock_minimo' => 150.00],
            ['nombre' => 'Ajo', 'unidad_medida_id' => 8, 'costo_unitario' => 0.10, 'stock_actual' => 200.00, 'stock_minimo' => 50.00], // Por diente
            
            // Carnes (en onzas) - PRECIO POR ONZA
            ['nombre' => 'Rib Eye', 'unidad_medida_id' => 6, 'costo_unitario' => 0.80, 'stock_actual' => 320.00, 'stock_minimo' => 80.00],
            ['nombre' => 'Pechuga de pollo', 'unidad_medida_id' => 6, 'costo_unitario' => 0.40, 'stock_actual' => 500.00, 'stock_minimo' => 120.00],
            ['nombre' => 'Carne molida', 'unidad_medida_id' => 6, 'costo_unitario' => 0.35, 'stock_actual' => 400.00, 'stock_minimo' => 100.00],
            ['nombre' => 'Tocino', 'unidad_medida_id' => 6, 'costo_unitario' => 0.25, 'stock_actual' => 200.00, 'stock_minimo' => 50.00],
            
            // Liquidos (en onzas) - PRECIO POR ONZA
            ['nombre' => 'Agua', 'unidad_medida_id' => 6, 'costo_unitario' => 0.0125, 'stock_actual' => 3000.00, 'stock_minimo' => 500.00],
            ['nombre' => 'Aceite vegetal', 'unidad_medida_id' => 7, 'costo_unitario' => 8.00, 'stock_actual' => 20.00, 'stock_minimo' => 5.00], // Por galon
            ['nombre' => 'Salsa soya', 'unidad_medida_id' => 6, 'costo_unitario' => 0.10, 'stock_actual' => 250.00, 'stock_minimo' => 50.00],
            ['nombre' => 'Vino blanco', 'unidad_medida_id' => 6, 'costo_unitario' => 0.15, 'stock_actual' => 150.00, 'stock_minimo' => 30.00],
            
            // Condimentos - PRECIO POR UNIDAD
            ['nombre' => 'Sal', 'unidad_medida_id' => 10, 'costo_unitario' => 0.02, 'stock_actual' => 500.00, 'stock_minimo' => 100.00], // Por cucharada
            ['nombre' => 'Pimienta', 'unidad_medida_id' => 11, 'costo_unitario' => 0.05, 'stock_actual' => 300.00, 'stock_minimo' => 50.00], // Por cucharadita
            ['nombre' => 'Ajo en polvo', 'unidad_medida_id' => 11, 'costo_unitario' => 0.08, 'stock_actual' => 200.00, 'stock_minimo' => 40.00],
            ['nombre' => 'Harina', 'unidad_medida_id' => 9, 'costo_unitario' => 0.50, 'stock_actual' => 100.00, 'stock_minimo' => 20.00], // Por taza
            ['nombre' => 'Azucar', 'unidad_medida_id' => 9, 'costo_unitario' => 0.40, 'stock_actual' => 150.00, 'stock_minimo' => 30.00],
            
            // Pan (en piezas) - PRECIO POR PIEZA
            ['nombre' => 'Pan para hamburguesa', 'unidad_medida_id' => 3, 'costo_unitario' => 0.50, 'stock_actual' => 100.00, 'stock_minimo' => 20.00],
            ['nombre' => 'Pan para hot dog', 'unidad_medida_id' => 3, 'costo_unitario' => 0.40, 'stock_actual' => 80.00, 'stock_minimo' => 15.00],
            
            // Guarniciones (en tazas) - PRECIO POR TAZA
            ['nombre' => 'Arroz', 'unidad_medida_id' => 9, 'costo_unitario' => 0.30, 'stock_actual' => 200.00, 'stock_minimo' => 50.00],
            ['nombre' => 'Frijoles', 'unidad_medida_id' => 9, 'costo_unitario' => 0.35, 'stock_actual' => 150.00, 'stock_minimo' => 40.00],
        ];

        foreach ($ingredientes as $ingrediente) {
            DB::table('ingredientes')->insert([
                'nombre' => $ingrediente['nombre'],
                'unidad_medida_id' => $ingrediente['unidad_medida_id'],
                'costo_unitario' => $ingrediente['costo_unitario'],
                'stock_actual' => $ingrediente['stock_actual'],
                'stock_minimo' => $ingrediente['stock_minimo'],
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
