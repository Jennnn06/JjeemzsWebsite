<?php

namespace App\Http\Controllers;
use App\Models\Equipments;
use App\Models\LogHistory;
use Illuminate\Http\Request;

class LogHistoryController extends Controller
{
    public function index(Request $request){
        $month = $request->input('monthselect');
        $day = $request->input('dateselect');
        $year = $request->input('yearselect');

        $searchTerm = $request->input('search');

        $query = LogHistory::query();
        $searchQuery = LogHistory::query();
        $borrowedQuery = LogHistory::query();
        $returnedQuery = LogHistory::query();

        //Search
        if ($searchTerm) {
            $searchQuery->where('ITEM', 'like', '%' . $searchTerm . '%')
                  ->orWhere('ITEM_CODE', 'like', '%' . $searchTerm . '%');
        }

        //If date changed
        if ($month) {
            $borrowedQuery->where('DATE_BORROWED', 'like', "%$month%");
            $returnedQuery->where('DATE_RETURNED', 'like', "%$month%");
        }
        if ($day) {
            $dayWithComma = "$day,";
            $borrowedQuery->where('DATE_BORROWED', 'like', "%$dayWithComma%");
            $returnedQuery->where('DATE_RETURNED', 'like', "%$dayWithComma%");
        }
        if ($year) {
            $borrowedQuery->where('DATE_BORROWED', 'like', "%$year%");
            $returnedQuery->where('DATE_RETURNED', 'like', "%$year%");
        }

        $searchEquipments = $searchQuery->get();
        $borrowedToday = $borrowedQuery->get();
        $returnedToday = $returnedQuery->get();
    
        if ($request->ajax()) {
            // If it's an AJAX request, return JSON containing the HTML content for both tables
            $borrowedTodayHTML = view('partials.loghistory_borrowedtable', compact('borrowedToday', 'returnedToday', 'searchEquipments'))->render();
            $returnedTodayHTML = view('partials.loghistory_returnedtable', compact('borrowedToday', 'returnedToday', 'searchEquipments'))->render();
            $searchEquipmentsHTML = view('partials.loghistory_searchtable', compact('borrowedToday', 'returnedToday', 'searchEquipments'))->render();

            return response()->json([
                'borrowedTodayHTML' => $borrowedTodayHTML,
                'returnedTodayHTML' => $returnedTodayHTML,
                'searchEquipmentsHTML' => $searchEquipmentsHTML,
            ]);
        } else {

            // If it's a regular request, return the full users view
            return view('loghistory', compact('borrowedToday' ,'returnedToday', 'searchEquipments'));
        }
    }

    
}
