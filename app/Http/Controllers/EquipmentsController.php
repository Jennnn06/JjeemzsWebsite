<?php

namespace App\Http\Controllers;

use App\Models\EquipmentsFolder;
use App\Models\Equipments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class EquipmentsController extends Controller
{
    public function index(Request $request){

        //Search
        $searchTerm = $request->input('search');
        $brandFilter = $request->input('brand');
        $colorFilter = $request->input('color');

        //Query
        $query = Equipments::query();

        // Find the data
        if ($searchTerm) {
            $query->where('ITEM_NAME', 'like', '%' . $searchTerm . '%')
                  ->orWhere('ITEM_SERIAL_NUMBER', 'like', '%' . $searchTerm . '%');;
        }

        if ($brandFilter && $brandFilter !== '-- Filter by brand --') {
            $query->where('BRAND', $brandFilter);
        }

        if ($colorFilter && $colorFilter !== '-- Filter by color --') {
            $query->where('COLOR', $colorFilter);
        }

        // Get the data
        if ($searchTerm || $brandFilter || $colorFilter) {
            // At least one filter is applied, so fetch equipments based on the filters
            $equipments = $query->get();
        } else {
            $equipments = Equipments::all();
        }

        // Get unique brands and color
        $brands = Equipments::distinct('BRAND')->pluck('BRAND')->filter();
        $colors = Equipments::distinct('COLOR')->pluck('COLOR')->filter();

        $equipments = $query->get();
        

        // Check if the request is AJAX
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.equipments_table', compact('equipments', 'brands', 'colors'));
        } else {
            // If it's a regular request, return the full users view
            return view('equipments', compact('equipments', 'brands', 'colors'));
        }

        /*Look at the Databases
        $equipments = Equipments::all();
        return view('equipments', compact('equipments'));*/
    }
    
    public function add(Request $request){
        // Fetch all records from the equipmentsfolder table
        $equipmentsfolders = EquipmentsFolder::all();

        if ($request->has('query')) {
            $query = $request->input('query');
            
            // Check if the query is for color or brand
            if ($request->has('color')) {
                $suggestions = Equipments::where('COLOR', 'like', '%' . $query . '%')
                    ->distinct('COLOR')
                    ->pluck('COLOR')
                    ->filter()
                    ->toArray();
            } elseif ($request->has('brand')) {
                $suggestions = Equipments::where('BRAND', 'like', '%' . $query . '%')
                    ->distinct('BRAND')
                    ->pluck('BRAND')
                    ->filter()
                    ->toArray();
            } else {
                // Handle invalid request
                return response()->json(['error' => 'Invalid request'], 400);
            }
    
            return response()->json($suggestions);
        }

        // Pass the $equipmentsfolders variable to the view using compact()
        return view('addequipment', compact('equipmentsfolders'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'equipmentsserialnumber' => ['nullable'],
            'equipmentsname' => ['required'],
            'equipmentsbrand' => ['nullable'],
            'equipmentscolor' => ['nullable'],
            'equipmentsqty' => ['required', 'numeric', 'min:1'],
            'equipmentsstatus' => ['required'],
            'equipmentsavailable' => ['required'],
            'equipmentsborrowedby' => ['nullable'],
            'equipmentslocation' => ['nullable'],
            'equipmentsreason' => ['nullable'],
            'equipmentsnote' => ['nullable'],
            'equipmentsfolder' => ['nullable']
        ]);
        
        $dataFromTable=[
            'ITEM_SERIAL_NUMBER' => $data['equipmentsserialnumber'],
            'ITEM_NAME' => $data['equipmentsname'],
            'BRAND' => $data['equipmentsbrand'],
            'COLOR' => $data['equipmentscolor'],
            'QUANTITY' => $data['equipmentsqty'],
            'STATUS' => $data['equipmentsstatus'],
            'AVAILABLE' => $data['equipmentsavailable'],
            'BORROWED_BY' => $data['equipmentsborrowedby'],
            'LOCATION' => $data['equipmentslocation'],
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

        if ($request->has('query')) {
            $query = $request->input('query');
            
            // Check if the query is for color or brand
            if ($request->has('color')) {
                $suggestions = Equipments::where('COLOR', 'like', '%' . $query . '%')
                    ->distinct('COLOR')
                    ->pluck('COLOR')
                    ->filter()
                    ->toArray();
            } elseif ($request->has('brand')) {
                $suggestions = Equipments::where('BRAND', 'like', '%' . $query . '%')
                    ->distinct('BRAND')
                    ->pluck('BRAND')
                    ->filter()
                    ->toArray();
            } else {
                // Handle invalid request
                return response()->json(['error' => 'Invalid request'], 400);
            }
    
            return response()->json($suggestions);
        }

        // Store the previous URL in the session
        Session::put('previous_url_equipments', url()->previous());

        return view('editequipments', compact('editequipment', 'equipmentsfolder'));
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            'equipmentsserialnumber' => ['nullable'],
            'equipmentsname' => ['required'],
            'equipmentsbrand' => ['nullable'],
            'equipmentscolor' => ['nullable'],
            'equipmentsqty' => ['required', 'numeric', 'min:1'],
            'equipmentsstatus' => ['required'],
            'equipmentsavailable' => ['required'],
            'equipmentsborrowedby' => ['nullable'],
            'equipmentslocation' => ['nullable'],
            'equipmentsreason' => ['nullable'],
            'equipmentsnote' => ['nullable'],
            'equipmentsfolder' => ['nullable']
        ]);
    
        $equipment = Equipments::findOrFail($id);
    
        // Update fields
        $equipment->ITEM_SERIAL_NUMBER = $data['equipmentsserialnumber'];
        $equipment->ITEM_NAME = $data['equipmentsname'];
        $equipment->BRAND = $data['equipmentsbrand'];
        $equipment->COLOR = $data['equipmentscolor'];
        $equipment->QUANTITY = $data['equipmentsqty'];
        $equipment->STATUS = $data['equipmentsstatus'];
        $equipment->AVAILABLE = $data['equipmentsavailable'];
        $equipment->BORROWED_BY = $data['equipmentsborrowedby'];
        $equipment->LOCATION = $data['equipmentslocation'];
        $equipment->REASON = $data['equipmentsreason'];
        $equipment->NOTE = $data['equipmentsnote'];
        $equipment->FOLDER = $data['equipmentsfolder'];
    
        // If an image is uploaded
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $destinationPath = public_path('assets/equipments_images');
    
            // Move the uploaded file to the destination directory
            $fileName = $file->getClientOriginalName();
            if ($file->move($destinationPath, $fileName)) {
                // If file upload is successful, update the image path
                $equipment->ITEM_IMAGE = 'assets/equipments_images/' . $fileName;
    
                // Delete the existing image if it exists
                if (File::exists($destinationPath . '/' . $equipment->ITEM_IMAGE)) {
                    unlink($destinationPath . '/' . $equipment->ITEM_IMAGE);
                }
    
                echo "File Upload Success";
            } else {
                // If file upload fails, do nothing with the image path
                echo "Failed to upload file";
            }
        }
    
        // Save the changes to the equipment
        $equipment->save();
    
        return redirect()->to(session('previous_url_equipments'));
    }   

    public function delete(Equipments $equipment){
        $equipment->delete();

        return redirect()->route('addequipments')->with('success', 'User deleted successfully.');
    }

}
