<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory, SoftDeletes;

    // Relacion con la tabla ingredientes
    public function ingredientes():  MorphToMany{
        return $this->morphToMany(Ingrediente::class);
    }

    // Relacion con la tabla comentarios
    public function comentarios(): HasMany {
        return $this->hasMany(comentario::class);

    }
}


