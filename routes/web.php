<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth\login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas del post
Route::post('/ipost', [App\Http\Controllers\PostController::class, 'store']);
Route::get('/indice/{id}', [App\Http\Controllers\PostController::class, 'index']);
Route::get('/post/{slug}', [App\Http\Controllers\PostController::class, 'show']);
Route::post('/upost/{id}', [App\Http\Controllers\PostController::class, 'update']);
Route::get('/dpost/{id}/{user_id}', [App\Http\Controllers\PostController::class, 'destroy']);


//Rutas del Mail
Route::get('/Contacto', [App\Http\Controllers\MailController::class, 'index']);
Route::get('/sendEmail', [App\Http\Controllers\MailController::class, 'sendEmail']);




