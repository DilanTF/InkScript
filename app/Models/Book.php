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
}