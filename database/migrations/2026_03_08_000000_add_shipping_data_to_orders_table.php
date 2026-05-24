<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade las columnas de envío y regalo a la tabla de pedidos.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Datos de dirección de envío
            $table->string('shipping_address')->nullable()->after('status');
            $table->string('shipping_city')->nullable()->after('shipping_address');
            $table->string('shipping_postal_code')->nullable()->after('shipping_city');
            $table->string('shipping_country')->nullable()->after('shipping_postal_code');
            
            // Datos del módulo de regalo que implementamos
            $table->boolean('is_gift')->default(false)->after('shipping_country');
            $table->string('gift_email')->nullable()->after('is_gift');
        });
    }

    /**
     * Revierte la migración eliminando las columnas.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address', 
                'shipping_city', 
                'shipping_postal_code', 
                'shipping_country',
                'is_gift',
                'gift_email'
            ]);
        });
    }
};