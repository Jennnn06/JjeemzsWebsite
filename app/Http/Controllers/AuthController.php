<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AuthController extends Controller
{
    function login(){
        //If logged in, return back home
        if(Auth::check()){
            return redirect(route('dashboard'));
        }

        $userCount = User::count();

        //else
        return view('login', compact('userCount'));
    }

    function register(){
        $userCount = User::count();

        //If logged in, return back home
        if(Auth::check()){
            return redirect(route('dashboard'));
        }

        if ($userCount > 2) {
            // Redirect back to the login page with a message indicating that registration is not allowed
            return redirect()->route('login')->with('warning', 'Registration is not allowed at this time.');
        }

        return view('register');
    }

    function loginPost(Request $request){
        $request->validate([
            //The name & password is the one that's declared on login.php
            'name' => ['required', 'regex:/^[a-zA-Z0-9_]+$/'],
            'password' => ['required', 'regex:/^[a-zA-Z0-9]+$/']
        ]);

        //Pass the upper thing here and go home which is declared on web.php
        $credentials = $request->only('name', 'password');

        if(Auth::attempt($credentials)){
            $user = Auth::user(); // Get the authenticated user

            if($user->ACTIVE_STATUS === 'Active'){
                Auth::logout();
                return redirect(route('login'))->with("error", "User is already logged in.");
            }

            // Update ACTIVE_STATUS to 'Active' directly in the database
            User::where('id', $user->id)->update(['ACTIVE_STATUS' => 'Active']);
            User::where('id', $user->id)->update(['TIME_ACTIVE' => Carbon::now()->format('h:i A')]);
            User::where('id', $user->id)->update(['ACTIVE_LOCATION' => 'Dashboard']);

            return redirect()->intended(route('dashboard'));
        }
        
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    function registerPost(Request $request){
        $request->validate([
            //The email & password is the one that's declared on login.php
            'name' => ['required', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => 'required|email|unique:users',
            'password' => ['required', 'regex:/^[a-zA-Z0-9]+$/']
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
        if(Auth::check()){ // Check if the user is authenticated
            $user = Auth::user(); // Get the authenticated user
            
            // Update ACTIVE_STATUS to 'Offline' directly in the database
            User::where('id', $user->id)->update(['ACTIVE_STATUS' => 'Offline']);
            User::where('id', $user->id)->update(['ACTIVE_LOCATION' => 'N/A']);

            // Update TIME_ACTIVE to current time in 12-hour format
            User::where('id', $user->id)->update(['TIME_ACTIVE' => Carbon::now()->format('h:i A')]);
        }

        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
    

}
