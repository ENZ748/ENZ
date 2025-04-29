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
            $query->select('id', 'email', 'password');
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
            'last_name' => 'required|string|max:255',
            'employee_number' => 'required|string|max:255|unique:employees,employee_number',
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'email' => 'required|string|email|max:255|ends_with:@enzconsultancy.com|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user first
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'user',
        ]);

        // Then create employee with user_id
        Employees::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'employee_number' => $request->employee_number,
            'department' => $request->department,
            'hire_date' => $request->hire_date,
            'user_id' => $user->id,
        ]);

        return redirect()->route('user')->with('success', 'Employee added successfully');
    }

    public function edit($id)
    {
        $employee = Employees::with('users')->findOrFail($id);
        return view('users.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employees::with('users')->findOrFail($id);
        $user = $employee->users;

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'employee_number' => 'required|string|max:255|unique:employees,employee_number,'.$id,
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date',
        ];

        // Only validate email if it's changed
        if ($request->email !== $user->email) {
            $rules['email'] = 'required|string|email|max:255|ends_with:@enzconsultancy.com|unique:users,email,'.$user->id;
        }

        // Only validate password if it's provided
        if ($request->password) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $validatedData = $request->validate($rules);

        // Update employee data
        $employee->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'employee_number' => $validatedData['employee_number'],
            'department' => $validatedData['department'],
            'hire_date' => $validatedData['hire_date'],
        ]);

        // Prepare user data for update
        $userData = [];
        if (isset($validatedData['email']) && $validatedData['email'] !== $user->email) {
            $userData['email'] = $validatedData['email'];
        }
        if ($request->password) {
            $userData['password'] = Hash::make($validatedData['password']);
        }

        // Update user data if there are changes
        if (!empty($userData)) {
            $user->update($userData);
        }

        return redirect()->route('user')->with('success', 'Employee updated successfully');
    }

    public function items($id)
    {
        $items = AssignedItem::where('employeeID', $id)
            ->where('item_status', 'unreturned')->get();
        
        $assigned_items = collect();
    
        foreach ($items as $item) {
            $equipment = Item::find($item->itemID);
            
            if ($equipment) {
                $assigned_items->push([
                    'equipment_category' => $equipment->category->category_name,
                    'equipment_brand' => $equipment->brand->brand_name,
                    'equipment_unit' => $equipment->unit->unit_name,
                    'equipment_serialNumber' => $equipment->serial_number,
                    'assigned_date' => $item->created_at->format('Y-m-d'),
                ]);
            }
        }
    
        return response()->json($assigned_items);
    }

    public function destroy($id)
    {
        Equipments::where('id', $id)->delete();
        return redirect()->route('Employees')->with('success', 'Equipment deleted successfully');  
    }

    public function toggleStatus($id)
    {
        $employee = Employees::findOrFail($id);
        $employee->active = !$employee->active;
        $employee->save();

        $user = Auth::user();      
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_logs' => 'Update User Status',
        ]);

        return redirect()->route('user')->with('success', 'Employee status updated successfully.');
    }
}