<?php

namespace App\Http\Controllers;

use App\Models\EquipmentsFolder;
use App\Models\Equipments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

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
            'equipmentsimage' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'equipmentsname'=> ['required', 'unique:equipmentsfolder']
        ]);
        
        // If an image is uploaded
        if ($request->hasFile('equipmentsimage')) {
            $file = $request->file('equipmentsimage');
            $destinationPath = public_path('assets/equipments_folderimages');

            // Move the uploaded file to the destination directory
            if ($file->move($destinationPath, $file->getClientOriginalName())) {
                // If file upload is successful, store the file path in $data
                $data['equipmentsimage'] = 'assets/equipments_folderimages/' . $file->getClientOriginalName();
                echo "File Upload Success";
            } else {
                // If file upload fails, set a placeholder or default image path
                $data['equipmentsimage'] = 'assets/placeholder.jpg';
                echo "Failed to upload file";
            }
        } else {
            // If no image is uploaded, set a placeholder or default image path
            $data['equipmentsimage'] = 'assets/placeholder.jpg';
            echo "No image uploaded";
        }

        EquipmentsFolder::create($data);
    
        return redirect(route('equipments'));
    }

    //The id comes from the web.php
    public function edit(Request $request, $id){
        //Now it will find the id from the table and store the data to variable folder
        $folder = EquipmentsFolder::findOrFail($id);
        
        return view('editfolder', compact('folder'));
    }

    public function update(Request $request, $id){
        $folder = EquipmentsFolder::findOrFail($id);
    
        $request->validate([
            'equipmentsimage' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'equipmentsname'=> ['required']
        ]);

        // Get the old folder name
        $oldFolderName = $folder->equipmentsname;

        // Update the name field
        $folder->equipmentsname = $request->input('equipmentsname');
    
        if ($request->hasFile('equipmentsimage')) {
            $file = $request->file('equipmentsimage');
            $destinationPath = public_path('assets/equipments_folderimages');
            $imageName = $file->getClientOriginalName();
    
            // Move the uploaded file to the destination directory
            if ($file->move($destinationPath, $imageName)) {
                // If a new image is uploaded successfully, update the folder's image
                $folder->equipmentsimage = 'assets/equipments_folderimages/' . $imageName;
    
                // Delete the existing image if it exists (replace it with the new image)
                if (File::exists($destinationPath . '/' . $folder->equipmentsimage)) {
                    unlink($destinationPath . '/' . $folder->equipmentsimage);
                }
            } else {
                // Handle file upload failure
                return redirect()->back()->withErrors(['equipmentsimage' => 'Failed to upload image. Please try again.']);
            }
        }
    
        $folder->save();

        // Update corresponding equipments records
        Equipments::where('FOLDER', $oldFolderName)
        ->update(['FOLDER' => $folder->equipmentsname]);
    
        // Redirect back to the "Manage folder for equipments" page
        return redirect()->route('equipments')->with('success', 'Folder image updated successfully.');
    }

    public function view($id){
        // Find the folder based on the provided ID
        $folder = EquipmentsFolder::findOrFail($id);

        // Retrieve the equipments belonging to the selected folder
        $equipmentsView = Equipments::where('FOLDER', $folder->equipmentsname)->get();

        return view('viewbyfolder', ['equipmentsView' => $equipmentsView]);
    }

}