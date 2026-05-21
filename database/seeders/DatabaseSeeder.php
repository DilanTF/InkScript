<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Story;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear a Dilan como Usuario Autor Principal
        $dilan = User::firstOrCreate(
            ['email' => 'dilan@inkscript.com'],
            [
                'name' => 'Dilan Autor',
                'password' => Hash::make('password123'),
                'role' => 'author',
            ]
        );

        // 2. Crear un Lector de Prueba
        $lector = User::firstOrCreate(
            ['email' => 'lector@inkscript.com'],
            [
                'name' => 'Lector Entusiasta',
                'password' => Hash::make('password123'),
                'role' => 'reader',
            ]
        );

        // 3. Crear algunas historias para Dilan
        $historia1 = Story::firstOrCreate(
            ['title' => 'El Eco de las Sombras', 'user_id' => $dilan->id],
            ['description' => 'Una aventura épica en un mundo donde las sombras cobran vida y revelan los secretos más oscuros de la humanidad.']
        );

        $historia2 = Story::firstOrCreate(
            ['title' => 'Memorias Digitales', 'user_id' => $dilan->id],
            ['description' => 'En el año 2084, los recuerdos se pueden comprar y vender. Un detective busca un recuerdo borrado que podría cambiar el curso de la historia.']
        );

        // 4. Llenar la Tienda con Libros (Físicos y Digitales)
        $libros = [
            [
                'title' => 'El Eco de las Sombras (Edición Coleccionista)',
                'genre' => 'Fantasía Oscura',
                'description' => 'La exitosa novela ahora en tapa dura con ilustraciones exclusivas y un mapa detallado del mundo de las sombras.',
                'price' => 24.99,
                'stock' => 50,
                'is_digital' => false,
                'story_id' => $historia1->id,
                'user_id' => $dilan->id,
                'status' => 'available',
            ],
            [
                'title' => 'Memorias Digitales',
                'genre' => 'Ciencia Ficción',
                'description' => 'E-book oficial de la novela cyberpunk del año. Descarga inmediata compatible con todos los lectores.',
                'price' => 9.99,
                'stock' => 9999, // Ilimitado para digital
                'is_digital' => true,
                'story_id' => $historia2->id,
                'user_id' => $dilan->id,
                'status' => 'available',
            ],
            [
                'title' => 'El Arte de la Guerra',
                'genre' => 'Clásicos',
                'description' => 'El tratado militar más antiguo del mundo, en una nueva edición traducida y comentada por expertos.',
                'price' => 14.50,
                'stock' => 10,
                'is_digital' => false,
                'story_id' => null, // No viene de una historia de la plataforma
                'user_id' => null,  // Vendido por la tienda directamente
                'status' => 'available',
            ],
            [
                'title' => 'Aprende Laravel en 24 Horas',
                'genre' => 'Educación IT',
                'description' => 'Guía práctica y acelerada para dominar el framework PHP más popular del mercado.',
                'price' => 19.99,
                'stock' => 0, // Agotado para probar la vista
                'is_digital' => false,
                'story_id' => null,
                'user_id' => null,
                'status' => 'out_of_stock',
            ]
        ];

        foreach ($libros as $libroData) {
            Book::firstOrCreate(
                ['title' => $libroData['title']],
                $libroData
            );
        }

        echo "¡Base de datos sembrada con éxito! 🎉\n";
        echo "Usuarios creados: \n";
        echo "- Autor: dilan@inkscript.com (Pass: password123)\n";
        echo "- Lector: lector@inkscript.com (Pass: password123)\n";
    }
}