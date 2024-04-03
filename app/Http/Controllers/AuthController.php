<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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

            // Retrieve existing session tokens or initialize as empty array
            $sessionTokens = json_decode($user->session_tokens, true) ?? [];

            // Append current session ID
            $sessionTokens[] = session()->getId();

            // Update user details including session_tokens
            User::where('id', $user->id)->update([
                'ACTIVE_STATUS' => 'Active',
                'TIME_ACTIVE' => Carbon::now()->format('m-d-Y h:i A'),
                'ACTIVE_LOCATION' => 'Dashboard',
                'session_tokens' => json_encode($sessionTokens)
            ]);

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
            
            // Retrieve existing session tokens and decode JSON
            $sessionTokens = json_decode($user->session_tokens ?? '[]', true);

            // Remove current session token from the list
            $sessionTokens = array_diff($sessionTokens, [session()->getId()]);

            User::where('id', $user->id)->update([
                'ACTIVE_STATUS' => 'Offline',
                'ACTIVE_LOCATION' => 'N/A',
                'TIME_ACTIVE' => Carbon::now()->format('m-d-Y h:i A'),
                'session_tokens' => json_encode($sessionTokens),
            ]);
        
        }

        Auth::logout();
        return redirect(route('login'));
    }

    // public function forceLogout()
    // {
    //     // Get all active user sessions
    //     $activeUsers = User::where('ACTIVE_STATUS', 'Active')->get();

    //     // Loop through each active user session and logout
    //     foreach ($activeUsers as $user) {
    //         // Optionally, you can update additional user properties like ACTIVE_STATUS, etc.
    //         $user->update([
    //             'ACTIVE_STATUS' => 'Offline',
    //             'ACTIVE_LOCATION' => 'N/A',
    //             'TIME_ACTIVE' => now()->format('m-d-Y h:i A')
    //         ]);

    //         // Flush the current session and logout the current user
    //         Session::flush();
    //         Auth::logout();
    //     }

    
    //     // Redirect to the login page
    //     return redirect()->route('login')->with('success', 'All users have been logged out.');
    // }
    

}
