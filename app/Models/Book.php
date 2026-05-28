<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'user_id',
        'is_digital'
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

    /**
     * Relación con los ítems de pedidos.
     * Permite ver cuántas veces se ha vendido este libro.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accesor para obtener la ruta de la portada con lógica condicional.
     */
    public function getCoverUrlAttribute()
    {
        // 1. Si el libro tiene una imagen real subida en la base de datos, mostramos esa.
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // 2. Si NO tiene imagen, pero TIENE autor (Es un libro Indie de un usuario):
        if ($this->user_id) {
            return asset('images/story.png');
        }

        // 3. Si NO tiene imagen y NO tiene autor (Es un libro oficial del Sello InkScript):
        return asset('images/book.png');
    }
}