<?php

namespace App\Http\Controllers;

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
        $usuario = Usuario::where("email", $request->email)->first();
        if ($usuario) {
            if ($usuario->password == $request->password) {
                return "Usuario logueado";
            } else {
                return "Contraseña incorrecta";
            }
        } else {
            return "Usuario no encontrado";
        }
    }

    public function Registro(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        return "Usuario registrado";
    }



    public function ActualizarDatosUsuario(Request $request)
    {
        // Obtener el usuario a actualizar
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('password'));

        $user->save();
        return "Usuario actualizado correctamente";
        }


}
