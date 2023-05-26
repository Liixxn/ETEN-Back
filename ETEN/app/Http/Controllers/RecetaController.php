<?php

namespace App\Http\Controllers;

use App\Models\Config_recetasOfertas;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

//importacion de los modelos
use App\Models\Receta;
use App\Models\Usuario;
use App\Models\UsuarioReceta;
use Tymon\JWTAuth\Facades\JWTAuth;

class RecetaController extends Controller
{


    public function ObtenerNumRecetasCategoria() {

        $todasRecetas = Receta::get();
        $numRecetasTotales = $todasRecetas->count();

        $numArroz = count(Receta::where('categoria', 1)->get());
        $numBebida = count(Receta::where('categoria', 2)->get());
        $numCarne = count(Receta::where('categoria', 3)->get());
        $numDulce = count(Receta::where('categoria', 4)->get());
        $numPasta = count(Receta::where('categoria', 5)->get());
        $numPescado = count(Receta::where('categoria', 6)->get());
        $numVariado = count(Receta::where('categoria', 7)->get());
        $numVegetal = count(Receta::where('categoria', 8)->get());

        return [$numRecetasTotales, $numArroz, $numBebida, $numCarne, $numDulce, $numPasta, $numPescado, $numVariado, $numVegetal];
    }

    public function CambiarNumeroRecetasPagina(Request $request) {

        $config = new Config_recetasOfertas();

        if ($request->tipoCambio == 0) {
            $config->tipo = 0;
        }
        else {
            $config->tipo = 1;
        }

        $config->num_recetasPagina = $request->numReceta;
        $config->save();


        return json_encode($config);
    }



    public function ObtenerRecetasPorId(Request $request)
    {
        $ids = $request->ids;
        $recetas = Receta::whereIn('id', $ids)->get();
        return $recetas;
    }



    public function GuardarRecetaFavoritos($id_receta)
    {
        $mensaje = 'mensaje';
        $usuario = JWTAuth::user();
        $usuarioEncontrado = Usuario::find($usuario->id);
        $recetaEncontrada = Receta::find($id_receta);

        if (!is_null($usuarioEncontrado) && !is_null($recetaEncontrada)) {
            $favoritoEncontrado = UsuarioReceta::where('id_usuario', $usuarioEncontrado->id)->where('id_receta', $id_receta)->withTrashed()->count();
            if ($favoritoEncontrado == 0) {
                $nuevoFavorito = new UsuarioReceta();
                $nuevoFavorito->id_usuario = $usuarioEncontrado->id;
                $nuevoFavorito->id_receta = $id_receta;
                $nuevoFavorito->save();
            } else {
                $favoritoEncontrado = UsuarioReceta::where('id_usuario', $usuarioEncontrado->id)->where('id_receta', $id_receta)->restore();
            }
            $mensaje = "Receta Guardada en favoritos";
        } else {
            $mensaje = "Error en los datos";
        }
        return json_encode($mensaje);
    }

    public function EliminarRecetaFavoritos($id_receta)
    {
        $mensaje = 'mensaje';
        $usuario = JWTAuth::user();
        $usuarioEncontrado = Usuario::find($usuario->id);
        $recetaEncontrada = Receta::find($id_receta);
        if (!is_null($usuarioEncontrado) && !is_null($recetaEncontrada)) {
            $favoritoEncontrado = UsuarioReceta::where('id_usuario', $usuarioEncontrado->id)->where('id_receta', $id_receta);
            if (!is_null($favoritoEncontrado)) {
                UsuarioReceta::where('id_usuario', $usuarioEncontrado->id)->where('id_receta', $id_receta)->delete();
                $mensaje = 'Receta Eliminada de favoritos';
            } else {
                $mensaje = 'Este favorito no existe';
            }
        } else {
            $mensaje = "Error en los datos";
        }
        return json_encode($mensaje);
    }

    public function BuscarReceta(Request $request)
    {

        $recetaNumero = Receta::get();
        $tamnio = $recetaNumero->count();

        $configNum = Config_recetasOfertas::where('tipo', 0)->get();

        if ($configNum->count() > 0) {
            $mostrar = $configNum->last()->num_recetasPagina;
        }
        else {
            $mostrar = 12;
        }

        if ($request->titulo != "") {

            $titulo = $request->titulo;

            $recetasBuscar = Receta::where("titulo", 'LIKE', '%' . $titulo . '%');

            $mostrar = $recetasBuscar->count();

            if ($recetasBuscar->count() > 0) {

                $tamnio = $recetasBuscar->count();

                $offset = ($request->pagina - 1) * $mostrar;

                $recetas = $recetasBuscar->select('id', 'titulo', 'img')->offset($offset)->limit($mostrar)->get();

                return [$recetas, $tamnio, sizeof($recetas)];
            }
        }

        $offset = ($request->pagina - 1) * $mostrar;

        $recetas = Receta::select('id', 'titulo', 'img')->offset($offset)->limit($mostrar)->get();


        return [$recetas, $tamnio, $mostrar];
    }

    public function VerificarRecetaFavorita($id_receta)
    {
        $user = JWTAuth::user();
        $favoritoEncontrado = UsuarioReceta::where('id_usuario', $user->id)->where('id_receta', $id_receta)->count();
        if ($favoritoEncontrado == 0) {
            return json_encode(false);
        } else {
            return json_encode(true);
        }
    }

    public function updateEstadoReceta(Request $request)
    {
        $receta = Receta::findOrFail($request->id); //obtiene la receta a actualizar
        $receta->activo = $request->activo;
        $receta->save();
        return "Receta actualizada";
    }

    //para las estadisticas del admin todavia no implementada
    public function ObtenerRecetas()
    {
        $receta = Receta::get(['id', 'titulo', 'categoria', 'activo']);
        return json_encode($receta);
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

        $configNum = Config_recetasOfertas::where('tipo', 0)->get();

        if ($configNum->count() > 0) {
            $mostrar = $configNum->last()->num_recetasPagina;
        }
        else {
            $mostrar = 12;
        }

        if ($num_categoria != 0) {

            $recetasResultados = Receta::where("categoria", $num_categoria);

            $tamanio = $recetasResultados->count();

            $offset = ($pagina - 1) * $mostrar;

            $recetas = $recetasResultados->select('id', 'titulo', 'img')->offset($offset)->limit($mostrar)->get();

            return [$recetas, $tamanio, sizeof($recetas)];
        }

        return [$recetas, $tamanio, $mostrar];
    }

    public function ObtenerIdRecetasFavoritas()
    {
        $idsFavoritos = [];
        $usuario = JWTAuth::user();
        $usuarioEncontrado = Usuario::find($usuario->id);
        if (!is_null($usuarioEncontrado)) {
            $idsFavoritos = UsuarioReceta::where('id_usuario', $usuarioEncontrado->id)->pluck('id_receta')->toArray();
        }
        return json_encode($idsFavoritos);
    }

    public function ObtenerRecetaFavoritaUsuario(Request $request)
    {

        $recetasFavoritias = $request->recetasFavoritas;

        if (sizeof($recetasFavoritias) != 0) {

            $recetas = Receta::whereIn('id', $recetasFavoritias);
            $recetasBuscar = $recetas->where("titulo", 'LIKE', '%' . $request->titulo . '%')->get();

            return json_encode($recetasBuscar);
        }

        return json_encode($recetasFavoritias);
    }
}
