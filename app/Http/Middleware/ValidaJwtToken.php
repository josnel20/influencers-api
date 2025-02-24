<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Closure;

class ValidaJwtToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
            
            if (!$user) {
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Token inválido ou não enviado'], 401);
        }

        return $next($request);
    }
}
