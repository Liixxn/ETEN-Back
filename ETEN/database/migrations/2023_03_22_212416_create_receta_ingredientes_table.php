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
        Schema::create('receta_ingrediente', function (Blueprint $table) {
            $table->bigInteger('id_receta')->unsigned();
            $table->bigInteger('id_ingrediente')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['id_receta', 'id_ingrediente']);
            $table->foreign('id_receta')->references('id')->on('recetas');
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_ingrediente');
    }
};
