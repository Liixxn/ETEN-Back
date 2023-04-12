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
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('id_receta')->unsigned();
            $table->string('nombre_ingrediente', 255);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_receta')->references('id')->on('recetas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredientes');
    }
};
