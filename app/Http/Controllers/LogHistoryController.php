<?php

namespace App\Http\Controllers;
use App\Models\Equipments;
use App\Models\LogHistory;
use Illuminate\Http\Request;

class LogHistoryController extends Controller
{
    public function index(Request $request){
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        // Fetch data from the log_history table based on the selected date

        $borrowedToday = LogHistory::all();

        foreach ($borrowedToday as $borrowed) {
            $equipment = Equipments::find($borrowed->equipment_id);

            if($equipment){
                $borrowed->image = $equipment->ITEM_IMAGE;
                $borrowed->color = $equipment->COLOR;
            }
            else {
                // Handle case where equipment is not found
                $borrowed->image = null; // or set a default image
                $borrowed->color = null; // or set a default color
            }
        }
        
        // where('DATE_BORROWED', $month . '-' . $day . '' . $year )->get();
        // $returnedToday = LogHistory::where('DATE_RETURNED', $year . '-' . $month . '-' . $day)->get();
        

        // // Pass the fetched data to the view
        // return response()->json([
        //     'borrowedToday' => $borrowedToday,
        //     // 'returnedToday' => $returnedToday,
        // ]);

        return view('loghistory', compact('borrowedToday'));
    }
}
