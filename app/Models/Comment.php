<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    // Campos que permitimos rellenar
    protected $fillable = ['content', 'user_id', 'chapter_id'];

    /**
     * Un comentario pertenece a un usuario (el autor del comentario).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un comentario pertenece a un capítulo.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }
}