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
            /*$table->id('id');
            $table->string('nombreOferta');
            $table->float('precioOferta');
            $table->string('imagenOferta')->nullable();
            $table->string('supermercado');
            $table->timestamps();
            $table->softDeletes();
            */
            $table->id();
            $table->string('titulo');
            $table->decimal('price', 10, 2);
            $table->decimal('price_less', 10, 2);
            $table->string('url_img');
            $table->string('url');
            $table->timestamps();
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
