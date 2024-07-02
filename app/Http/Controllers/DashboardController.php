<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    
    public function index()
    {
        $users = User::paginate(10);
        ///$users = User::all(); // Fetch all users
        return view('dashboard', compact('users'));
    }

    
    /*
       public function index(){
        $users = User::all(); 
        return view('dashboard', [
        'users' => $users,  
    ]);
}

    */
}
