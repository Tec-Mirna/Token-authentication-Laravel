<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Tymon\JWTAuth\Facades\JWTAuth;

use function Laravel\Prompts\error;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          //validaciones
          // DEBE INGRESARSE EL Authorization
          $authHeader = $request->header('Authorization'); // Obtendré un header y se tiene que llamar Authorization
          // Si Authorization no existe voy a retornar
          if(!$authHeader){ // si no mando Authorization en el header no estoy autorizado
               return response()->json([
                'message' => 'Unauthorizared',
                'status' => false,
                'data' => null
               ], 401);
          }
        
          // IGNORAR PALABRA BEARER AL TOKEN
          //explode: por cada espacion  parte la cadena en un arreglo Hola mundo ['hola', 'mundo']
          $token = explode(' ',  $authHeader)[1]; // la posicion 0 es la palabra Bearer y 1 el token
          if(!$token){ // si el token no viene
            return response()->json([
                'message' => 'Unauthorizared',
                'status' => false,
                'data' => null
               ], 401);
          }

          // VALIDACION DEL TOKEN
          try{
            // verifica si el token es auténtico
            $user =JWTAuth::parseToken()->authenticate($token);
            error_log($user);

            // CONSULTA PARA VALIDAR EL ROL (SI CUMPLE PASA)
            return $next($request); 

          } catch(\Exception $e){
            return response()->json([
               'message' => 'Invalid jwt', 
                'status' => false,
                'data' => null
            ], 401);
          }


      /*     error_log('Entró al middleware'); */

      
    }
}
