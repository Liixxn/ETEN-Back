<?php

namespace App\Http\Controllers;

use App\Models\Config_recetasOfertas;
use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredienteController extends Controller
{

    public function obtenerRecetaIngrediente(Request $request)
    {

        $ingredientes = $request->ingredientes;

        $recetasTotales = Receta::where('activo', 1)->get(['id', 'titulo', 'img']);

        $configNum = Config_recetasOfertas::where('tipo', 0)->get();

        if ($configNum->count() > 0) {
            $mostrar = $configNum->last()->num_recetasPagina;
        }
        else {
            $mostrar = 12;
        }

        $offset = ($request->pagina - 1) * $mostrar;


        if (count($ingredientes) > 0) {

            $queryWhere = "1=1";
            $params=[];
            foreach ($ingredientes as $ingrediente) {
                $params[] = "%" . $ingrediente . "%";
                $queryWhere .= " AND (SELECT count(1) FROM ingredientes wHERE nombre_ingrediente LIKE ? and id_receta=recetas.id) > 0";
            }
            $recetasResultados = DB::table('recetas')->whereRaw($queryWhere, $params);

            $tamanio = $recetasResultados->count();

            if ($tamanio > 0) {
                $recetas = $recetasResultados->select('id', 'titulo', 'img')->offset($offset)->limit($mostrar)->get();

                return [$recetas, $tamanio, sizeof($recetas) , $mostrar];
            }
        }
        $tamanio = count($recetasTotales);
        $tamanioComprobacion = 0;
        $recetas = Receta::select('id', 'titulo', 'img')->where('activo', 1)->offset($offset)->limit($mostrar)->get();


        return [$recetas, $tamanio, $tamanioComprobacion, $mostrar];
    }

    public function obtenerIngredientes($id_receta)
    {
        $ingredientes = Ingrediente::where('id_receta', $id_receta)->get();
        return json_encode($ingredientes);
    }
}
