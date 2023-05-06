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

        $recetasTotales = Receta::get(['id', 'titulo', 'img']);
        $tamanio = count($recetasTotales);

        $nIngredientes = 12;
        $offset = ($request->pagina - 1) * 12;

        $nIngredientes = count($ingredientes);

        if ($nIngredientes > 0) {

            $queryWhere = "1=1";
            foreach ($ingredientes as $ingrediente) {
                $ingredienteS = "%" . $ingrediente . "%";
                $queryWhere .= " AND (SELECT count(1) FROM ingredientes wHERE nombre_ingrediente LIKE '$ingredienteS' and id_receta=recetas.id) > 0";

            }
            $recetasResultados = DB::table('recetas')->whereRaw($queryWhere);

            $tamanio = $recetasResultados->count();

            if ($tamanio > 0) {
                $recetas = $recetasResultados->select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();

                return [$recetas, $tamanio, sizeof($recetas)];
            }

        }
        $tamanio = count($recetasTotales);
        $nIngredientes = 0;
        $recetas = Receta::select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();


        return [$recetas, $tamanio, $nIngredientes];

    }
    public function obtenerIngredientes(Request $request){
        //$ingredientes = Ingrediente::where('id_receta', $request->id);
        $ingredientes = Ingrediente::where('id_receta', $request->id)->get();
        return json_encode($ingredientes);
      }
}
