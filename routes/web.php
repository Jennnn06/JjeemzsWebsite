<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\EquipmentsfolderController;
use App\Http\Controllers\LogHistoryController;
use App\Http\Controllers\UserController;
use App\Models\Equipments;
use App\Models\EquipmentsFolder;

// Redirect root URL to login page
Route::redirect('/', '/login');

//Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

//Register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

//Logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('force-logout', [AuthController::class, 'forceLogout'])->name('force-logout');

//Access dashboard through authentication
Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Create user
    Route::get('/createuser', [UserController::class, 'createfunction'])->name('createusers');
    Route::post('/createuser', [UserController::class, 'createPOST'])->name('createfunction.post');

    //Manage users
    Route::get('/users', [UserController::class, 'index'])->name('manageusers');

    //Edit users
    Route::get('/users/{id}/editusers', [UserController::class, 'editfunction']);
    Route::put('/users/{id}/editusers', [UserController::class, 'updatefunction']);
    Route::delete('/users/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

    //Manage folder for equipments
    Route::get('/equipments', [EquipmentsfolderController::class, 'index'])->name('equipments');

    //Create folder for equipments
    Route::get('/createfolder', [EquipmentsfolderController::class, 'create'])->name('createfolder');
    Route::post('/createfolder', [EquipmentsfolderController::class, 'createPOST'])->name('createfolder.post');

    //Edit folder for equipments. The {id} variable comes from equipmentsfolder.blade
    Route::get('/equipments/{id}/editfolder', [EquipmentsFolderController::class, 'edit'])->name('equipments.editfolder');
    Route::put('/equipments/{id}', [EquipmentsFolderController::class, 'update'])->name('equipments.updatefolder');

    //View equipments by folder
    Route::get('/equipments/{id}/view', [EquipmentsFolderController::class, 'view'])->name('equipments.viewfolder');

    //Manage Equipment
    Route::get('/addequipments', [EquipmentsController::class, 'index'])->name('addequipments');
    
    //Add Equipment
    Route::get('/addequipments/add', [EquipmentsController::class, 'add']);
    Route::post('/addequipments/add', [EquipmentsController::class, 'store'])->name('addequipments.store');
    Route::delete('/addequipments/{equipment}/delete', [EquipmentsController::class, 'delete'])->name('addequipments.delete');

    //Edit update and delete Equipment
    Route::get('/editequipments/{id}', [EquipmentsController::class, 'edit'])->name('editequipments.edit');
    Route::put('/editequipments/{id}', [EquipmentsController::class, 'update'])->name('editequipments.update');

    //History
    Route::get('/loghistory', [LogHistoryController::class, 'index'])->name('loghistory');
    

    /* Mas easy, Dynamic content loading route
    Route::get('/{section}', 'YourController@loadSection')->name('loadSection');*/
});
?>