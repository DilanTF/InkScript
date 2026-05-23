<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo capítulo.
     */
    public function create(Story $story)
    {
        return view('chapters.create', compact('story'));
    }

    /**
     * Almacena el capítulo en la base de datos.
     */
    public function store(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Calculamos el número de orden (el último + 1)
        $orderNumber = $story->chapters()->max('order_number') + 1;

        $story->chapters()->create([
            'title' => $request->title,
            'content' => $request->content,
            'order_number' => $orderNumber,
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo publicado con éxito en ' . $story->title . '!');
    }

    /**
     * Muestra un capítulo específico, sus comentarios y la navegación.
     */
    public function show(Story $story, Chapter $chapter)
    {
        // Cargamos los comentarios del capítulo con los datos del usuario que comentó
        $chapter->load('comments.user');
        
        // Magia de navegación: Buscamos el capítulo anterior y siguiente de esta misma historia
        $previousChapter = $story->chapters()->where('id', '<', $chapter->id)->orderBy('id', 'desc')->first();
        $nextChapter = $story->chapters()->where('id', '>', $chapter->id)->orderBy('id', 'asc')->first();
        
        return view('chapters.show', compact('story', 'chapter', 'previousChapter', 'nextChapter'));
    }
}