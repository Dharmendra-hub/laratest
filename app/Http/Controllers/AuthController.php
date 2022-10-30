<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Use Traits
    use HttpResponses;

    //Login
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        //check for user
        if(!Auth::attempt($request->only(['email','password']))){
            return $this->error('','Credentials do not match',401);
        }

        $user = User::where('email',$request->email)->first();

        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of '. $user->name)->plainTextToken
        ]);
    }

    //Register
    public function register(StoreUserRequest $request)
    {

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //based on trait
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API token of '. $user->name)->plainTextToken
        ]);

    }

    //Login
    public function logout()
    {
        return \response()->json('logout API hit');
    }
}
