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
        $receta = Receta::where("titulo", $titulo)->first();
        return "Receta: $titulo";
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

    public function obtenerRecetaId($id) {

        $recetaEncontrada = Receta::find($id);

        return json_encode($recetaEncontrada);

    }
}
