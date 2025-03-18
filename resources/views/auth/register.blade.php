@extends('layouts.app') <!-- Extend the master layout -->

@section('content')
    <div class="bg-gray-100 p-6 flex justify-center items-center min-h-screen">
        <!-- Main container for the form with even smaller width -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Register</h1>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- First Name -->
                <div class="mt-4">
                    <label for="first_name" class="block text-gray-700">{{ __('First Name') }}</label>
                    <input id="first_name" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus />
                    @error('first_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <label for="last_name" class="block text-gray-700">{{ __('Last Name') }}</label>
                    <input id="last_name" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="text" name="last_name" value="{{ old('last_name') }}" required />
                    @error('last_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Employee Number -->
                <div class="mt-4">
                    <label for="employee_number" class="block text-gray-700">{{ __('Employee Number') }}</label>
                    <input id="employee_number" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="text" name="employee_number" value="{{ old('employee_number') }}" required />
                    @error('employee_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Department -->
                <div class="mt-4">
                    <label for="department" class="block text-gray-700">{{ __('Department') }}</label>
                    <input id="department" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="text" name="department" value="{{ old('department') }}" required />
                    @error('department')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Hire Date -->
                <div class="mt-4">
                    <label for="hire_date" class="block text-gray-700">{{ __('Hire Date') }}</label>
                    <input id="hire_date" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="date" name="hire_date" value="{{ old('hire_date') }}" required />
                    @error('hire_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-gray-700">{{ __('Email') }}</label>
                    <input id="email" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-gray-700">{{ __('Password') }}</label>
                    <input id="password" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-gray-700">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" class="block mt-1 w-full p-2 border border-gray-300 rounded" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="ml-4 bg-blue-500 text-z py-2 px-4 rounded hover:bg-blue-600">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
