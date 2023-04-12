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


    public function favoritas() {
        return $this->belongsToMany(Usuario::class);
    }


    // Relacion con la tabla ingredientes
    public function ingredientes():  HasMany{
        return $this->hasMany(Ingrediente::class);
    }

}


