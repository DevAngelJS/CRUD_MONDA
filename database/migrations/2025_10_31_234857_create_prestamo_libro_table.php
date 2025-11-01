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
        Schema::create('prestamo_libro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('descripcion')->nullable();
            $table->integer('estatus')->default(1);
            $table->timestamps();
        });

        Schema::create('detalle_prestamo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamo_libro')->cascadeOnDelete();
            $table->foreignId('libro_id')->constrained('libros')->cascadeOnDelete();
            $table->integer('cantidad');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo_libro');
    }
};
