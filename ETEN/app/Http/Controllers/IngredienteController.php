<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredienteController extends Controller
{

    public function obtenerRecetaIngrediente(Request $request) {

        $ingredientes = $request->ingredientes;

        $queryWhere = "1=1";
        foreach ($ingredientes as $ingrediente) {
            $ingredienteS = "%{$ingrediente}%";
            $queryWhere .= " AND (SELECT count(1) FROM ingredientes wHERE nombre_ingrediente LIKE '[$ingredienteS]' and id_receta=recetas.id) > 0";

        }
        $recetas = DB::table('recetas')->whereRaw($queryWhere)->get();

        return json_encode($recetas);

    }
    public function obtenerIngredientes(Request $request){
        //$ingredientes = Ingrediente::where('id_receta', $request->id);
        $ingredientes = Ingrediente::where('id_receta', $request->id)->get();
        return json_encode($ingredientes);
      }
}
