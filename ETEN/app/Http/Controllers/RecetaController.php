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
    public function VerReceta($nombreReceta)
    {
        $receta = Receta::where("titulo", $nombreReceta)->first();
        return "Receta: $nombreReceta";
    }


    public function BuscarReceta($titulo)
    {
        $receta = Receta::where("titulo", 'LIKE', '%' . $titulo . '%')->get();
        return  $receta;
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

    public function ObtenerRecetasPorCategoria($num_categoria)
    {
        $recetas = Receta::where("categoria", $num_categoria)->get(['id', 'titulo', 'img'])->toArray();
        return $recetas;
    }

    public function ObtenerRecetasPorId(Request $request)
    {
        $ids = $request->ids;
        $recetas = Receta::whereIn('id', $ids)->get();
        return $recetas;
    }



    public function GuardarRecetaFavoritos(Request $request)
    {
        $mensaje = 'mensaje';
        $usuarioEncontrado = Usuario::find($request->id_user);
        $recetaEncontrada = Receta::find($request->id_receta);

        if (!is_null($usuarioEncontrado) && !is_null($recetaEncontrada)) {
            $favoritoEncontrado = UsuarioReceta::where('id_usuario', $request->id_user)->where('id_receta', $request->id_receta)->withTrashed()->count();
            if ($favoritoEncontrado == 0) {
                $nuevoFavorito = new UsuarioReceta();
                $nuevoFavorito->id_usuario = $request->id_user;
                $nuevoFavorito->id_receta = $request->id_receta;
                $nuevoFavorito->save();
                $mensaje = "Receta Guardada en favoritos nueva";
            } else {
                $favoritoEncontrado = UsuarioReceta::where('id_usuario', $request->id_user)->where('id_receta', $request->id_receta)->restore();
                $mensaje = "Receta Guardada en favoritos actualizada";
            }
        } else {
            $mensaje = "Error en los datos";
        }
        return json_encode($mensaje);
    }

    public function EliminarRecetaFavoritos(Request $request)
    {
        $mensaje = 'mensaje';
        $usuarioEncontrado = Usuario::find($request->id_user);
        $recetaEncontrada = Receta::find($request->id_receta);
        if (!is_null($usuarioEncontrado) && !is_null($recetaEncontrada)) {
            $favoritoEncontrado = UsuarioReceta::where('id_usuario', $request->id_user)->where('id_receta', $request->id_receta);
            if (!is_null($favoritoEncontrado)) {
                UsuarioReceta::where('id_usuario', $request->id_user)->where('id_receta', $request->id_receta)->delete();
                $mensaje = 'Receta Eliminada de favoritos';
            } else {
                $mensaje = 'Este favorito no existe';
            }
        } else {
            $mensaje = "Error en los datos";
        }
        return json_encode($mensaje);
    }

    public function ObtenerIdRecetasFavoritas(Request $request)
    {
        $idsFavoritos = [0, 1, 2];
        $usuarioEncontrado = Usuario::find($request->id_user);
        if (!is_null($usuarioEncontrado)) {
            $idsFavoritos = UsuarioReceta::where('id_usuario', $request->id_user)->pluck('id_receta')->toArray();
        }
        return json_encode($idsFavoritos);
    }
}
