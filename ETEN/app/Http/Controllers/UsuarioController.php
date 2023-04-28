<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioController extends Controller
{

    public function CrearUsuario(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        return "Usuario creado";
    }



    public function login(Request $request)
    {

        $usuarioEncontrado = Usuario::where('email', $request->email)->first();
        if (is_null($usuarioEncontrado)) {
            return response()->json(['error' => 'Not found'], 401);
        } else {

            if (sha1($request->password) == $usuarioEncontrado->password) {
                $token = auth()->login($usuarioEncontrado);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        return $this->respondWithToken($token);
    }



    public function Registro(Request $request)
    {

        $usuario = new Usuario();
        // Variable que comprueba si existe el email
        $usuarioEncontrado = Usuario::where('email', $request->email)->first();
        // Si no se ha encontrado un usuario, guarda al usuario en la base de datos
        if (is_null($usuarioEncontrado)) {

            $usuario->nombre = $request->nombre;
            $usuario->img = null;
            $usuario->email = $request->email;
            $usuario->password = sha1($request->password);
            $usuario->subscripcion = $request->subscripcion;
            $usuario->es_administrador = $request->es_administrador;
            $usuario->email = $request->email;
            $usuario->save();
        } else {
            //Si el usuario existe, el email se sustituye por este mensaje para luego comprobarlo en front
            $usuario->email = "Existente";
        }
        return json_encode($usuario);
    }



    public function ActualizarDatosUsuario(Request $request)
    {
        // Obtener el usuario a actualizar
        $usuario = Usuario::findOrFail($request->id);

        // Actualizar los datos del usuario
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));

        $usuario->save();
        return "Usuario actualizado correctamente";
    }


    public function RecetasUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        $recetas = $usuario->recetas;
        return "Recetas del usuario: $recetas";
    }


    public function obtenerUsuarios()
    {
        $usuarios = Usuario::get();
        return json_encode($usuarios);
    }






    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    protected function verificacionConToken(Request $request)
    {

        if ($request->hasHeader('Authorization')) {
            // La cabecera de autorización no está presente
            $token = $request->bearerToken();
            try {
                if ($token = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['Verificado' => 'Autorizado'], 200);
                }
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    return response()->json(['error' => 'TokenInvalidException'], 401);
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    return response()->json(['error' => 'TokenExpiredException'], 401);
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                    return response()->json(['error' => 'JWTException'], 401);
                } else {
                    return response()->json(['error' => 'error'], 401);
                }
            }
        }
    }
}
