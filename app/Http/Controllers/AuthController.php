<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login(){
        //If logged in, return back home
        if(Auth::check()){
            return redirect(route('dashboard'));
        }
        return view('login');
    }

    function register(){
        //If logged in, return back home
        if(Auth::check()){
            return redirect(route('dashboard'));
        }
        return view('register');
    }

    function loginPost(Request $request){
        $request->validate([
            //The name & password is the one that's declared on login.php
            'name' => 'required',
            'password' => 'required'
        ]);

        //Pass the upper thing here and go home which is declared on web.php
        $credentials = $request->only('name', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('dashboard'));
        }
        //Else ng php, return "success/error"(name)
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    function registerPost(Request $request){
        $request->validate([
            //The email & password is the one that's declared on login.php
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        //Assign newly created variable to the variable on the up to be inserted on sql
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        
        //TIP: Create a function on User.php to avoid errors
        //Insert the data into the table of sql
        $user = User::create($data);
        
        if(!$user){
            return redirect()->intended(route('registration'))->with("error", "Registration failed, try again.");
        }
        return redirect(route('login'))->with("success", "Registration success, login to access the app");
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
    

}
