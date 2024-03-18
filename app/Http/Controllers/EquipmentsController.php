<?php

namespace App\Http\Controllers;

use App\Models\Equipments;
use Illuminate\Http\Request;
use App\Models\EquipmentsFolder;

class EquipmentsController extends Controller
{
    public function index(){
        $equipments = Equipments::all();

        return view('equipments', compact('equipments'));
    }
    
    public function add(){
        // Fetch all records from the equipmentsfolder table
        $equipmentsfolders = EquipmentsFolder::all();

        // Pass the $equipmentsfolders variable to the view using compact()
        return view('addequipment', compact('equipmentsfolders'));
    }
    public function store(Request $request){
        $data = $request->validate([
            'upload' => ['nullable'],
            'equipmentsname' => ['required'],
            'equipmentsbrand' => ['nullable'],
            'equipmentscolor' => ['required'],
            'equipmentsqty' => ['required', 'numeric', 'min:1'],
            'equipmentsstatus' => ['required'],
            'equipmentsavailable' => ['required'],
            'equipmentsinout' => ['required'],
            'equipmentsreason' => ['nullable'],
            'equipmentsnote' => ['nullable'],
            'equipmentsfolder' => ['nullable']
        ]);
        
        $dataFromTable=[
            'ITEM_IMAGE' => $data['upload'],
            'ITEM_NAME' => $data['equipmentsname'],
            'BRAND' => $data['equipmentsbrand'],
            'COLOR' => $data['equipmentscolor'],
            'QUANTITY' => $data['equipmentsqty'],
            'STATUS' => $data['equipmentsstatus'],
            'AVAILABLE' => $data['equipmentsavailable'],
            'IN_OUT' => $data['equipmentsinout'],
            'REASON' => $data['equipmentsreason'],
            'NOTE' => $data['equipmentsnote'],
            'FOLDER' => $data['equipmentsfolder'],
        ];

        Equipments::create($dataFromTable);

        return redirect(route('addequipments'));
    }
}
