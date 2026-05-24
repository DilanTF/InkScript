<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Añadimos los nuevos campos al array $fillable para permitir su guardado masivo
    protected $fillable = [
        'user_id', 
        'total_amount', 
        'status',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'is_gift',
        'gift_email'
    ];

    /**
     * Un pedido pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un pedido tiene muchos detalles (libros comprados).
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}