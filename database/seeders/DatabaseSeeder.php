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
        // 1. TUS USUARIOS PRINCIPALES (Para que puedas entrar)
        $dilan = User::firstOrCreate(
            ['email' => 'dilan@inkscript.com'],
            ['name' => 'Dilan Autor', 'password' => Hash::make('password123'), 'role' => 'author']
        );

        $lector = User::firstOrCreate(
            ['email' => 'lector@inkscript.com'],
            ['name' => 'Lector Entusiasta', 'password' => Hash::make('password123'), 'role' => 'reader']
        );

        // 2. CREAR 3 AUTORES FICTICIOS
        $nombresAutores = ['Laura Valenzuela', 'Marcos Domínguez', 'Sofía Reyes'];
        $autoresFicticios = [];

        foreach ($nombresAutores as $index => $nombre) {
            $autoresFicticios[] = User::firstOrCreate(
                ['email' => "autor{$index}@inkscript.com"],
                ['name' => $nombre, 'password' => Hash::make('password123'), 'role' => 'author']
            );
        }

        // 3. CREAR HISTORIAS PARA LOS AUTORES FICTICIOS (Para la sección "Historias Gratuitas")
        // Como no usamos Faker, creamos títulos directamente a mano
        $titulosHistorias = [
            'La última frontera', 'Secretos del abismo',
            'El reloj de arena', 'Caminos cruzados',
            'Luces en la niebla', 'El viento del norte'
        ];
        
        $historiaIndex = 0;
        foreach ($autoresFicticios as $autor) {
            for ($i = 0; $i < 2; $i++) {
                Story::create([
                    'title' => $titulosHistorias[$historiaIndex],
                    'description' => 'Una intrigante historia llena de misterios, aventuras y personajes inolvidables que te mantendrán al borde del asiento de principio a fin.',
                    'user_id' => $autor->id,
                ]);
                $historiaIndex++;
            }
        }

        // Crear tus 2 historias (Dilan)
        Story::create([
            'title' => 'El Eco de las Sombras',
            'description' => 'Una aventura épica en un mundo donde las sombras cobran vida y revelan los secretos más oscuros de la humanidad.',
            'user_id' => $dilan->id,
        ]);
        Story::create([
            'title' => 'Memorias Digitales',
            'description' => 'En el año 2084, los recuerdos se pueden comprar y vender. Un detective busca un recuerdo borrado que podría cambiar el curso de la historia.',
            'user_id' => $dilan->id,
        ]);


        // 4. CREAR 50 LIBROS PARA LA TIENDA CON PHP NATIVO (100% a prueba de fallos)
        $generos = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica'];
        $sustantivos = ['Secreto', 'Destino', 'Reino', 'Corazón', 'Caballero', 'Mundo', 'Laberinto', 'Espejo', 'Alma', 'Silencio'];
        $adjetivos = ['Oscuro', 'Brillante', 'Perdido', 'Eterno', 'Roto', 'Misterioso', 'Oculto', 'Sagrado', 'Letal', 'Mágico'];

        for ($i = 0; $i < 50; $i++) {
            // Lógica aleatoria nativa
            $esDigital = rand(1, 100) <= 60; // 60% de probabilidad
            $vieneDeAutor = rand(1, 100) <= 30; // 30% de probabilidad
            $autorAleatorio = $vieneDeAutor ? $autoresFicticios[array_rand($autoresFicticios)]->id : null;
            
            // Generar título dinámico mezclando palabras
            $tituloAleatorio = 'El ' . $sustantivos[array_rand($sustantivos)] . ' ' . $adjetivos[array_rand($adjetivos)];
            if (rand(1, 2) == 1) { // A veces le añadimos una segunda parte
                $tituloAleatorio .= ' Parte ' . rand(1, 3);
            }

            Book::create([
                'title' => $tituloAleatorio,
                'description' => 'Un fascinante viaje literario que explora las profundidades de la emoción y el intelecto humano. Considerada una obra imprescindible de esta década.',
                'genre' => $generos[array_rand($generos)],
                'price' => rand(400, 3500) / 100, // Precio aleatorio entre 4.00€ y 35.00€
                'stock' => $esDigital ? 9999 : rand(0, 50),
                'is_digital' => $esDigital,
                'status' => (rand(1, 100) <= 10) ? 'out_of_stock' : 'available', // 10% agotado
                'image' => null, // Dejamos la imagen en null como pediste
                'story_id' => null,
                'user_id' => $autorAleatorio
            ]);
        }

        echo "¡Semilla nativa completada con éxito! ✨\n";
        echo "- Se han generado 50 libros en la tienda.\n";
        echo "- Se han creado 3 autores con historias para tu panel.\n";
    }
}