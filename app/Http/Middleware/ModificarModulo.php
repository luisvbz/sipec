<?php

namespace sipec\Http\Middleware;

use Closure;
use Auth;

class ModificarModulo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $m)
    {
        foreach (Auth::user()->modulos as $modulo) {
            
            if($modulo->abrev == $m AND $modulo->pivot->modificar == TRUE){

                return $next($request);

            }
                  
        }
        return response('No tienes permisos', 401);
    }
}
