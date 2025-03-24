<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\Accountability;

class UserController extends Controller
{
    public function index()
    {
        $employees = Employees::orderBy('hire_date', 'desc')->get();

               
          return view('users.index',compact('employees'));
    }

    public function create()
    {
          return view('users.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'=>  'required|string|max:255',
            'employee_number' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date', 
        ]);

        Employees::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'employee_number' => $request->employee_number,
            'department' => $request->department,
            'hire_date' => $request->hire_date,

        ]);

        return redirect()-> route('user')->with('success', 'employee added  successfully');

    }
    // Update
    public function edit($id)
    {
         $employee = Employees::findOrFail($id);

          return view('users.edit', compact('employee'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'=>  'required|string|max:255',
            'employee_number' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date', 
        ]);

        $employee = Employees::findOrFail($id);
        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'employee_number' => $request->employee_number,
            'department' => $request->department,
            'hire_date' => $request->hire_date,

        ]);

        return redirect()-> route('user')->with('success', 'Equipment Updated successfully');  

    }   

    public function items($id)
    {
        $accountabilities = Accountability::where('employee_id', $id)->get();
        
        // Initialize an empty collection to hold the assigned items
        $assigned_items = collect();
    
        // Loop through each accountability record
        foreach ($accountabilities as $accountability) {
            // Retrieve employee and equipment details
            $equipment = Equipments::find($accountability->equipment_id);
    
            if ($equipment) {
                $assigned_items->push([
                    'equipment_name' => $equipment->equipment_name,
                    'equipment_detail' => $equipment->equipment_details,
                    'equipment_serialNumber' => $equipment->serial_number,
                ]);
            }
        }
    
        // Return the assigned items to the view
        return response()->json($assigned_items);
    }
    


    public function destroy($id)
    {
        Equipments::where('id', $id)->delete();

        return redirect()-> route('Employees')->with('success', 'Equipment deleted successfully');  
    }

    public function toggleStatus($id)
    {
        // Find the employee by ID
        $employee = Employees::findOrFail($id);

        // Toggle the 'active' status
        $employee->active = !$employee->active;

        // Save the updated employee record
        $employee->save();

        // Redirect back to the employee list page with a success message
        return redirect()->route('user')->with('success', 'Employee status updated successfully.');
    }
}
