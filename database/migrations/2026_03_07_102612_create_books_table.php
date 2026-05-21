<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            
            // Datos básicos del libro
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('genre')->nullable();
            
            // Datos de la tienda
            $table->decimal('price', 8, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            
            // Lógica y estados
            $table->boolean('is_digital')->default(false);
            $table->string('status')->default('available'); // 'available' o 'out_of_stock'
            
            // Relaciones
            // De qué historia viene (si viene de la plataforma)
            $table->foreignId('story_id')->nullable()->constrained()->onDelete('set null');
            // Quién lo vende (Autor o la propia plataforma si es null)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};