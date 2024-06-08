<?php

use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($route) {
     Route::post('/register', [AuthController::class, 'register']);
     Route::post('/login', [AuthController::class, 'login'] );
});
// Puedo aplicar middleware a una sola ruta o encerrar un grupo de rutas(recomendado una a una)
Route::get('/accomodations', [AccomodationController::class,
'getAllAcommodations'])->middleware(AuthMiddleware::class); //Al consultar la ruta, va a ocupar el middleware

Route::post('/accomodations', [AccomodationController::class,
'createAcommodations'])->middleware(AuthAdminMiddleware::class);