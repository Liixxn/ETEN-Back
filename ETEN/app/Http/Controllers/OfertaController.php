<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Oferta;


class OfertaController extends Controller
{
    public function obtenerTodasOfertas(Request $request)
    {
        $ofertas = Oferta::get(['id', 'titulo', 'img', 
        'precioActual', 'precioAnterior', 'urlOferta']);
        return json_encode($ofertas);
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
    
    public function obtenerOfertasPorCategoria(&num_categoria, &pagina)
    {
        $ofertas = Oferta::get(['id', 'titulo', 'img', 
        'precioActual', 'precioAnterior', 'urlOferta']);

        $size = $ofertas->count();

        $cantOfertas = 20;

        $listaOfertas = Oferta::where('categoria', $num_categoria);

        $size = $listaOfertas->count();

        &offset = ($pagina - 1) * $cantOfertas;

        $ofertas = $cantOfertas->select('id', 'titulo', 'img', 
        'precioActual', 'precioAnterior', 'urlOferta')->offset($offset)
        ->limit(20)->get();

        return [$ofertas, $size];
    }
    
}
