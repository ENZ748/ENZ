<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\Equipments;
use App\Models\Accountability;
use App\Models\AssignedItem;
use App\Models\Item;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $employees = Employees::whereHas('users', function ($query) {
            $query->where('usertype', 'user');
        })
        ->with(['users' => function ($query) {
            $query->select('id', 'email', 'password');  // Select specific fields from the users table
        }])
        ->orderBy('hire_date', 'desc')
        ->get();
        
        return view('users.index', compact('employees'));
        
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        $user = User::find($employee->user_id);

        // Check if user exists
        if ($user) {
            // Update the user's email and password
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            // Handle the case if the user is not found (optional)
            return back()->withErrors(['error' => 'User not found!']);
        }

        $user = Auth::user(); 
      
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Update user account '. $request->employee_number,
        ]);

        return redirect()-> route('user')->with('success', 'Equipment Updated successfully');  

    }   

    public function items($id)
    {
        $items = AssignedItem::where('employeeID', $id)
        ->where('item_status', 'unreturned')->get();
        
        // Initialize an empty collection to hold the assigned items
        $assigned_items = collect();
    
        // Loop through each accountability record
        foreach ($items as $item) {
            // Retrieve employee and equipment details
            $equipment = Item::find($item->itemID);
            
            if ($equipment) {
                $assigned_items->push([
                    'equipment_category' => $equipment->category->category_name,
                    'equipment_brand' => $equipment->brand->brand_name,
                    'equipment_unit' => $equipment->unit->unit_name,
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

        $user = Auth::user(); 
      
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Update User Status',
        ]);

        // Redirect back to the employee list page with a success message
        return redirect()->route('user')->with('success', 'Employee status updated successfully.');
    }
}
