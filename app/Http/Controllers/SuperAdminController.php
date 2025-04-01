<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employees;
use App\Models\ActivityLog;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class SuperAdminController extends Controller
{
    public function index()
    {
        $admins = Employees::whereHas('users', function ($query) {
            $query->where('usertype', 'admin');
        })->get();
        

        return view('superAdminAccounts.index', compact('admins'));
    }

    public function create()
    {
          return view('superAdminAccounts.add');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'employee_number' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date',
        ]);

        // Start a database transaction to ensure both records are created together
        try {
            \DB::beginTransaction();

            // Create the User record
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usertype' => 'admin',
            ]);

            // Create the Employee record and associate it with the User
            $employee = Employees::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'employee_number' => $request->employee_number,
                'department' => $request->department,
                'hire_date' => $request->hire_date,
                'user_id' => $user->id, // Assign the created user's ID to the employee
            ]);

            // Trigger the Registered event
            event(new Registered($user));

            // Commit the transaction
            \DB::commit();

            // Redirect to the dashboard or a different page after successful registration
            return redirect()->route('admin')->with('success', 'User and Employee created successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            \DB::rollback();

            // Log the error message for debugging
            \Log::error('Error during user and employee creation: ' . $e->getMessage());

            // Redirect back with error messages
            return redirect()->back()->withErrors(['error' => 'There was an issue creating the user and employee. Please try again.']);
        }
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

        return redirect()-> route('admin')->with('success', 'Equipment Updated successfully');  

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
        return redirect()->route('admin')->with('success', 'Employee status updated successfully.');
    }

    public function activityLog()
    {
        $activityLogs = ActivityLog::all();
        return view('activityLogs.index', compact('activityLogs'));
    }

}
