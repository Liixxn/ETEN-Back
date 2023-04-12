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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id('id');
            $table->string('categoria');
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('img')->nullable();
            $table->text('ingredientes');
            $table->string('duracion')->nullable();
            $table->string('comensales')->nullable();
            $table->string('dificultad')->nullable();
            $table->boolean('activo')->default(True);
            $table->float('sentimiento_pos')->nullable();
            $table->float('sentimiento_neg')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
