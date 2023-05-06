<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

//importacion de los modelos
use App\Models\Receta;


class RecetaController extends Controller
{
    public function VerReceta($nombreReceta)
    {
        $receta = Receta::where("titulo", $nombreReceta)->first();
        return "Receta: $nombreReceta";
    }


    public function BuscarReceta($titulo)
    {
        $receta = Receta::where("titulo", 'LIKE', '%'. $titulo.'%')->get();
        return  $receta;
    }


    public function updateEstadoReceta(Request $request)
    {
        $receta = Receta::findOrFail($request->id); //obtiene la receta a actualizar
        $receta->activo = $request->activo;
        $receta->save();
        return "Receta actualizada";
    }


    public function ObtenerRecetas()
    {
        $recetas = Receta::get(['id', 'titulo', 'img'])->toArray();
        return $recetas;
    }


    public function ObtenerUnaReceta($id)
    {
        $receta = Receta::find($id);
        return $receta;
    }

    public function ObtenerRecetasPorCategoria($num_categoria, $pagina)
    {

        $recetas = Receta::get(['id', 'titulo', 'img']);
        $tamanio = $recetas->count();

        $mostrar = 12;

        if ($num_categoria!=0) {

            $recetasResultados = Receta::where("categoria", $num_categoria);

            $tamanio = $recetasResultados->count();

            $offset = ($pagina - 1) * 12;

            $recetas = $recetasResultados->select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();

            return [$recetas, $tamanio];

        }

        return [$recetas, $tamanio];

    }

    public function ObtenerRecetasPorId(Request $request)
    {
        $ids = $request->ids;
        $recetas = Receta::whereIn('id', $ids)->get();

        return $recetas;

    }
}
