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
        // Buscamos los volúmenes únicos que ya existen en esta historia
        $existingVolumes = $story->chapters()
            ->whereNotNull('volume_title')
            ->where('volume_title', '!=', '')
            ->distinct()
            ->pluck('volume_title');

        return view('chapters.create', compact('story', 'existingVolumes'));
    }

    /**
     * Almacena el capítulo en la base de datos
     */
    public function store(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'volume_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        $orderNumber = $story->chapters()->max('order_number') + 1;

        $story->chapters()->create([
            'title' => $request->title,
            'volume_title' => $request->volume_title,
            'content' => $request->content,
            'order_number' => $orderNumber,
            'price' => $request->price ?? 0.00,
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo publicado con éxito!');
    }

    /**
     * Muestra un capítulo específico (Protegido por Freemium)
     */
    public function show(Story $story, Chapter $chapter)
    {
        $user = auth()->user();
        $isAuthor = $user && $user->id === $story->user_id;
        $isPremium = $chapter->price > 0;
        $userOwnsChapter = $user ? $user->purchasedChapters->contains($chapter->id) : false;

        if ($isPremium && !$isAuthor && !$userOwnsChapter) {
            return redirect()->route('stories.show', $story)->with('error', 'Debes desbloquear este capítulo premium para poder leerlo.');
        }

        $chapter->load('comments.user');
        
        // Buscar el capítulo anterior (el que tenga un order_number menor, ordenado de mayor a menor)
        $previousChapter = \App\Models\Chapter::where('story_id', $story->id)
                            ->where('order_number', '<', $chapter->order_number)
                            ->orderBy('order_number', 'desc')
                            ->first();

        // Buscar el capítulo siguiente (el que tenga un order_number mayor)
        $nextChapter = \App\Models\Chapter::where('story_id', $story->id)
                            ->where('order_number', '>', $chapter->order_number)
                            ->orderBy('order_number', 'asc')
                            ->first();
        
        return view('chapters.show', compact('story', 'chapter', 'previousChapter', 'nextChapter'));
    }

    /**
     * Muestra el formulario para EDITAR un capítulo existente.
     */
    public function edit(Story $story, Chapter $chapter)
    {
        if (auth()->id() !== $story->user_id) {
            abort(403, 'No tienes permiso para editar este capítulo.');
        }

        // Buscamos los volúmenes únicos para pasarlos al Datalist
        $existingVolumes = $story->chapters()
            ->whereNotNull('volume_title')
            ->where('volume_title', '!=', '')
            ->distinct()
            ->pluck('volume_title');

        return view('chapters.edit', compact('story', 'chapter', 'existingVolumes'));
    }

    /**
     * Actualiza los datos del capítulo
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
            'price' => 'nullable|numeric|min:0',
        ]);

        $chapter->update([
            'title' => $request->title,
            'volume_title' => $request->volume_title,
            'content' => $request->content,
            'price' => $request->price ?? 0.00,
        ]);

        return redirect()->route('stories.show', $story)
            ->with('success', '¡Capítulo actualizado correctamente!');
    }

    /**
     * Procesa la compra de un capítulo (Freemium)
     */
    public function buy(Chapter $chapter)
    {
        $user = auth()->user();

        if ($chapter->price <= 0 || $user->purchasedChapters->contains($chapter->id)) {
            return back()->with('info', 'Ya tienes acceso a este capítulo.');
        }

        $user->purchasedChapters()->attach($chapter->id);

        return back()->with('success', '¡Has desbloqueado "' . $chapter->title . '" con éxito!');
    }
}