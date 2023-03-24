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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('id_receta')->unsigned();
            $table->string('url_video');
            $table->text('descripcion');
            $table->float('sentimiento_pos');
            $table->float('sentimiento_neg');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_receta')->references('id')->on('recetas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
