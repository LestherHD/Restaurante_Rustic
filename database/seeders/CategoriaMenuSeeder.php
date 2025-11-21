<?php

namespace Database\Seeders;

use App\Models\CategoriaMenu;
use Illuminate\Database\Seeder;

class CategoriaMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaMenu::firstOrCreate([
            'nombre' => 'Desayunos',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Almuerzos',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Entradas',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Asados',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Burgers y Sandwiches',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Especiales',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Especiales Calientes',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Especiales Frías',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Mariscos',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Pizzas',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Pasta Skillet',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Guarniciones',
            'visible_publico' => true,
            'activo' => true,
        ]);

        CategoriaMenu::firstOrCreate([
            'nombre' => 'Bebidas',
            'visible_publico' => true,
            'activo' => true,
        ]);
    }
}
