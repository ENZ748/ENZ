<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnItem;
use App\Models\Employees;
use App\Models\Equipments;


class HistoryController extends Controller
{
     public function index()
    {
        // Retrieve all accountability records (or use a specific query)
        $historyItems = ReturnItem::all();  // This retrieves all accountability records
    
        // Initialize an empty collection to hold the data for the view
        $returned_items = collect();
    
        // Loop through each accountability record
        foreach ($historyItems as $historyItem) {
            // Retrieve employee and equipment details using their IDs
            $employee = Employees::where('id', $historyItem->employee_id)->first();
            $equipment = Equipments::where('id', $historyItem->equipment_id)->first();
    
            // Add the data for each row to the returned_items collection
            $returned_items->push([
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'employee_number' => $employee->employee_number,
                'equipment_name' => $equipment->equipment_name,
                'equipment_detail' => $equipment->equipment_details,
                'id' => $historyItem->id,
                'created_at' => $historyItem->created_at
            ]);
        }
    
        // Pass the combined data to the view
        foreach ($historyItems as $historyItem) {
        return view('returned_items.index', compact('returned_items'));
       }
    }
    
}
