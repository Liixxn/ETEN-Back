<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

//importacion de los modelos
use App\Models\Receta;
use App\Models\Usuario;
use App\Models\UsuarioReceta;
use Tymon\JWTAuth\Facades\JWTAuth;

class RecetaController extends Controller
{

    //para las estadisticas del admin todavia no implementada
    public function ObtenerRecetas(Request $request)
    {
        $receta = Receta::get(['id', 'img', 'titulo', 'categoria', 'activo'])->withTrashed();
        return json_encode($receta);
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

    public function ObtenerRecetasPorId(Request $request)
    {
        $ids = $request->ids;
        $recetas = Receta::whereIn('id', $ids)->get();
        return $recetas;
    }

    public function ObtenerRecetasPorCategoria($num_categoria, $pagina)
    {

        $recetas = Receta::get(['id', 'titulo', 'img']);
        $tamanio = $recetas->count();

        $mostrar = 12;

        if ($num_categoria != 0) {

            $recetasResultados = Receta::where("categoria", $num_categoria);

            $tamanio = $recetasResultados->count();

            $offset = ($pagina - 1) * 12;

            $recetas = $recetasResultados->select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();

            return [$recetas, $tamanio];
        }

        return [$recetas, $tamanio];
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


//por aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii





















    public function BuscarReceta(Request $request)
    {

        $recetaNumero = Receta::get();
        $tamnio = $recetaNumero->count();

        $mostrar = 12;

        if ($request->titulo != "") {

            $titulo = $request->titulo;

            $recetasBuscar = Receta::where("titulo", 'LIKE', '%' . $titulo . '%');

            $mostrar = $recetasBuscar->count();

            if ($recetasBuscar->count() > 0) {

                $tamnio = $recetasBuscar->count();

                $offset = ($request->pagina - 1) * 12;

                $recetas = $recetasBuscar->select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();

                return [$recetas, $tamnio, sizeof($recetas)];
            }
        }

        $offset = ($request->pagina - 1) * 12;

        $recetas = Receta::select('id', 'titulo', 'img')->offset($offset)->limit(12)->get();


        return [$recetas, $tamnio, $mostrar];
    }



    public function updateEstadoReceta(Request $request)
    {
        $receta = Receta::findOrFail($request->id); //obtiene la receta a actualizar
        $receta->activo = $request->activo;
        $receta->save();
        return "Receta actualizada";
    }





    public function ObtenerUnaReceta($id)
    {
        $receta = Receta::find($id);
        return $receta;
    }
}
