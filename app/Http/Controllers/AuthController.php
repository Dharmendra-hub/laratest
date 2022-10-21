<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    //Use Traits
    use HttpResponses; 

    //Login
    public function login(){
        return \response()->json('Login API hit');
    }

    //REgister
    public function register(StoreUserRequest $request){

        $request->validate($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        
        return \response()->json($request);
    }

    //Login
    public function logout(){
        return \response()->json('logout API hit');
    }
}
