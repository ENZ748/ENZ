<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\Accountability;
use App\Models\ReturnItem;
use App\Models\AssignedItem;
use App\Models\Item;
use App\Models\ItemHistory;

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
                $assigned_items = AssignedItem::where('employeeID', $employee->id)
                ->where('item_status', 'unreturned')->get();
     
                //Historyyyy
                $history_items = ItemHistory::where('employeeID', $employee->id)->get();

                return view('userAccount.index', compact('assigned_items','history_items'));

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
