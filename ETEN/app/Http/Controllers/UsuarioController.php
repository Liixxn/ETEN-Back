<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Usuario;

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
        $usuario = Usuario::where('email', $request->email)->first();

        if (is_null($usuario)) {
            return "Usuario no encontrado";
        } else {

            if (Hash::check($request->password, $usuario->password)) {
                return "Usuario encontrado";

            } else {
                return "Contraseña incorrecta";
            }
        }
    }

    

    public function Registro(Request $request)
    {

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->img = null;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->subscripcion = $request->subscripcion;
        $usuario->es_administrador = $request->es_administrador;
        // Variable que comprueba si existe el email
        $usuarioEncontrado = Usuario::where('email', $request->email)->first();
        // Si no se ha encontrado un usuario, guarda al usuario en la base de datos
        if (is_null($usuarioEncontrado)) {
            $usuario->email = $request->email;
            $usuario->save();

        } else {
            //Si el usuario existe, el email se sustituye por este mensaje para luego comprobarlo en front
            $usuario->email = "Email existente";
        }
        return json_encode($usuario);
    }



    public function ActualizarDatosUsuario(Request $request)
    {
        // Obtener el usuario a actualizar
        $usuario = User::findOrFail($request->id);

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


}
