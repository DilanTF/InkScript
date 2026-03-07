<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    /**
     * Muestra el listado de historias del usuario autenticado.
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        
        // Ahora el editor reconocerá que $user tiene la relación 'stories'
        $stories = $user->stories; 
        
        return view('stories.index', compact('stories'));
    }

    /**
     * Muestra el formulario para crear una nueva historia.
     */
    public function create()
    {
        return view('stories.create');
    }

    /**
     * Almacena una nueva historia en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos del formulario
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
        ]);

        // 2. Obtención del usuario y creación de la relación
        /** @var User $user */
        $user = auth()->user();

        $user->stories()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // 3. Redirección con mensaje de confirmación
        return redirect()->route('stories.index')->with('success', '¡Historia creada correctamente en InkScript!');
    }

    /**
     * Muestra una historia específica y sus capítulos.
     */
    public function show(Story $story) {
        $story->load(['chapters', 'comments.user']); // Cargamos capítulos y comentarios con sus autores
        return view('stories.show', compact('story'));
    }

    /**
     * Muestra el formulario para editar una historia existente.
     */
    public function edit(Story $story)
    {
        return view('stories.edit', compact('story'));
    }

    /**
     * Actualiza la historia en la base de datos.
     */
    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
        ]);
        $story->update($request->all());
        return redirect()->route('stories.index')->with('success', 'Historia actualizada con éxito.');
    }

    /**
     * Elimina la historia de la base de datos.
     */
    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Historia eliminada correctamente.');
    }
}