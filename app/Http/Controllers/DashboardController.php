<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function dashboard(){
        if(Auth::check()){
            return redirect(route('dashboard'));
        }
        return view('login');
    }

    function equipments(){
        if(Auth::check()){
            return redirect(route('equipments'));
        }
        return view('login');
    }

}
