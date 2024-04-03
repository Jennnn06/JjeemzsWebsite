<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogHistoryController extends Controller
{
    public function index(Request $request){
        return view('loghistory');
    }
}
