<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\EquipmentsfolderController;
use App\Http\Controllers\UserController;
use App\Models\Equipments;

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

//Access dashboard through authentication
Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', function(){
        return view('/dashboard');
    })->name('dashboard');

    //Create user
    Route::get('/createuser', [UserController::class, 'createfunction'])->name('createusers');
    Route::post('/createuser', [UserController::class, 'createPOST'])->name('createfunction.post');

    //Manage users
    Route::get('/users', [UserController::class, 'index'])->name('manageusers');

    //Edit users
    Route::get('/users/{id}/editusers', [UserController::class, 'editfunction']);
    Route::put('/users/{id}/editusers', [UserController::class, 'updatefunction']);
    Route::delete('/users/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

    //Create folder for equipments
    Route::get('/createfolder', [EquipmentsfolderController::class, 'create'])->name('createfolder');
    Route::post('/createfolder', [EquipmentsfolderController::class, 'createPOST'])->name('createfolder.post');

    //Equipment route
    Route::get('/equipments', [EquipmentsfolderController::class, 'index'])->name('equipments');

    //Add Equipment
    Route::get('/addequipments', [EquipmentsController::class, 'index'])->name('addequipments');
    Route::get('/addequipments/add', [EquipmentsController::class, 'add']);

    /* Mas easy, Dynamic content loading route
    Route::get('/{section}', 'YourController@loadSection')->name('loadSection');*/
});
?>