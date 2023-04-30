<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{

    public function obtenerRecetaIngrediente(Request $request) {

        //$ingredientes = $request->ingredientes;
        //$ingredienteReceta = Ingrediente::whereIn("nombre_ingrediente", 'LIKE', '%'.$ingredientes.'%')->get();
        //$recetas = Receta::whereIn('id', $ids)->get();

        $ingredientes = $request->ingredientes;

        $receta = Ingrediente::whereIn('nombre_ingrediente', 'LIKE', $ingredientes)->get();



        //$searchString = '%' . implode('%', $ingredientes) . '%';

//        $receta = [];
//
//        for ($i=0; $i < count($ingredientes); $i++) {
//            $searchString = '%' . $ingredientes[$i] . '%';
//            $ingredienteReceta = Ingrediente::where('nombre_ingrediente', 'LIKE', $searchString)->get();
//            array_push($receta, $ingredienteReceta);
//        }



        return json_encode($receta);

    }
    public function obtenerIngredientes(Request $request){
        //$ingredientes = Ingrediente::where('id_receta', $request->id);
        $ingredientes = Ingrediente::where('id_receta', $request->id)->get();
        return json_encode($ingredientes);
      }
}
