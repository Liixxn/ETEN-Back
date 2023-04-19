<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{

    public function obtenerRecetaIngrediente(Request $request) {

        $ingredienteReceta = Ingrediente::where("nombre_ingrediente", 'LIKE', '%'.$request->nombre_ingrediente.'%')->get();

        return json_encode($ingredienteReceta);

    }
}
