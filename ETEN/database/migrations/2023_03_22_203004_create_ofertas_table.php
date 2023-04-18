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
        #hay que cambiar la base de datos, los campos
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombreOferta');
            $table->float('precioActual');
            $table->float('precioAnterior');
            $table->string('imagenOferta')->nullable();
            $table->string('urlOferta');
            $table->string('supermercado')->nullable();
            $table->string('categoria')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
