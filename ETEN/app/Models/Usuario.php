<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticable implements JWTSubject
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


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ["usuario"=>$this];
    }

}
