<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
    <!-- Inline Styles -->
    <style>
        body { background: linear-gradient(to right, #667eea, #764ba2); background-position: center; background-size: cover; }
        .flag-selector { space:10; display: flex; justify-content: center; align-items: center; }
        .flag-button { width: 60px; height: 60px; margin: 0 8px; border-radius: 50%; background-size: cover; background-position: center; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease; border: 3px solid transparent; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .flag-button:hover { transform: scale(1.1); box-shadow: 0 8px 15px rgba(0,0,0,0.2); }
        .flag-button.active { border-color: #007bff; box-shadow: 0 0 0 3px #007bff, 0 10px 20px rgba(0,123,255,0.3); }
        .country-name { text-align: center; width: 100%; margin-bottom: 20px; font-weight: 600; font-size: 1.5rem; }
        .flag-australia { background-image: url('https://flagcdn.com/w320/au.png'); }
        .flag-canada { background-image: url('https://flagcdn.com/w320/ca.png'); }
        .flag-newzealand { background-image: url('https://flagcdn.com/w320/nz.png'); }
        .flag-germany { background-image: url('https://flagcdn.com/w320/de.png'); }
        .flag-ireland { background-image: url('https://flagcdn.com/w320/ie.png'); }
        .flag-unitedkingdom { background-image: url('https://flagcdn.com/w320/gb.png'); }
        .relative { position: relative; }
        .led-border-side { position: absolute; top: -4px; left: -4px; right: -4px; bottom: -4px; border-radius: calc(0.5rem + 4px); pointer-events: none; background: linear-gradient(to right, #0000FF 0%, #8A2BE2 25%, #0000FF 50%, #8A2BE2 75%, #0000FF 100%); background-size: 200% 100%; animation: led-border-flow 10s linear infinite; z-index: 1; mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); mask-composite: exclude; padding: 4px; border: 4px solid transparent; }
        @keyframes led-border-flow { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .dark .led-border-side { background: linear-gradient(to right, #4169E1 0%, #9932CC 25%, #4169E1 50%, #9932CC 75%, #4169E1 100%); }
        .content-container { width: 100%; max-width: 900px; margin: 0 auto; padding: 20px; }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <!-- Header with Navigation -->
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between">
                @auth
                    <a href="{{ url('/home') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg hover:shadow-xl">Dashboard</a>
                @else
                    <!-- This div with ml-auto pushes the login button to the right -->
                    <div class="ml-auto">
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-transparent border-2 border-indigo-500 text-emerald-600 dark:text-white dark:border-emerald-300 rounded-full hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-300 dark:hover:text-white-900 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-md hover:shadow-lg">LOGIN</a>
                    </div>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Logo Section - MEDIUM SIZE -->
    <div>
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/cmY5BZBwJOjDMpbqlHkj/media/e31bd3b3-041a-43fd-99ee-474eaeeced24.png" 
        alt="ENZ Education Consultancy Services Logo" class="w-40 h-40 object-contain flex justify-center" loading="lazy">
    </div>

    <!-- Main Content Area -->
    <main class="w-full lg:max-w-4xl max-w-[335px]">
        <!-- Flag Selector -->
        <div class="flag-selector mb-6 flex justify-center items-center gap-2">
            <div class="flag-button flag-australia" data-flag="australia" data-country="Australia" onclick="changeBackground('australia')"></div>
            <div class="flag-button flag-canada" data-flag="canada" data-country="Canada" onclick="changeBackground('canada')"></div>
            <div class="flag-button flag-newzealand" data-flag="newzealand" data-country="New Zealand" onclick="changeBackground('newzealand')"></div>
            <div class="flag-button flag-germany" data-flag="germany" data-country="Germany" onclick="changeBackground('germany')"></div>
            <div class="flag-button flag-ireland" data-flag="ireland" data-country="Ireland" onclick="changeBackground('ireland')"></div>
            <div class="flag-button flag-unitedkingdom" data-flag="unitedkingdom" data-country="United Kingdom" onclick="changeBackground('unitedkingdom')"></div>
        </div>

        <!-- Country Name Display - CENTERED -->
        <div class="country-name text-xl font-bold text-[#706f6c] dark:text-white text-center" id="countryName">Australia</div>

        <!-- Content Container -->
        <div class="content-container mx-auto max-w-4xl px-4">
            <div class="relative">
                <div class="led-border-side"></div>
                <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-4 shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] relative z-10">
                    <div class="flex flex-row items-center gap-4">
                        <!-- Text Content (Left) -->
                        <div class="w-full lg:w-3/4 text-left">
                            <h1 class="text-2xl font-medium mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">EXPANDING ONE'S HORIZON</h1>
                            <h2 class="text-xl font-medium mb-2 text-[#706f6c] dark:text-white">ENZ Education Consultancy Services: Your Gateway to Global Education</h2>
                            <p class="text-x1 text-[#1b1b18] dark:text-[#EDEDEC] leading-relaxed">Unlock a world of possibilities with ENZ Education Consultancy Services. We are your one-stop shop for navigating the exciting journey of studying abroad. ENZ is your trusted partner in achieving your educational goals.</p>
                        </div>

                        <!-- Image (Right) -->
                        <div class="w-full lg:w-1/4 flex justify-center items-center h-full">
                            <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_640/u_https://assets.cdn.filesafe.space/cmY5BZBwJOjDMpbqlHkj/media/661e6fba6a855b2d7a8658e6.png" class="w-43 h-43 object-contain" loading="lazy" alt="ENZ Education Consultancy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Spacing Conditional -->
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <!-- Background Element -->
    <div class="flag-background" id="flagBackground"></div>

    <!-- Scripts -->
    <script>
        const flagBackground = document.getElementById('flagBackground');
        const flagButtons = document.querySelectorAll('.flag-button');
        const countryName = document.getElementById('countryName');
        function changeBackground(country) {
            flagButtons.forEach(button => { button.classList.remove('active'); });
            const selectedButton = document.querySelector(`.flag-${country}`);
            selectedButton.classList.add('active');
            flagBackground.style.backgroundImage = window.getComputedStyle(selectedButton).backgroundImage;
            countryName.textContent = selectedButton.getAttribute('data-country');
        }
        changeBackground('australia');
    </script>
</body>

</html>