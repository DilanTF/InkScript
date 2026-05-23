<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. TUS USUARIOS PRINCIPALES (No se tocan si ya existen)
        $dilan = User::firstOrCreate(
            ['email' => 'dilan@inkscript.com'],
            ['name' => 'Dilan Autor', 'password' => Hash::make('password123'), 'role' => 'author']
        );

        $lector = User::firstOrCreate(
            ['email' => 'lector@inkscript.com'],
            ['name' => 'Lector Entusiasta', 'password' => Hash::make('password123'), 'role' => 'reader']
        );

        // 2. CREAR AUTORES FICTICIOS (Solo si no existen)
        $nombresAutores = ['Laura Valenzuela', 'Marcos Domínguez', 'Sofía Reyes'];
        $autoresFicticios = [];

        foreach ($nombresAutores as $index => $nombre) {
            $autoresFicticios[] = User::firstOrCreate(
                ['email' => "autor{$index}@inkscript.com"],
                ['name' => $nombre, 'password' => Hash::make('password123'), 'role' => 'author']
            );
        }

        $usuariosComentaristas = array_merge([$lector], $autoresFicticios);

        // --- DICCIONARIO PARA TEXTOS ---
        $sustantivos = ['Secreto', 'Destino', 'Reino', 'Corazón', 'Caballero', 'Mundo', 'Laberinto', 'Espejo', 'Alma', 'Silencio'];
        $adjetivos = ['Oscuro', 'Brillante', 'Perdido', 'Eterno', 'Roto', 'Misterioso', 'Oculto', 'Sagrado', 'Letal', 'Mágico'];
        $parrafosContenido = [
            "El viento soplaba frío aquella noche. Nadie en el pueblo sospechaba lo que estaba a punto de ocurrir. Las sombras parecían alargarse de forma antinatural, reptando por las paredes de piedra de las casas más antiguas.",
            "Habían pasado años desde la última vez que alguien pronunció su nombre en voz alta. Algunos decían que era una maldición; otros, simplemente un mito olvidado por el tiempo. Pero él sabía la verdad.",
            "Cruzó el pasillo a pasos rápidos y silenciosos. En su mano derecha, sostenía el único artefacto capaz de detener la catástrofe. El corazón le latía con fuerza contra el pecho, amenazando con delatar su posición.",
            "«No puedes huir de lo que llevas dentro», resonó la voz en su cabeza. Intentó ignorarla, pero la verdad era incuestionable. Cada decisión le había llevado a este preciso momento, al borde del abismo.",
            "Finalmente, la luz del alba rompió el horizonte. El paisaje se tiñó de un naranja pálido que trajo consigo una frágil esperanza. Aún quedaba mucho camino por recorrer, pero por primera vez, sentía que no estaba solo."
        ];
        $textosComentarios = [
            "¡Me ha encantado este capítulo! La tensión está increíble.",
            "No me esperaba ese giro final. ¡Necesito el siguiente ya!",
            "La forma en que describes los escenarios hace que me lo imagine como una película. Gran trabajo.",
            "Tengo una teoría sobre lo que va a pasar... espero no equivocarme.",
            "Un poco lento al principio, pero el final compensa con creces. Sigue así.",
            "Increíble, simplemente increíble. Ya soy fan número uno de esta historia.",
            "¿Cuándo subes la próxima parte? Me has dejado con la intriga."
        ];

        // 3. CREAR HISTORIAS DE PRUEBA (Solo si los autores ficticios no tienen historias)
        $titulosHistorias = [
            'La última frontera', 'Secretos del abismo',
            'El reloj de arena', 'Caminos cruzados',
            'Luces en la niebla', 'El viento del norte'
        ];
        
        $historiaIndex = 0;
        foreach ($autoresFicticios as $autor) {
            // Comprobamos si este autor ya tiene historias. Si tiene, lo saltamos.
            if ($autor->stories()->count() == 0) {
                for ($i = 0; $i < 2; $i++) {
                    $story = Story::create([
                        'title' => $titulosHistorias[$historiaIndex],
                        'description' => 'Una intrigante historia llena de misterios, aventuras y personajes inolvidables.',
                        'user_id' => $autor->id,
                    ]);

                    $numCapitulos = rand(3, 6);
                    for ($j = 1; $j <= $numCapitulos; $j++) {
                        $contenidoCapitulo = $parrafosContenido[array_rand($parrafosContenido)] . "\n\n" . 
                                             $parrafosContenido[array_rand($parrafosContenido)] . "\n\n" .
                                             "Continuará en el próximo capítulo...";

                        $chapter = Chapter::create([
                            'story_id' => $story->id,
                            'title' => 'Capítulo ' . $j . ': El ' . $sustantivos[array_rand($sustantivos)] . ' ' . $adjetivos[array_rand($adjetivos)],
                            'content' => $contenidoCapitulo,
                            'order_number' => $j,
                        ]);

                        if (rand(1, 100) <= 70) {
                            $numComentarios = rand(1, 4);
                            for ($k = 0; $k < $numComentarios; $k++) {
                                $usuarioAleatorio = $usuariosComentaristas[array_rand($usuariosComentaristas)];
                                Comment::create([
                                    'chapter_id' => $chapter->id,
                                    'user_id' => $usuarioAleatorio->id,
                                    'content' => $textosComentarios[array_rand($textosComentarios)],
                                    'created_at' => now()->subHours(rand(1, 72)) 
                                ]);
                            }
                        }
                    }
                    $historiaIndex++;
                }
            } else {
                $historiaIndex += 2; // Avanzamos los títulos para mantener la coherencia
            }
        }

        // Crear historias de Dilan solo si no las has creado ya
        if (!Story::where('title', 'El Eco de las Sombras')->exists()) {
            Story::create([
                'title' => 'El Eco de las Sombras',
                'description' => 'Una aventura épica en un mundo donde las sombras cobran vida.',
                'user_id' => $dilan->id,
            ]);
        }

        if (!Story::where('title', 'Memorias Digitales')->exists()) {
            Story::create([
                'title' => 'Memorias Digitales',
                'description' => 'En el año 2084, los recuerdos se pueden comprar y vender.',
                'user_id' => $dilan->id,
            ]);
        }

        // 4. CREAR LIBROS PARA LA TIENDA (Solo si hay pocos libros)
        $generos = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica'];
        
        // Si hay menos de 10 libros en la tienda, rellenamos hasta llegar a 50
        $librosActuales = Book::count();
        if ($librosActuales < 10) {
            $librosACrear = 50 - $librosActuales;
            for ($i = 0; $i < $librosACrear; $i++) {
                $esDigital = rand(1, 100) <= 60; 
                $vieneDeAutor = rand(1, 100) <= 30; 
                $autorAleatorio = $vieneDeAutor ? $autoresFicticios[array_rand($autoresFicticios)]->id : null;
                
                $tituloAleatorio = 'El ' . $sustantivos[array_rand($sustantivos)] . ' ' . $adjetivos[array_rand($adjetivos)];
                if (rand(1, 2) == 1) { 
                    $tituloAleatorio .= ' Parte ' . rand(1, 3);
                }

                Book::create([
                    'title' => $tituloAleatorio,
                    'genre' => $generos[array_rand($generos)],
                    'description' => 'Un fascinante viaje literario que explora las profundidades de la emoción humana.',
                    'price' => rand(400, 3500) / 100,
                    'stock' => $esDigital ? 9999 : rand(0, 50),
                    'is_digital' => $esDigital,
                    'status' => (rand(1, 100) <= 10) ? 'out_of_stock' : 'available',
                    'image' => null,
                    'user_id' => $autorAleatorio,
                    'story_id' => null,
                ]);
            }
        }

        echo "¡Semilla ejecutada en modo NO destructivo! ✨\n";
        echo "- Tus datos manuales no se han borrado.\n";
        echo "- Se han inyectado datos de prueba solo donde faltaban.\n";
    }
}