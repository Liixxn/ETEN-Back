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
    public function favoritas(): MorphToMany {
        return $this->morphToMany(Receta::class);
    }

    // Relacion con la tabla de ofertas
    public function ofertas(): MorphToMany {
        return $this->morphToMany(Oferta::class);
    }

}
