<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employees;
use App\Models\AssignedItem;
use App\Models\ItemHistory;

class AdminAccountabilityController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
                
                //Assetssssssssssssssssss
                // Find the employee associated with the current user
                $employee = Employees::where('user_id', $user_id)->first();
    
                // Retrieve all assigned items for the employee
                $assigned_items = AssignedItem::where('employeeID', $employee->id)
                ->orderBy('created_at', 'desc')
                ->where('item_status', 'unreturned')->get();
     
                //Historyyyy
                $history_items = ItemHistory::where('employeeID', $employee->id)
                ->orderBy('created_at', 'desc')
                ->get();

        return view('adminAccountabilities.index', compact('assigned_items','history_items'));

    }
}
