<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Chapter; // Importante para la relación
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Chapter $chapter) // Laravel busca el capítulo por ti
    {
        // Validamos el contenido del comentario
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Usamos la relación para crear el comentario (más limpio)
        $chapter->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', '¡Tu comentario ha sido publicado!');
    }
}