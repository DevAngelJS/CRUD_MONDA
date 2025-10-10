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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->string('autor');
            $table->date('año_publicacion')->nullable();
            $table->string('genero')->nullable();
            $table->string('idioma')->nullable();
            $table->integer('cantidad_stock')->default(0);
            $table->integer('estatus')->default(1); // 1: Disponible, 0: No disponible
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
