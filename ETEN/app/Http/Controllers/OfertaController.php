<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Oferta;


class OfertaController extends Controller
{
    public function ObtenerOfertas()
    {
        $oferta = Oferta::getAll();
        return "Receta: $oferta";
    }
}
