<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingrediente extends Model
{
    use HasFactory, SoftDeletes;

    public function recetas(): BelongsTo{
        return $this->belongsTo(Receta::class);
    }
}
