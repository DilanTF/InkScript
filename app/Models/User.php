<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importante para que el editor reconozca la relación

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Añadimos el rol aquí para poder guardarlo en la base de datos
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * RELACIÓN: Un usuario tiene muchas historias.
     * Definir el tipo ': HasMany' ayuda a VS Code a no marcar errores rojos.
     */
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    /**
     * RELACIÓN: Un usuario tiene muchos comentarios.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
}