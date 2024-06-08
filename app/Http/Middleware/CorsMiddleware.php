<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);                            //'http://localhost:5173 dominio de react si la quiero pública pongo un *
        $response->headers->set('Access-Control-Allow-Origin', '*');// dominio que tiene permisos para consular la api
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization'  ); 
       /*  error_log('MIDDLEWARE GLOBAL'); */
        return $response;
    }
}
