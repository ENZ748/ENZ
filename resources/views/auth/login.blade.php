<x-guest-layout>
<div class="container">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <img src="EnzLogo.png" alt="Enz Logo">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <form>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full " type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
            <div class="button">Sign In</div>

            </x-primary-button>
            </form>
        </div>
    </form>
</div>

    <style>
     /* From Uiverse.io by jeel-sardhara */ 
.container {
  max-width: 350px;
  background: #f8f9fd;
  background: linear-gradient(
    0deg,
    rgb(255, 255, 255) 0%,
    rgb(244, 247, 251) 100%
  );
  border-radius: 40px;
  padding: 25px 35px;
  border: 5px solid rgb(255, 255, 255);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
  margin: 20px;
}

    .button {
            position: relative;
            display: inline-block;
            padding: 5px 5px;
            color: #b79726;
            font-size: 12px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 0px;
            letter-spacing: 2 px;
        }

        .button {
            background: #2772a1;
            font: 6px;
            color: #fff;
            border-radius: 0px;
            box-shadow: 0 0 5px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 10px #00a6bc,
                        0 0 20px #00a6bc;
        }



    .form {
    margin-top: 20px;
    }

    .form .input {
    width: 100%;
    background: #12b1d1; ;
    border: none;
    padding: 15px 20px;
    border-radius: 20px;
    margin-top: 15px;
    box-shadow: #cff0ff 0px 10px 10px -5px;
    border-inline: 2px solid transparent;
    }

    .form .input::-moz-placeholder {
    color: rgb(170, 170, 170);
    }

    .form .input::placeholder {
    color: rgb(170, 170, 170);
    }

    .form .input:focus {
    outline: none;
    border-inline: 2px solid #12b1d1;
    }

    .form .forgot-password {
    display: block;
    margin-top: 10px;
    margin-left: 10px;
    }

    .form .forgot-password a {
    font-size: 11px;
    color: #0099ff;
    text-decoration: none;
    }

    .form .login-button {
    display: block;
    width: 100%;
    font-weight: bold;
    background: linear-gradient(
        45deg,
        rgb(16, 137, 211) 0%,
        rgb(18, 177, 209) 100%
    );
    color: white;
    padding-block: 15px;
    margin: 20px auto;
    border-radius: 20px;
    box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
    border: none;
    transition: all 0.2s ease-in-out;
    }

    .form .login-button:hover {
    transform: scale(1.03);
    box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
    }

    .form .login-button:active {
    transform: scale(0.95);
    box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
    }

    .social-account-container {
    margin-top: 25px;
    }

    .social-account-container .title {
    display: block;
    text-align: center;
    font-size: 10px;
    color: rgb(170, 170, 170);
    }

    .social-account-container .social-accounts {
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 5px;
    }

    .social-account-container .social-accounts .social-button {
    border: 5px solid white;
    padding: 5px;
    border-radius: 50%;
    width: 40px;
    aspect-ratio: 1;
    display: grid;
    place-content: center;
    box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
    transition: all 0.2s ease-in-out;
    }

    .social-account-container .social-accounts .social-button .svg {
    fill: white;
    margin: auto;
    }

    .social-account-container .social-accounts .social-button:hover {
    transform: scale(1.2);
    }

    .social-account-container .social-accounts .social-button:active {
    transform: scale(0.9);
    }

    .agreement {
    display: block;
    text-align: center;
    margin-top: 15px;
    }

    .agreement a {
    text-decoration: none;
    color: #0099ff;
    font-size: 9px;
    }

    </style>
</x-guest-layout>
