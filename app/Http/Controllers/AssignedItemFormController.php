<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\AssignedItem;
use App\Models\ItemHistory;

class AssignedItemFormController extends Controller
{
    public function index()
    {
        $employees = Employees::whereHas('users', function ($query) {
            $query->where('usertype', 'user');
        })
        ->orderBy('hire_date', 'desc')
        ->get();
        
        
        return view('assigned_item_forms.index', compact('employees'));

    }


    public function accountability_form($id)
    {
        $employee = Employees::findOrFail($id);

        $assigned_items = AssignedItem::where('employeeID', $employee->id)
        ->where('item_status', 'unreturned')
        ->where('status', 0)
        ->get();

        return view('assigned_item_forms.accountability_form',compact('assigned_items'));
    }

    public function asset_return_form($id)
    {
        $employee = Employees::findOrFail($id);

        $history_items = ItemHistory::where('employeeID', $employee->id)
        ->orderBy('created_at', 'desc')
        ->where('status', 0)
        ->get();

        return view('assigned_item_forms.asset_return',compact('history_items'));
    }

    public function confirm_accountability($id)
    {

        $employee = Employees::findOrFail($id);
        $assigned_items = AssignedItem::where('employeeID', $employee->id)
        ->where('status', 0)
        ->get();
       
        // Update the status of the assigned items to 1 (or any other status you wish)
        foreach ($assigned_items as $assigned_item) {
            $assigned_item->status = 1; // Update the status to 1 (you can change this if needed)
            $assigned_item->save(); // Save the change to the database
        }

        return redirect('form');
    }

    public function confirm_History($id)
    {

        $employee = Employees::findOrFail($id);
        $history_items = ItemHistory::where('employeeID', $employee->id)
        ->where('status', 0)
        ->get();

       
        // Update the status of the assigned items to 1 (or any other status you wish)
        foreach ($history_items as $history_item) {
            $history_item->status = 1; // Update the status to 1 (you can change this if needed)
            $history_item->save(); // Save the change to the database
        }


        return redirect('form');
    }
    
    
}
