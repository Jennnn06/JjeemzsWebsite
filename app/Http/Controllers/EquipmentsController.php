<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentsController extends Controller
{
    public function index(){
        return view('equipments');
    }
    
    public function add(){
        return view('addequipment');
    }
}
