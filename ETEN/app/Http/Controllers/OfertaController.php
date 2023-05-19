<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Oferta;



class OfertaController extends Controller
{
    public function obtenerTodasOfertas()
    {
        $ofertas = Oferta::get(['id', 'nombreOferta', 
        'precioActual', 'precioAnterior', 'imagenOferta', 'urlOferta', 'categoria'])->toArray();
        return $ofertas;
    }

    public function sumarVisita(Request $request)
    {
        $oferta = Oferta::findOrFail($request->id); 
        $user = JWTAuth::user();
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
    
    public function obtenerOfertasPorCategoria($num_categoria, $pagina)
    {
        $ofertasTodas = Oferta::get();
        $sizeOfertasTotal = $ofertasTodas->count();
        $cantOfertas = 20;
        $offset = ($pagina - 1) * $cantOfertas;
        $listaOfertas = Oferta::where('categoria', $num_categoria); 
        
        if ($listaOfertas->count() != 0){
            $listaOfertas = Oferta::where('categoria', $num_categoria);
            $sizeOfertas = $listaOfertas->count();        
            $ofertas = $listaOfertas->offset($offset)
            ->limit(20)->get();

            return [$ofertas, $sizeOfertas, $cantOfertas];

        }

        $ofertas = Oferta::offset($offset)
            ->limit(20)->get();


        return [$ofertas, $sizeOfertasTotal, $cantOfertas];
    }
}
