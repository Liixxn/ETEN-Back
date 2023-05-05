<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
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
                $user = JWTAuth::parseToken($token)->authenticate();
                if ($token = JWTAuth::parseToken()->authenticate() && $user->es_administrador == 1) {
                    return $next($request);
                }else{
                    return response()->json(['error' => 'NO ES ADMIN'], 401);
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
