<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show registration Form
    public function create(){
        return view('users.register');
    }

    //Store user details
    public function store(Request $request){

        $formFields = $request->validate([
            'name' => ['required','min:3'],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','confirmed','min:6']
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User and Log-in
        $user = User::create($formFields);

        //Auth
        auth()->login($user);

        return redirect('/')->with('message','User created and logged in');
    }

    //Logout
    public function logout(Request $request){
        auth()->logout();

        //Invalidate session and csfr token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','Logged out successfully!');
    }

    //Login
    public function login(){
        return view('users.login');
    }

    //Authenticate User
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:6']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message','Logged in successfully!');
        }

        return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');
    }
}
