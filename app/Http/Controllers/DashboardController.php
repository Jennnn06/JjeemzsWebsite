<?php

namespace App\Http\Controllers;

use App\Models\Equipments;
use App\Models\EquipmentsFolder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();

        // Update TIME_ACTIVE to current time in 12-hour format
        User::where('id', $user->id)->update(['TIME_ACTIVE' => Carbon::now()->format('m-d-Y h:i A')]);

        //Update location
        User::where('id', $user->id)->update(['ACTIVE_LOCATION' => 'Dashboard']);

        $totalRowsOfUser = User::count();
        $totalRowsOfEquipments = Equipments::count();
        $totalRowsOfFolders = EquipmentsFolder::count();
        $forRepairCount = Equipments::where('STATUS', 'For Repair')->count();

        // Retrieve the necessary data from the database
        $latestMaintenances = Equipments::select('ITEM_IMAGE', 'ITEM_NAME', 'updated_at')
        ->orderBy('updated_at', 'desc') // Order by the latest maintenance date
        ->limit(5)
        ->get();

        //Get Users
        $usersTable = User::all();

        return view('dashboard', compact('totalRowsOfUser', 'totalRowsOfEquipments', 'totalRowsOfFolders', 'forRepairCount', 'latestMaintenances', 'usersTable'));
    }

    function dashboard(){
        if(Auth::check()){
            return redirect(route('dashboard'));
        }
        return view('login');
    }

    function equipments(){
        if(Auth::check()){
            return redirect(route('equipments'));
        }
        return view('login');
    }

}
