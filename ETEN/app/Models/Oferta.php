<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oferta extends Model
{
    use HasFactory, SoftDeletes;

    // Relacion con la tabla de usuarios
    public function visualizaciones() {
        return $this->belongsToMany(Usuario::class);
    }
}
