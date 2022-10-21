<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

//All Listings
Route::get('/', [ListingController::class,'index']);

//Create Listing Form
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//Store Listing Data via Form POST method
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

//Fetch Existing Listing to edit in the edit form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//Update Existing submitted edit
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');

//Manage Listing
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');


//Single Listing 
//DYNAMIC ROUTES WILL BE BELOW
Route::get('/listings/{listing}',[ListingController::class,'show']);

//User Register
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//User Creation
Route::post('/users',[UserController::class,'store']);

//Logout User
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//Login Form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Authenticate User
Route::post('/users/authenticate',[UserController::class,'authenticate']);

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/posts/{id}',function($id){
//     //dd($id);
//     return response('Post :'.$id);
// })->where('id','[0-9]+');
