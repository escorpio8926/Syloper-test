<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Model\User;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//rutas usuario
Route :: post('register',[AuthController::class,'register']);
Route :: post('login',[AuthController::class,'login']);

//Rutas categorias
Route::post('/categorias', [App\Http\Controllers\CategoryController::class, 'index']);

//Ruta Post
Route::get('/allpost', [App\Http\Controllers\PostController::class, 'all']);

// Rutas Proteguidas
Route :: middleware('jwt.verify')->group(function(){
    //Rutas usuario API  Protegida por Token
    Route :: get('/users',[UserController::class,'index']);

    //Rutas Categorias API Protegida por Token
    Route::post('/icat', [App\Http\Controllers\CategoryController::class, 'store']);
    Route::put('/ucat', [App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/dcat/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);


    //Ruta Post  API Protegida por Token
    Route::post('/ipost', [App\Http\Controllers\PostController::class, 'storeapi']);
    Route::post('/upost', [App\Http\Controllers\PostController::class, 'updateapi']);
    Route::post('/dpost', [App\Http\Controllers\PostController::class, 'destroyapi']);
});



