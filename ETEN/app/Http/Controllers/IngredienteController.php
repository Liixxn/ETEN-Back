<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{

    public function obtenerRecetaIngrediente($nombreIngrediente) {

        $ingredienteReceta = Ingrediente::where("nombre_ingrediente", 'ilike', $nombreIngrediente)->get();

        return json_encode($ingredienteReceta);

    }
    public function obtenerIngredientes(Request $request){
        //$ingredientes = Ingrediente::where('id_receta', $request->id);
        $ingredientes = Ingrediente::where('id_receta', $request->id)->get();
        return json_encode($ingredientes);
      }
}
