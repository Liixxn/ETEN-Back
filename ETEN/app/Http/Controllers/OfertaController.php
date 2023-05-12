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

    public function sumarVisita(Request $request)
    {
        $oferta = Oferta::findOrFail($request->id); 
        $user = $request->user();
        //si el usuario ha visitado la oferta, se suma una visita
        if($user->hasVisited($oferta->id)){
            $oferta->visitas = $oferta->visitas + 1;
            $oferta->save();
        }
        //si no la ha visitado, se crea la visita
        else{
            $user->visitas()->attach($oferta->id);
            $oferta->visitas = 1;
            $oferta->save();
        }
    }    
    
}
