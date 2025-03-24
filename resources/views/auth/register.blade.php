@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-lg">
            <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-6">Register</h1>
            
            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-gray-700 font-semibold">First Name</label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('first_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-gray-700 font-semibold">Last Name</label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('last_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Employee Number -->
                <div>
                    <label for="employee_number" class="block text-gray-700 font-semibold">Employee Number</label>
                    <input id="employee_number" type="text" name="employee_number" value="{{ old('employee_number') }}" required 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('employee_number')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-gray-700 font-semibold">Department</label>
                    <input id="department" type="text" name="department" value="{{ old('department') }}" required 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('department')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Hire Date -->
                <div>
                    <label for="hire_date" class="block text-gray-700 font-semibold">Hire Date</label>
                    <input id="hire_date" type="date" name="hire_date" value="{{ old('hire_date') }}" required 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('hire_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('password_confirmation')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600 transition duration-200">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
