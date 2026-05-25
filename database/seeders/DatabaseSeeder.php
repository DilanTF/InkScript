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
        // 1. TUS USUARIOS PRINCIPALES
        $dilan = User::firstOrCreate(
            ['email' => 'dilan@inkscript.com'],
            ['name' => 'Dilan Autor', 'password' => Hash::make('password123'), 'role' => 'author']
        );

        $lector = User::firstOrCreate(
            ['email' => 'lector@inkscript.com'],
            ['name' => 'Lector Entusiasta', 'password' => Hash::make('password123'), 'role' => 'reader']
        );

        // 2. CREAR AUTORES FICTICIOS (Aumentado a 10)
        $nombresAutores = [
            'Laura Valenzuela', 'Marcos Domínguez', 'Sofía Reyes', 'Carlos Ruiz', 
            'Elena Martín', 'David Costa', 'Ana Silva', 'Jorge Ramos', 
            'Lucía Gómez', 'Pablo Torres', 'Isabel Fernández', 'Miguel Ángel López', 'Carmen Díaz', 'Andrés García', 'Marta Sánchez', 'Diego Herrera', 'Sara Jiménez', 'Fernando Castro', 'Natalia Ortiz', 'Ricardo Morales'
        ];
        $autoresFicticios = [];

        foreach ($nombresAutores as $index => $nombre) {
            $autoresFicticios[] = User::firstOrCreate(
                ['email' => "autor{$index}@inkscript.com"],
                ['name' => $nombre, 'password' => Hash::make('password123'), 'role' => 'author']
            );
        }

        $usuariosComentaristas = array_merge([$lector], $autoresFicticios);

        // --- DICCIONARIO PARA TEXTOS ---
        $sustantivos = ['Secreto', 'Destino', 'Reino', 'Corazón', 'Caballero', 'Mundo', 'Laberinto', 'Espejo', 'Alma', 'Silencio', 'Viento', 'Mar', 'Fuego', 'Dragón', 'Cielo', 'Bosque', 'Sombra', 'Luz', 'Niebla', 'Eclipse', 'Leyenda'];
        $adjetivos = ['Oscuro', 'Brillante', 'Perdido', 'Eterno', 'Roto', 'Misterioso', 'Oculto', 'Sagrado', 'Letal', 'Mágico', 'Rojo', 'Helado', 'Infinito', 'Salvaje', 'Sombra', 'Radiante', 'Profundo', 'Veloz', 'Feroz', 'Trágico'];
        $generos = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica', 'Apocalipsis', 'Distopía', 'Realismo Mágico', 'Thriller', 'Ficción General', 'Novela Negra', 'Cyberpunk', 'Steampunk'];
        
        $parrafosContenido = [
            "El viento soplaba frío aquella noche. Nadie en el pueblo sospechaba lo que estaba a punto de ocurrir. Las sombras parecían alargarse de forma antinatural, reptando por las paredes.",
            "Habían pasado años desde la última vez que alguien pronunció su nombre en voz alta. Algunos decían que era una maldición; otros, simplemente un mito olvidado por el tiempo.",
            "Cruzó el pasillo a pasos rápidos y silenciosos. En su mano derecha, sostenía el único artefacto capaz de detener la catástrofe.",
            "«No puedes huir de lo que llevas dentro», resonó la voz en su cabeza. Intentó ignorarla, pero la verdad era incuestionable.",
            "Finalmente, la luz del alba rompió el horizonte. El paisaje se tiñó de un naranja pálido que trajo consigo una frágil esperanza.",
            "El mundo estaba a punto de cambiar para siempre.",
            "Aquel día, el destino de todos se entrelazó de formas que nadie podría haber previsto. Lo que comenzó como un simple encuentro se convirtió en una aventura épica que desafiaría los límites de la realidad.",
            "Sus ojos se encontraron por primera vez en medio de la multitud. Fue un instante fugaz, pero ambos supieron que algo especial había nacido en ese momento.",
            "El misterio se profundizaba con cada pista que descubrían. Parecía que el enemigo siempre estaba un paso por delante, burlándose de sus esfuerzos por detenerlo.",
            "En el corazón de la tormenta, encontraron la fuerza para seguir adelante. No importaba lo que les esperara, estaban decididos a enfrentarlo juntos, sin importar el costo."
        ];
        $textosComentarios = [
            "¡Me ha encantado este capítulo! La tensión está increíble.",
            "No me esperaba ese giro final. ¡Necesito el siguiente ya!",
            "La forma en que describes los escenarios hace que me lo imagine como una película.",
            "Tengo una teoría sobre lo que va a pasar... espero no equivocarme.",
            "Un poco lento al principio, pero el final compensa con creces.",
            "Increíble, simplemente increíble. Ya soy fan número uno de esta historia.",
            "¿Cuándo subes la próxima parte? Me has dejado con la intriga.",
            "La relación entre los personajes es tan realista, me siento como si los conociera de verdad.",
            "¡Este capítulo me ha dejado sin aliento! La narrativa es magistral.",
            "Me encanta cómo mezclas el misterio con la acción. Es adictivo.",
            "Cada vez que leo un capítulo, me quedo pensando en las posibles teorías. ¡Eres un genio de la escritura!"
        ];

        // 3. CREAR MULTITUD DE HISTORIAS DE PRUEBA
        // Verificamos cuántas historias hay para no saturar si lo ejecutas varias veces
        if (Story::count() < 25) {
            foreach ($autoresFicticios as $autor) {
                // Generar entre 2 y 4 historias por cada autor
                $numHistorias = rand(2, 4);
                for ($i = 0; $i < $numHistorias; $i++) {
                    $story = Story::create([
                        'title' => 'El ' . $sustantivos[array_rand($sustantivos)] . ' ' . $adjetivos[array_rand($adjetivos)],
                        'description' => 'Una intrigante historia llena de misterios, aventuras y giros inesperados que atrapará al lector desde el primer capítulo.',
                        'genre' => $generos[array_rand($generos)], // Añadimos el género aleatorio
                        'user_id' => $autor->id,
                    ]);

                    // Añadir entre 3 y 8 capítulos por historia
                    $numCapitulos = rand(3, 8);
                    for ($j = 1; $j <= $numCapitulos; $j++) {
                        $contenidoCapitulo = $parrafosContenido[array_rand($parrafosContenido)] . "\n\n" . 
                                             $parrafosContenido[array_rand($parrafosContenido)] . "\n\n" .
                                             "Continuará...";

                        $chapter = Chapter::create([
                            'story_id' => $story->id,
                            'title' => 'Capítulo ' . $j,
                            'content' => $contenidoCapitulo,
                            'order_number' => $j,
                            'created_at' => now()->subDays(rand(1, 30))
                        ]);

                        // Generar comentarios masivos (80% de probabilidad de tener comentarios)
                        if (rand(1, 100) <= 80) {
                            $numComentarios = rand(1, 6);
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
                }
            }
        }

        // 4. CREAR LIBROS PARA LA TIENDA
        $librosActuales = Book::count();
        if ($librosActuales < 40) {
            $librosACrear = 50 - $librosActuales;
            for ($i = 0; $i < $librosACrear; $i++) {
                $esDigital = rand(1, 100) <= 60; 
                $vieneDeAutor = rand(1, 100) <= 30; 
                $autorAleatorio = $vieneDeAutor ? $autoresFicticios[array_rand($autoresFicticios)]->id : null;
                
                Book::create([
                    'title' => 'La leyenda del ' . $sustantivos[array_rand($sustantivos)] . ' ' . $adjetivos[array_rand($adjetivos)],
                    'genre' => $generos[array_rand($generos)],
                    'description' => 'Un fascinante viaje literario editado en formato profesional, listo para devorar.',
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

        echo "¡Inyección de datos masiva completada! 📚✨\n";
    }
}