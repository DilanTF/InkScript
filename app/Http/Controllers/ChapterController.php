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
     * Almacena el capítulo en la base de datos (AHORA GUARDA EL VOLUMEN).
     */
    public function store(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'volume_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'price' => 'nullable|numeric|min:0', // <-- NUEVO: Validamos el precio
        ]);

        $orderNumber = $story->chapters()->max('order_number') + 1;

        $story->chapters()->create([
            'title' => $request->title,
            'volume_title' => $request->volume_title,
            'content' => $request->content,
            'order_number' => $orderNumber,
            'price' => $request->price ?? 0.00, // <-- NUEVO: Si no pone nada, es 0 (gratis)
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo publicado con éxito!');
    }

    /**
     * Muestra un capítulo específico, sus comentarios y la navegación.
     */
    public function show(Story $story, Chapter $chapter)
    {
        $chapter->load('comments.user');
        
        $previousChapter = $story->chapters()->where('id', '<', $chapter->id)->orderBy('id', 'desc')->first();
        $nextChapter = $story->chapters()->where('id', '>', $chapter->id)->orderBy('id', 'asc')->first();
        
        return view('chapters.show', compact('story', 'chapter', 'previousChapter', 'nextChapter'));
    }

    /**
     * Muestra el formulario para EDITAR un capítulo existente.
     */
    public function edit(Story $story, Chapter $chapter)
    {
        // Seguridad: Solo el autor de la historia puede editar el capítulo
        if (auth()->id() !== $story->user_id) {
            abort(403, 'No tienes permiso para editar este capítulo.');
        }

        return view('chapters.edit', compact('story', 'chapter'));
    }

    /**
     * Actualiza los datos del capítulo en la base de datos.
     */
    public function update(Request $request, Story $story, Chapter $chapter)
    {
        if (auth()->id() !== $story->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'volume_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'price' => 'nullable|numeric|min:0', // <-- Validamos precio
        ]);

        $chapter->update([
            'title' => $request->title,
            'volume_title' => $request->volume_title,
            'content' => $request->content,
            'price' => $request->price ?? 0.00, // <-- Actualizamos precio
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo actualizado correctamente!');
    }
}