<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Story extends Model
{
    /**
     * Los atributos que se pueden rellenar de forma masiva.
     * Esto evita el error de "Mass Assignment".
     */
    protected $fillable = [
        'title', 
        'description', 
        'user_id', 
        'cover_image'
    ];

    /**
     * Una historia tiene muchos capítulos.
     */
    public function chapters(): HasMany 
    { 
        return $this->hasMany(Chapter::class); 
    }

    /**
     * Una historia pertenece a un usuario (Autor).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
