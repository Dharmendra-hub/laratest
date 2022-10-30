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

//Public Route
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

/*
 * Protected Routes group with Sanctum Authentication
 * */
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('/tasks', TasksController::class);
    Route::post('/logout',[AuthController::class,'logout']);
});
