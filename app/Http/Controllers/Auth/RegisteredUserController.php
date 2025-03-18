<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employees;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        // Create the User record
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
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

        // Redirect to the dashboard or a different page after successful registration
        return redirect()->route('user'); // Or you can change it to route('home') or wherever you want to redirect
    }
}
