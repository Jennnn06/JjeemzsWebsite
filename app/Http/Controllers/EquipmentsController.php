<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\EquipmentsFolder;
use App\Models\Equipments;
use App\Models\LogHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EquipmentsController extends Controller
{
    public function index(Request $request){
        //Update the time active
        $user = Auth::user();

        // Update TIME_ACTIVE IN DASHBOARD to current time in 12-hour format
        User::where('id', $user->id)->update(['TIME_ACTIVE' => Carbon::now()->format('m-d-Y h:i A')]);

        User::where('id', $user->id)->update(['ACTIVE_LOCATION' => 'Add Tools & Equipments']);

        //Search
        $searchTerm = $request->input('search');
        $brandFilter = $request->input('brand');
        $colorFilter = $request->input('color');

        //Query
        $query = Equipments::query();

        // Find the data
        if ($searchTerm) {
            $query->where('ITEM_NAME', 'like', '%' . $searchTerm . '%')
                  ->orWhere('ITEM_SERIAL_NUMBER', 'like', '%' . $searchTerm . '%')
                  ->orWhere('ITEM_CODE', 'like', '%' . $searchTerm . '%');
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
            'equipmentsfolder' => ['nullable'],

            'equipmentscode' => ['nullable'],

            'equipmentsborrowedqty' => ['nullable', 'numeric'],
            'monthborrowed' => ['nullable'],
            'dateborrowed' => ['nullable'],
            'yearborrowed' => ['nullable']
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
            'ITEM_CODE' => $data['equipmentscode'],
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

        $equipment = Equipments::create($dataFromTable);

        if ($data['equipmentsavailable'] === 'No') {
            $logHistoryData = [
                'equipment_id' => $equipment->id,

                //Does not work
                'ITEM_IMAGE' => $equipment->ITEM_IMAGE,
                'ITEM_CODE' => $data['equipmentscode'],
                'COLOR' => $data['equipmentscolor'],

                'ITEM' => $data['equipmentsname'],
                'BRAND' => $data['equipmentsbrand'],
                'QUANTITY' => $data['equipmentsborrowedqty'],
                'LOCATION' => $data['equipmentslocation'],
                'DATE_BORROWED' => isset($data['monthborrowed']) && isset($data['dateborrowed']) && isset($data['yearborrowed']) ? 
                    $data['monthborrowed'] . ' ' . $data['dateborrowed'] . ', ' . $data['yearborrowed'] : null,
                'BORROWER' => $data['equipmentsborrowedby'],
                
            ];
        } else {
            // If equipmentsavailable is not "No", set $logHistoryData to null or an empty array, depending on your preference
            $logHistoryData = null;
        }

        if ($logHistoryData !== null) {
            $logHistory = new LogHistory();
            $logHistory->fill($logHistoryData);

            //Signature returnee pic
            if ($request->hasFile('uploadsignature')) {
                $file = $request->file('uploadsignature');
                $destinationPath = public_path('assets/borrower_signatures');
                
                $fileName = $file->getClientOriginalName();
                
                if ($file->move($destinationPath, $fileName)) {
                    // If file upload is successful, update the signature path
                    $logHistory->BORROWER_SIGNATURE = 'assets/borrower_signatures/' . $fileName;
                    
                    // Delete the existing signature if it exists
                    if (File::exists($destinationPath . '/' . $logHistory->BORROWER_SIGNATURE)) {
                        unlink($destinationPath . '/' . $logHistory->BORROWER_SIGNATURE);
                    }
                    
                    echo "Signature Upload Success";
                } else {
                    // If file upload fails, handle the error
                    echo "Failed to upload signature";
                }
            }

            $logHistory->save();
        }

        return redirect(route('addequipments'));
    }

    public function edit(Request $request, $id){
        $editequipment = Equipments::findOrFail($id);
        $equipmentsfolder = EquipmentsFolder::all();

        $isBorrowed = !is_null($editequipment->BORROWED_BY);

        // Retrieve logHistory quantity
        $logHistory = LogHistory::where('equipment_id', $id)
        ->where(function ($query) {
            $query->whereNull('DATE_RETURNED')
                ->orWhereNull('RETURNEE');
        })
        ->first();

        if (!$logHistory) {
            // If logHistory doesn't exist, set quantity to null
            $logHistoryQuantity = null;
        } else {
            $logHistoryQuantity = $logHistory->QUANTITY;
        }

        //Suggestions
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

        return view('editequipments', compact('editequipment', 'equipmentsfolder', 'logHistoryQuantity', 'isBorrowed'));
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
            'equipmentsfolder' => ['nullable'],
            'equipmentscode' => ['nullable'],

            'equipmentsborrowedqty' => ['nullable', 'numeric'],
            'monthborrowed' => ['nullable'],
            'dateborrowed' => ['nullable'],
            'yearborrowed' => ['nullable'],
            
            //RETURNEE
            'monthreturned' => ['nullable'],
            'datereturned' => ['nullable'],
            'yearreturned' => ['nullable'],
            
            'equipmentsreturnedby' => ['nullable'],
            
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
        $equipment->ITEM_CODE = $data['equipmentscode'];
    
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

        //LOG HISTORY
        $logHistory = LogHistory::where('equipment_id', $id)
        ->where(function ($query) {
            $query->whereNull('DATE_RETURNED')
                ->orWhereNull('RETURNEE');
        })
        ->first();

        //Add only log history if good ung equipment
        if($data['equipmentsstatus'] === 'Good'){
            if ($logHistory && $data['equipmentsavailable'] === 'No') {
                // Update the existing row in log_history
                $logHistory->ITEM = $data['equipmentsname'];
                $logHistory->BRAND = $data['equipmentsbrand'];
                $logHistory->QUANTITY = $data['equipmentsborrowedqty'];
                $logHistory->LOCATION = $data['equipmentslocation'];
                $logHistory->BORROWER = $data['equipmentsborrowedby'];
    
                $logHistory->ITEM_IMAGE = $equipment->ITEM_IMAGE;
                $logHistory->COLOR = $data['equipmentscolor'];
                $logHistory->ITEM_CODE = $data['equipmentscode'];
    
                // Check if date borrowed fields are set and assign them
                if (isset($data['monthborrowed']) && isset($data['dateborrowed']) && isset($data['yearborrowed'])) {
                    $logHistory->DATE_BORROWED = $data['monthborrowed'] . ' ' . $data['dateborrowed'] . ', ' . $data['yearborrowed'];
                }
        
            } 
            else if($logHistory && $data['equipmentsavailable'] === 'Yes'){
                // Update the existing row in log_history
                $logHistory->ITEM = $data['equipmentsname'];
                $logHistory->BRAND = $data['equipmentsbrand'];
                // $logHistory->QUANTITY = $data['equipmentsborrowedqty'];
                // $logHistory->LOCATION = $data['equipmentslocation'];
                // $logHistory->BORROWER = $data['equipmentsborrowedby'];
    
                $logHistory->ITEM_IMAGE = $equipment->ITEM_IMAGE;
                $logHistory->COLOR = $data['equipmentscolor'];
                $logHistory->ITEM_CODE = $data['equipmentscode'];
    
                //RETURN
                // Check if date returned fields are set and assign them
                if (isset($data['monthreturned']) && isset($data['datereturned']) && isset($data['yearreturned'])) {
                    $logHistory->DATE_RETURNED = $data['monthreturned'] . ' ' . $data['datereturned'] . ', ' . $data['yearreturned'];
                    $logHistory->RETURNEE = $data['equipmentsreturnedby'];
                }
            }
            else if(!$logHistory && $data['equipmentsavailable'] === 'Yes'){
                echo "No existing log, will not store any log";
            }
            else {
                // Create a new row in log_history
                $logHistory = new LogHistory();
                $logHistory->equipment_id = $id;
                $logHistory->ITEM = $data['equipmentsname'];
                $logHistory->BRAND = $data['equipmentsbrand'];
                $logHistory->LOCATION = $data['equipmentslocation'];
    
                $logHistory->ITEM_IMAGE = $equipment->ITEM_IMAGE;
                $logHistory->COLOR = $data['equipmentscolor'];
                $logHistory->ITEM_CODE = $data['equipmentscode'];
    
                $logHistory->QUANTITY = isset($data['equipmentsborrowedqty']) ? $data['equipmentsborrowedqty'] : 1; 
    
                if (isset($data['monthborrowed']) && isset($data['dateborrowed']) && isset($data['yearborrowed'])) {
                    $logHistory->DATE_BORROWED = $data['monthborrowed'] . ' ' . $data['dateborrowed'] . ', ' . $data['yearborrowed'];
                    $logHistory->BORROWER = $data['equipmentsborrowedby'];
                }    
                $logHistory->save();
            }
    
            if ($request->hasFile('uploadsignature')) {
                $file = $request->file('uploadsignature');
                $destinationPath = public_path('assets/borrower_signatures');
                
                $fileName = $file->getClientOriginalName();
                
                if ($file->move($destinationPath, $fileName)) {
                    // If file upload is successful, update the signature path
                    $logHistory->BORROWER_SIGNATURE = 'assets/borrower_signatures/' . $fileName;
                    
                    // Delete the existing signature if it exists
                    if (File::exists($destinationPath . '/' . $logHistory->BORROWER_SIGNATURE)) {
                        unlink($destinationPath . '/' . $logHistory->BORROWER_SIGNATURE);
                    }
                    
                    echo "Signature Upload Success";
                } else {
                    // If file upload fails, handle the error
                    echo "Failed to upload signature";
                }
            }
    
            if ($request->hasFile('uploadsignaturereturnee')) {
                $file = $request->file('uploadsignaturereturnee');
                $destinationPath = public_path('assets/returnee_signatures');
            
                $fileName = $file->getClientOriginalName();
            
                if ($file->move($destinationPath, $fileName)) {
                    // If file upload is successful, update the returnee's signature path
                    $logHistory->RETURNEE_SIGNATURE = 'assets/returnee_signatures/' . $fileName;
            
                    // Delete the existing signature if it exists
                    if (File::exists($destinationPath . '/' . $logHistory->RETURNEE_SIGNATURE)) {
                        unlink($destinationPath . '/' . $logHistory->RETURNEE_SIGNATURE);
                    }
            
                    echo "Returnee's Signature Upload Success";
                } else {
                    // If file upload fails, handle the error
                    echo "Failed to upload returnee's signature";
                }
            }
            
            if ($logHistory) {
                $logHistory->save();
            } 
            else {
                // Handle the case where $logHistory is null
                echo "Failed to save log history";
            }
        }

        
    
        return redirect()->to(session('previous_url_equipments'));
    }   

    public function delete(Equipments $equipment){
        $equipment->delete();

        return redirect()->route('addequipments')->with('success', 'User deleted successfully.');
    }

}
