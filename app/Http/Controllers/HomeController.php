<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\Accountability;
use App\Models\ReturnItem;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
           // Get the user type and user ID
            $usertype = Auth::user()->usertype;
            $userID = Auth::user()->id;
            // Retrieve the employee record using the user_id from the authenticated user
            $userStatus = Employees::where('user_id', $userID)->first();

            if ($userStatus && $userStatus->active == 0) {
                // Log the user out if the account is deactivated
                Auth::logout();
                return redirect()->back()->withErrors(['status' => 'Your account is deactivated. Please contact support.']);
            }


            // Pass the equipment data to the view
            if ($usertype == 'user') {
                
                $user_id = Auth::user()->id;
                
                //Assetssssssssssssssssss
                // Find the employee associated with the current user
                $employee = Employees::where('user_id', $user_id)->first();
    
                // Retrieve all assigned items for the employee
                $assigned_items = Accountability::where('employee_id', $employee->id)->get();
    
                // Retrieve all equipment associated with the assigned items
                $assets = Equipments::whereIn('id', $assigned_items->pluck('equipment_id'))->get();

                //Historyyyy
                $history_items = ReturnItem::where('employee_id', $employee->id)->get();
                $assets_history = Equipments::whereIn('id', $history_items->pluck('equipment_id'))->get();


                return view('userAccount.index', compact('assets','assets_history'));

            } elseif ($usertype == 'admin') {
                return redirect('chart');
            } else {
                return redirect()->back();
            }
        } else {
 
            return redirect()->route('login');
        }
    }
}
