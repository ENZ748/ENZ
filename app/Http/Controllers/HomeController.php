<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\Accountability;


use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
           // Get the user type and user ID
            $usertype = Auth::user()->usertype;
          

            // Pass the equipment data to the view
            if ($usertype == 'user') {
                
                $user_id = Auth::user()->id;

                // Find the employee associated with the current user
                $employee = Employees::where('user_id', $user_id)->first();
    
                // Retrieve all assigned items for the employee
                $assigned_items = Accountability::where('employee_id', $employee->id)->get();
    
                // Retrieve all equipment associated with the assigned items
                $assets = Equipments::whereIn('id', $assigned_items->pluck('equipment_id'))->get();


                return view('userAccount.index', compact('assets'));
            } elseif ($usertype == 'admin') {
                return view('dashboard');
            } else {
                return redirect()->back();
            }
        } else {
 
            return redirect()->route('login');
        }
    }
}
