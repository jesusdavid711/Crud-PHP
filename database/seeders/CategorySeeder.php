<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nombre' => 'Electrónica', 'descripcion' => 'Dispositivos electrónicos y gadgets'],
            ['nombre' => 'Ropa', 'descripcion' => 'Prendas de vestir y accesorios'],
            ['nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar y decoración'],
            ['nombre' => 'Alimentos', 'descripcion' => 'Productos alimenticios y bebidas'],
            ['nombre' => 'Deportes', 'descripcion' => 'Equipamiento deportivo y fitness'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
