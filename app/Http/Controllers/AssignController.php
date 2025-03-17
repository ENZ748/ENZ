<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accountability;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\ReturnItem;

class AssignController extends Controller
{
    
    public function index()
    {
        // Retrieve all accountability records (or use a specific query)
        $accountabilities = Accountability::all();  // This retrieves all accountability records
    
        // Initialize an empty collection to hold the data for the view
        $assigned_items = collect();
    
        // Loop through each accountability record
        foreach ($accountabilities as $accountability) {
            // Retrieve employee and equipment details using their IDs
            $employee = Employees::where('id', $accountability->employee_id)->first();
            $equipment = Equipments::where('id', $accountability->equipment_id)->first();
    
            // Add the data for each row to the assigned_items collection
            $assigned_items->push([
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'employee_number' => $employee->employee_number,
                'equipment_name' => $equipment->equipment_name,
                'equipment_detail' => $equipment->equipment_details,
                'id' => $accountability->id,
            ]);
        }
    
        // Pass the combined data to the view
        foreach ($accountabilities as $accountability) {
        return view('assign.index', compact('assigned_items'));
    }
    }
    
    

    public function create()
    {
        $employees = Employees::all();
        $equipments = Equipments::where('equipment_status', 0)->get();

          return view('assign.add',compact('employees', 'equipments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'employee_number' => 'required|string|max:255',
            'equipment_name' => 'required|string|max:255',
            'assigned_date' => 'required|date',
            'return_date' => 'required|date',
            'notes' => 'required|string|max:255',
            'assigned_by' => 'required|in:IT,HR',
        ]);
    
        // Get employee ID by employee number
        $employee_id = Employees::where('employee_number', $request->employee_number)->first()->id;
    
        // Get equipment ID by equipment name
        $equipment_id = Equipments::where('equipment_name', $request->equipment_name)->first()->id;
        

        Equipments::where('id', $equipment_id)->update([
            'equipment_status' => 1
        ]);


        // Create accountability record
        Accountability::create([
            'employee_id' => $employee_id,
            'equipment_id' => $equipment_id,
            'assigned_date' => $request->assigned_date,
            'return_date' => $request->return_date,
            'notes' => $request->notes,
            'assigned_by' => $request->assigned_by, // Make sure to add the 'assigned_by' field to the create method
        ]);

        
        return redirect()->route('accountability')->with('success', 'Successfully assigned');
    }

    public function edit($id)
    {
        // Find the accountability record by ID
        $accountability = Accountability::findOrFail($id);
        $employees = Employees::all();
        $equipments = Equipments::all();

        // Return the edit view with the data
        return view('assign.edit', compact('employees', 'equipments','accountability'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'employee_number' => 'required|string|max:255',
            'equipment_name' => 'required|string|max:255',
            'assigned_date' => 'required|date',
            'return_date' => 'required|date',
            'notes' => 'required|string|max:255',
            'assigned_by' => 'required|in:IT,HR', // Can be IT or HR
        ]);
        
        // Get the accountability record by ID
        $accountability = Accountability::findOrFail($id);
    
        // Get the employee ID by employee number
        $employee = Employees::where('employee_number', $request->employee_number)->first();
        if (!$employee) {
            return back()->withErrors(['employee_number' => 'Employee not found.'])->withInput();
        }
        
        // Get the equipment ID by equipment name
        $equipment = Equipments::where('equipment_name', $request->equipment_name)->first();
        if (!$equipment) {
            return back()->withErrors(['equipment_name' => 'Equipment not found.'])->withInput();
        }
        
        // Update the accountability record
        $accountability->update([
            'employee_id' => $employee->id,
            'equipment_id' => $equipment->id,
            'assigned_date' => $request->assigned_date,
            'return_date' => $request->return_date,
            'notes' => $request->notes,
            'assigned_by' => $request->assigned_by,
        ]);
        
        // Redirect back with a success message
        return redirect()->route('accountability')->with('success', 'Successfully updated');
    }

 
    public function destroy($id)
    {
        // Fetch the Accountability record
        $return_item = Accountability::findOrFail($id);

        // Store the item in the ReturnItem table
        ReturnItem::create([
            'employee_id' => $return_item->employee_id,
            'equipment_id' => $return_item->equipment_id, // Fixed the typo here
            'assigned_date' => $return_item->assigned_date,
            'return_date' => $return_item->return_date,
            'notes' => $return_item->notes,
            'assigned_by' => $return_item->assigned_by,
        ]);


        Equipments::where('id', $return_item->equipment_id)->update([
            'equipment_status' => 0
        ]);

        // Delete the Accountability record
        $return_item->delete();

        // Redirect with success message
        return redirect()->route('accountability')->with('success', 'Successfully returned');
    }

 
     
}
