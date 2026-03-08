<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_amount', 'status'];

    /**
     * Relación con los detalles del pedido.
     * Esto es lo que permite hacer $order->items()->create(...)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}