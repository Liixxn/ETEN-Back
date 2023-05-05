<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->hasHeader('Authorization')) {
            // La cabecera de autorización no está presente
            $token = $request->bearerToken();
            try {
                if ($token = JWTAuth::parseToken()->authenticate()) {
                    //$user = JWTAuth::parseToken($token)->authenticate();
                    //return response()->json(['Verificado' => 'Autorizado'], 200);
                    //return $user;
                    return $next($request);
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
