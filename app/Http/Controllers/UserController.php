<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Displaying table + partial table where table changes everytime we search
    public function index(Request $request){
        $searchTerm = $request->input('search');
        
        // Retrieve users based on the search term if provided
        if ($searchTerm) {
            $usersTable = User::where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->get();
        } else {
            // Otherwise, fetch all users
            $usersTable = User::all();
        }
        
        // Check if the request is AJAX
        if ($request->ajax()) {
            // If it's an AJAX request, return a partial view for the table
            return view('partials.users_table', ['usersTable' => $usersTable]);
        } else {
            // If it's a regular request, return the full users view
            return view('users', ['usersTable' => $usersTable]);
        }
    }

    //Displaying a view. use in the future
    public function userfunction(){
        $usersTable = User::all();
        return view('users', compact('usersTable'));
    }

    //Search function with ajax same with method index, use in the future
    public function searchFunction(Request $request){
        $searchTerm = $request->input('search');

        // Check if a search term is provided
        if ($searchTerm) {
            // Perform the search query
            $usersTable = User::where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%')
                        ->get();
        } else {
            // If no search term provided, fetch all users
            $usersTable = User::all();
        }

        // If it's an AJAX request, return the search results as an HTML partial
        if ($request->ajax()) {
            return view('partials.users_table', ['usersTable' => $usersTable])->render();
        } else {
            // If it's a regular request, return the full users view
            return view('users', ['usersTable' => $usersTable]);
        }
    }

    public function createfunction(){
        return view('createusers');
    }

    public function createPOST(Request $request){
        $data = $request->validate([
            'name' => ['required', 'min:4', 'max:100'],
            'email' => 'nullable',
            'password' => ['required', 'min:4', 'max:100']
        ]);

        User::create($data);

        return redirect(route('manageusers'));
    }

    //Edit users
    public function editfunction(int $id){

        //Kunin ung id sa table ng User
        $usersTable = User::findOrFail($id); 

        //Ipasa ung id sa editusers.blade.php at gawing user ung name
        return view('editusers', compact('usersTable'));
    }

    public function updatefunction(Request $request, int $id){
        $data = $request->validate([
            'name' => ['required', 'min:4', 'max:100'],
            'email' => 'nullable',
            'password' => 'nullable|min:4|max:100'
        ]);

        $user = User::findOrFail($id);

        $user->name = $data['name'];
        $user->email = $data['email'];

        // Check if password is provided and not empty
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']); // Hash the password
        }

        $user->update();

        return redirect()->route('manageusers')->with('success', 'User updated successfully.');
    }

    public function delete(User $user){
        // Delete the user
        $user->delete();
        // Redirect back to the users list or any other page as needed
        return redirect()->route('manageusers')->with('success', 'User deleted successfully.');
    }
}
