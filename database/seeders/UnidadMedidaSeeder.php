<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMedidaSeeder extends Seeder
{
    public function run(): void
    {
        $unidades = [
            ['nombre' => 'Kilogramo', 'abreviatura' => 'kg'],
            ['nombre' => 'Litro', 'abreviatura' => 'L'],
            ['nombre' => 'Pieza', 'abreviatura' => 'pz'],
            ['nombre' => 'Gramo', 'abreviatura' => 'g'],
            ['nombre' => 'Mililitro', 'abreviatura' => 'ml'],
            ['nombre' => 'Onza', 'abreviatura' => 'oz'],
            ['nombre' => 'Galon', 'abreviatura' => 'gal'],
            ['nombre' => 'Diente', 'abreviatura' => 'diente'],
            ['nombre' => 'Taza', 'abreviatura' => 'taza'],
            ['nombre' => 'Cucharada', 'abreviatura' => 'cda'],
            ['nombre' => 'Cucharadita', 'abreviatura' => 'cdta'],
        ];

        foreach ($unidades as $unidad) {
            DB::table('unidades_medida')->insert([
                'nombre' => $unidad['nombre'],
                'abreviatura' => $unidad['abreviatura'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
