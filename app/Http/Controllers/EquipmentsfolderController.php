<?php

namespace App\Http\Controllers;

use App\Models\EquipmentsFolder;
use Illuminate\Http\Request;

class EquipmentsfolderController extends Controller
{
    public function index(){
        $equipments = EquipmentsFolder::all();
        return view('equipmentsfolder', compact('equipments'));
    }
    
    public function create(){
        return view('createfolder');
    }

    public function createPOST(Request $request){
        $data = $request->validate([
            'equipmentsname'=> ['required', 'unique:equipmentsfolder']
        ]);
    
        EquipmentsFolder::create($data);
    
        return redirect(route('equipments'));
    }
}
