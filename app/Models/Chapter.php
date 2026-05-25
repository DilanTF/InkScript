<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $fillable = ['story_id', 
        'title',
        'volume_title',
        'content',
        'order_number',
        'price'];


    /**
     * Usuarios que han comprado este capítulo.
     */
    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'chapter_user')->withTimestamps();
    }
   
    /**
     * Relación con la historia.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * NUEVA RELACIÓN: Un capítulo ahora tiene sus propios comentarios.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
}