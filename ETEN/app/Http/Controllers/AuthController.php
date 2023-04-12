<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login($request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        dd($request->email);
        $user = Usuario::where('email', $request->input('email'))->first();
        $token = $user->createToken('ETEN')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}