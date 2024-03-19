<?php

namespace App\Http\Controllers;

use App\Models\Equipments;
use App\Models\EquipmentsFolder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $totalRowsOfUser = User::count();
        $totalRowsOfEquipments = Equipments::count();
        $totalRowsOfFolders = EquipmentsFolder::count();
        $brokenCount = Equipments::where('STATUS', 'broken')->count();

        // Retrieve the necessary data from the database
        $latestMaintenances = Equipments::select('ITEM_IMAGE', 'ITEM_NAME', 'updated_at')
        ->whereNotNull('ITEM_IMAGE') // Make sure ITEM_IMAGE is not null
        ->orderBy('updated_at', 'desc') // Order by the latest maintenance date
        ->limit(5)
        ->get();

        return view('dashboard', compact('totalRowsOfUser', 'totalRowsOfEquipments', 'totalRowsOfFolders', 'brokenCount', 'latestMaintenances'));
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
