<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Story extends Model
{
    protected $fillable = [
        'title',
        'description',
        'genre',
        'user_id',
    ];

    /**
     * Una historia pertenece a un autor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Una historia tiene muchos capítulos.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order_number', 'asc');
    }

    /**
     * NUEVO: Una historia puede ser seguida por muchos usuarios.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'story_user')->withTimestamps();
    }
}