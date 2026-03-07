<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'title', 
        'genre', 
        'description', 
        'price', 
        'stock', 
        'image', 
        'story_id', 
        'user_id'
    ];

    /**
     * Obtiene la historia de la cual procede este libro.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Obtiene el usuario/autor que vende este libro.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}