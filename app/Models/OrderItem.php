<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'book_id', 'quantity', 'price'];

    /**
     * Relación con el libro comprado.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * NUEVA: Relación inversa con el pedido padre.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}