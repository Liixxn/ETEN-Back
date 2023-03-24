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
        Schema::create('usuario_oferta', function (Blueprint $table) {
            $table->bigInteger('id_usuario')->unsigned();
            $table->bigInteger('id_oferta')->unsigned();
            $table->integer('visitas');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['id_usuario', 'id_oferta']);
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_oferta')->references('id')->on('ofertas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_oferta');
    }
};
