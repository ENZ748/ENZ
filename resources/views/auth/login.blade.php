<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
        }
        .login-container {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            overflow: hidden;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .input-field {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.5);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white login-container flex w-full max-w-3xl">
        <!-- Left Side: Image -->
        <div class="w-1/2 flex items-center justify-center bg-gray-200 p-6">
            <img src="EnzLogo.png" alt="Logo" class="w-48 h-48">
        </div>
        
        <!-- Right Side: Login Form -->
        <div class="w-1/2 p-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mb-1" />
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                        class="input-field w-full mt-1">
                </div>
                
                <!-- Password -->
                <div class="mb-4">
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mb-1" />
                    <label for="password" class="block text-gray-700 font-semibold">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="input-field w-full mt-1">
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                    <label for="remember_me" class="text-gray-600 text-sm">Remember me</label>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot your password?</a>
                    @endif
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-transform transform hover:scale-105">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
