<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * New Routes Custom
 */
//Login
Route::post('/login',[AuthController::class,'login']);

//Register
Route::post('/register',[AuthController::class,'register']);

//logout
Route::post('/logout',[AuthController::class,'logout']);

//Resource Class with all routes
Route::resource('/tasks', TasksController::class);
