<?php

namespace App\Http\Controllers;
use App\Models\Equipments;
use App\Models\LogHistory;
use Illuminate\Http\Request;

class LogHistoryController extends Controller
{
    public function index(Request $request){
        $borrowedMonth = $request->input('monthselect');
        $borrowedDay = $request->input('dateselect');
        $borrowedYear = $request->input('yearselect');


        $query = LogHistory::query();

        if ($borrowedMonth) {
            $query->where('DATE_BORROWED', 'like', "%$borrowedMonth%");
        }
        
        if ($borrowedDay) {
            $query->where('DATE_BORROWED', 'like', "%$borrowedDay%");
        }

        if ($borrowedYear) {
            $query->where('DATE_BORROWED', 'like', "%$borrowedYear%");
        }

        $returnedToday = LogHistory::whereNotNull('DATE_RETURNED')
        ->orWhereNotNull('RETURNEE')
        ->get();

        $borrowedToday = $query->get();
        
    
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.loghistory_borrowedtable', compact('borrowedToday' ,'returnedToday'));
        } else {
            // If it's a regular request, return the full users view
            return view('loghistory', compact('borrowedToday' ,'returnedToday'));
        }
    }

    
}
