<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para añadir la columna role.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadimos el campo role. Por defecto será 'reader' (lector).
            // Otros valores posibles: 'author', 'admin'.
            $table->string('role')->default('reader')->after('email');
        });
    }

    /**
     * Revierte la migración eliminando la columna.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
