<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
       /*  return response()->json([
            'message' => 'Hola, ¿cómo estás?'
        ]); */


        //VALIDACION DE DATOS
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]); 

        // VALIDACION DE ESQUEMA DE VALIDACOION
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 409);
        }

        //CREATE USER
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //USUARIO CREADO EXITOSAMENTE
        return response()->json([
            'status' => true,
            'message' => 'New user created',
            'data' => $user
        ], 201);
    }

    public function login(Request $request){
        
         //VALIDACION DE DATOS
         $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]); 

        // VALIDACION DE ESQUEMA DE VALIDACOION
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 409);
        }

        // solamente tomaré en cuenta el email y password aunque venga algo diferente
        $credentials = $request->only(['email', 'password']);
       // attempt: compara si email y password estan en la base de datos
        if ( !$token = auth()->attempt($credentials) ){
            return response()->json([
                'status' => false,
                'message' => 'User or password not found',
                'data' => null,
            ], 404);
        }
        // SI TODO SALE BIEN
        /*  return response()->json([
            'status' => true,
            'message' => 'Todo correcto',
            'data' => null,
        ], 200); */


        return $this->responseWithToken($token);
    }
    public function responseWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'status' => true,
        ]);
    }
}
