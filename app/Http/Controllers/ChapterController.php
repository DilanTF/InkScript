<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Muestra el formulario para crear un capítulo.
     * Recibe el objeto Story mediante Route Model Binding.
     */
    public function create(Story $story)
    {
        // Retornamos la vista que ya tienes abierta, pasando la historia
        return view('chapters.create', compact('story'));
    }

    /**
     * Guarda el capítulo en la base de datos vinculado a la historia.
     */
    public function store(Request $request, Story $story)
    {
        // 1. Validamos los datos de entrada
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. Calculamos el número de orden (ej: si hay 2 capítulos, este será el 3)
        $orderNumber = $story->chapters()->count() + 1;

        // 3. Creamos el capítulo usando la relación definida en el modelo Story
        $story->chapters()->create([
            'title' => $request->title,
            'content' => $request->content,
            'order_number' => $orderNumber,
        ]);

        // 4. Redirigimos al usuario a la vista de la historia con un mensaje de éxito
        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo publicado con éxito en ' . $story->title . '!');
    }

    /**
     * Muestra un capítulo específico y sus comentarios.
     */
    public function show(Story $story, Chapter $chapter)
    {
        // Cargamos los comentarios del capítulo con los datos del usuario que comentó
        $chapter->load('comments.user');
        
        return view('chapters.show', compact('story', 'chapter'));
    }
}