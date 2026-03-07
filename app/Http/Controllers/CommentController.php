<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Guarda un nuevo comentario en la base de datos.
     */
    public function store(Request $request, Story $story)
    {
        // 1. Validamos que el comentario no esté vacío
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // 2. Creamos el comentario vinculado al usuario actual y a la historia
        $story->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        // 3. Volvemos atrás con un mensaje de éxito
        return back()->with('success', '¡Comentario publicado!');
    }
}