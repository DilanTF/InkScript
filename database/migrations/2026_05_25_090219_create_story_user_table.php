<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla pivot convencional en Laravel (orden alfabético: story_user)
        Schema::create('story_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('story_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Guardará cuándo empezaste a seguir la historia
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_user');
    }
};