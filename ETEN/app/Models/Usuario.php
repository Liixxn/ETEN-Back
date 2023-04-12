<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    // Relacion con la tabla de recetas
    public function favoritas() {
        return $this->belongsToMany(Receta::class);
    }

    // Relacion con la tabla de ofertas
    public function ofertas() {
        return $this->belongsToMany(Oferta::class);
    }

}
