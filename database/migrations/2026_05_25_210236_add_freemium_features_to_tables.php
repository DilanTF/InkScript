<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Añadir estado a las historias
        Schema::table('stories', function (Blueprint $table) {
            $table->string('status')->default('En Emisión')->after('genre');
        });

        // 2. Añadir precio a los capítulos
        Schema::table('chapters', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default(0.00)->after('order_number');
        });

        // 3. Tabla intermedia para registrar qué usuarios compran qué capítulos
        Schema::create('chapter_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_user');
        
        Schema::table('chapters', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};