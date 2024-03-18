<?php

namespace App\Http\Controllers;

use App\Models\Equipments;
use Illuminate\Http\Request;
use App\Models\EquipmentsFolder;

class EquipmentsController extends Controller
{
    public function index(Request $request){
        //Search bar
        $searchTerm = $request->input('search');

        // Retrieve users based on the search term if provided
        if ($searchTerm) {
            $equipments = Equipments::where('ITEM_NAME', 'like', '%' . $searchTerm . '%')
                ->get();
        } else {
            // Otherwise, fetch all users
            $equipments = Equipments::all();
        }

        // Check if the request is AJAX
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.equipments_table', ['equipments' => $equipments]);
        } else {
            // If it's a regular request, return the full users view
            return view('equipments', ['equipments' => $equipments]);
        }

        /*Look at the Databases
        $equipments = Equipments::all();
        return view('equipments', compact('equipments'));*/
    }
    
    public function add(){
        // Fetch all records from the equipmentsfolder table
        $equipmentsfolders = EquipmentsFolder::all();

        // Pass the $equipmentsfolders variable to the view using compact()
        return view('addequipment', compact('equipmentsfolders'));
    }

    public function store(Request $request){
        $data = $request->validate([
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

        // If an image is uploaded
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $destinationPath = public_path('assets/equipments_images');

            // Move the uploaded file to the destination directory
            $fileName = $file->getClientOriginalName();
            if ($file->move($destinationPath, $fileName)) {
                // If file upload is successful, store the file path in $dataFromTable
                $dataFromTable['ITEM_IMAGE'] = 'assets/equipments_images/' . $fileName;
                echo "File Upload Success";
            } else {
                // If file upload fails, set a placeholder or default image path
                $dataFromTable['ITEM_IMAGE'] = 'assets/placeholder.jpg';
                echo "Failed to upload file";
            }
        } else {
            // If no image is uploaded, set a placeholder or default image path
            $dataFromTable['ITEM_IMAGE'] = 'assets/placeholder.jpg';
            echo "No image uploaded";
        }

        Equipments::create($dataFromTable);

        return redirect(route('addequipments'));
    }

    public function edit(Request $request, $id){
        $editequipment = Equipments::findOrFail($id);
        $equipmentsfolder = EquipmentsFolder::all();

        return view('editequipments', compact('editequipment', 'equipmentsfolder'));
    }

    public function update(){

    }

}
