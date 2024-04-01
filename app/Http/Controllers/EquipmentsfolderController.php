<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EquipmentsFolder;
use App\Models\Equipments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EquipmentsfolderController extends Controller
{
    public function index(Request $request){
        //Update the time active
        $user = Auth::user();

        // Update TIME_ACTIVE to current time in 12-hour format
        User::where('id', $user->id)->update(['TIME_ACTIVE' => Carbon::now()->format('m-d-Y h:i A')]);
        
        User::where('id', $user->id)->update(['ACTIVE_LOCATION' => 'Tools & Equipments']);

        //Search bar
        $searchTerm = $request->input('search');

        $query = EquipmentsFolder::query();

        // Retrieve users based on the search term if provided
        if ($searchTerm) {
            $query->where('equipmentsname', 'like', '%' . $searchTerm . '%');
        } else {
            // Otherwise, fetch all users
            $equipments = EquipmentsFolder::all();
        }

        $equipments = $query->get();

        // Check if the request is AJAX
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.equipments_foldertable', compact('equipments'));
        } else {
            // If it's a regular request, return the full users view
            return view('equipmentsfolder', compact('equipments'));
        }

        
        /*
        $equipments = EquipmentsFolder::all();
        return view('equipmentsfolder', compact('equipments'));*/
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

        Session::put('previous_url_equipmentsfolder', url()->previous());
        
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

    public function view(Request $request, $id){
        // Find the folder based on the provided ID
        $folder = EquipmentsFolder::findOrFail($id);

        $searchTerm = $request->input('search');

        $query = Equipments::where('FOLDER', $folder->equipmentsname);

        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('ITEM_SERIAL_NUMBER', 'like', '%' . $searchTerm . '%')
                      ->orWhere('ITEM_NAME', 'like', '%' . $searchTerm . '%');
            });
        }
        else{
            $query->where('FOLDER', $folder->equipmentsname);
        }

        $equipmentsView = $query->get();

        // Check if the request is AJAX
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.equipments_viewtable', compact('equipmentsView', 'folder'));
        } else {
            // If it's a regular request, return the full view
            return view('viewbyfolder', compact('equipmentsView', 'folder'));
        }
    }

}