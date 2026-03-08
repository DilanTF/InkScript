<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añadimos solo los campos que faltan y las relaciones.
     * Nota: price y stock ya existen en la tabla según tu primer archivo.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // 1. Añadimos descripción (necesaria para la tienda)
            if (!Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            // 2. Añadimos género
            if (!Schema::hasColumn('books', 'genre')) {
                $table->string('genre')->nullable()->after('description');
            }

            // 3. Añadimos la relación con la historia (para ventas de autores)
            if (!Schema::hasColumn('books', 'story_id')) {
                $table->foreignId('story_id')->nullable()->constrained()->onDelete('set null');
            }

            // 4. Añadimos la relación con el usuario (quién vende el libro)
            if (!Schema::hasColumn('books', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }

            // 5. Añadimos el campo is_digital
            if (!Schema::hasColumn('books', 'is_digital')) {
                $table->boolean('is_digital')->default(false)->after('stock');
            }
        });
    }

    /**
     * Deshacemos los cambios si es necesario.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['story_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['description', 'genre', 'story_id', 'user_id']);
            $table->dropColumn(['description', 'genre', 'story_id', 'user_id', 'is_digital']);
        });
    }
};