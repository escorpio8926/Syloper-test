<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Excepcion $e) {

            if($e instanceof TokenInvalidException){
                return responde()->json(['status'=>'Token Invalido' ]);
            }

            if($e instanceof TokenExpiredException){
                return responde()->json(['status'=>'Token Expirado' ]);
            }

            return responde()->json(['status'=>'Token no encontrado' ]);
            
        }
        return $next($request);
    }
}
