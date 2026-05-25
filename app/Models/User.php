<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Importación necesaria para "Seguidores"

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Un usuario puede escribir muchas historias.
     */
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    /**
     * Un usuario puede hacer muchos comentarios.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Un usuario puede realizar muchos pedidos (Compras en tienda).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * NUEVO: Un usuario puede seguir muchas historias de la comunidad.
     */
    public function followedStories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'story_user')->withTimestamps();
    }

    /**
     * Capítulos premium que el usuario ha comprado.
     */
    public function purchasedChapters()
    {
        return $this->belongsToMany(Chapter::class, 'chapter_user')->withTimestamps();
    }
}