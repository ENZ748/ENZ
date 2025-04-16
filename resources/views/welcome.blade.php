<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
    <!-- Inline Styles -->
    <style>
        body { background: linear-gradient(to right, #667eea, #764ba2); background-position: center; background-size: cover; }
        .item-selector { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 25px;
        }
        .item-button { 
            width: 85px; 
            height: 85px; 
            border-radius: 50%; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            border: 3px solid transparent; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .item-button:hover { 
            transform: scale(1.1); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.2); 
        }
        .item-button.active { 
            border-color: #007bff; 
            box-shadow: 0 0 0 3px #007bff, 0 10px 20px rgba(0,123,255,0.3); 
        }
        .item-name { 
            text-align: center; 
            width: 100%; 
            margin-bottom: 20px; 
            font-weight: 600; 
            font-size: 1.5rem; 
        }
        
        /* Item icons */
        .item-icon {
            font-size: 36px;
            color: #333;
        }
        
        /* Specific icon colors */
        .item-button[data-item="laptop"] .item-icon { color: #2c3e50; }
        .item-button[data-item="mouse"] .item-icon { color: #7f8c8d; }
        .item-button[data-item="iphone"] .item-icon { color: #3498db; }
        .item-button[data-item="ipad"] .item-icon { color: #9b59b6; }
        .item-button[data-item="keyboard"] .item-icon { color: #34495e; }
        .item-button[data-item="gopro"] .item-icon { color: #e74c3c; }
        
        /* Logo container */
        .logo-container {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
        }
        
        .relative { position: relative; }
        .led-border-side { 
            position: absolute; 
            top: -4px; 
            left: -4px; 
            right: -4px; 
            bottom: -4px; 
            border-radius: calc(0.5rem + 4px); 
            pointer-events: none; 
            background: linear-gradient(to right, #0000FF 0%, #8A2BE2 25%, #0000FF 50%, #8A2BE2 75%, #0000FF 100%); 
            background-size: 200% 100%; 
            animation: led-border-flow 10s linear infinite; 
            z-index: 1; 
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); 
            mask-composite: exclude; 
            padding: 4px; 
            border: 4px solid transparent; 
        }
        @keyframes led-border-flow { 
            0% { background-position: 200% 0; } 
            100% { background-position: -200% 0; } 
        }
        .dark .led-border-side { 
            background: linear-gradient(to right, #4169E1 0%, #9932CC 25%, #4169E1 50%, #9932CC 75%, #4169E1 100%); 
        }
        .content-container { 
            width: 100%; 
            max-width: 900px; 
            margin: 0 auto; 
            padding: 20px; 
        }
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
                    <div class="ml-auto">
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-transparent border-2 border-indigo-500 text-emerald-600 dark:text-white dark:border-emerald-300 rounded-full hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-300 dark:hover:text-white-900 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-md hover:shadow-lg">LOGIN</a>
                    </div>
                @endauth
            </nav>
        @endif
    </header>
    <div class="logo-container">
    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <!-- Circular background -->
        <circle cx="100" cy="100" r="100" fill="#f8f9fa" stroke="#e9ecef" stroke-width="2"/>
        
        <!-- Enlarged and more prominent content -->
        <!-- Boxes - made larger and moved closer to center -->
        <rect x="50" y="70" width="40" height="40" fill="#4a6fa5" rx="3" ry="3"/>
        <rect x="95" y="70" width="40" height="40" fill="#6c8ebf" rx="3" ry="3"/>
        <rect x="140" y="70" width="40" height="40" fill="#86a5d9" rx="3" ry="3"/>
        
        <!-- Checklist - thicker lines and better spacing -->
        <rect x="60" y="130" width="90" height="4" fill="#2c3e50"/>
        <rect x="60" y="142" width="70" height="4" fill="#2c3e50"/>
        <rect x="60" y="154" width="80" height="4" fill="#2c3e50"/>
        
        <!-- Checkmark - larger and more visible -->
        <circle cx="50" cy="131" r="7" fill="#4caf50"/>
        <path d="M46 131 L49 134 L54 129" stroke="white" stroke-width="2" fill="none"/>
        
        <!-- Bar Graph - more prominent bars -->
        <line x1="50" y1="60" x2="150" y2="60" stroke="#2c3e50" stroke-width="1.5"/>
        <rect x="55" y="40" width="12" height="20" fill="#4a6fa5" rx="1" ry="1"/>
        <rect x="70" y="30" width="12" height="30" fill="#4a6fa5" rx="1" ry="1"/>
        <rect x="85" y="50" width="12" height="10" fill="#4a6fa5" rx="1" ry="1"/>
        <rect x="100" y="20" width="12" height="40" fill="#4a6fa5" rx="1" ry="1"/>
        <rect x="115" y="40" width="12" height="20" fill="#4a6fa5" rx="1" ry="1"/>
    </svg>
</div>
    <!-- Main Content Area -->
    <main class="w-full lg:max-w-4xl max-w-[335px]">
        <!-- Item Selector with Font Awesome icons - Made slightly larger -->
        <div class="item-selector">
            <!-- Laptop -->
            <div class="item-button" data-item="laptop" data-itemname="LAPTOP" onclick="changeBackground('laptop')">
                <i class="fas fa-laptop item-icon"></i>
            </div>
            
            <!-- Mouse -->
            <div class="item-button" data-item="mouse" data-itemname="MOUSE" onclick="changeBackground('mouse')">
                <i class="fas fa-mouse item-icon"></i>
            </div>
            
            <!-- iPhone -->
            <div class="item-button" data-item="iphone" data-itemname="IPHONE" onclick="changeBackground('iphone')">
                <i class="fas fa-mobile-alt item-icon"></i>
            </div>
            
            <!-- iPad -->
            <div class="item-button" data-item="ipad" data-itemname="IPAD" onclick="changeBackground('ipad')">
                <i class="fas fa-tablet-alt item-icon"></i>
            </div>
            
            <!-- Keyboard -->
            <div class="item-button" data-item="keyboard" data-itemname="KEYBOARD" onclick="changeBackground('keyboard')">
                <i class="fas fa-keyboard item-icon"></i>
            </div>
            
            <!-- GoPro -->
            <div class="item-button" data-item="gopro" data-itemname="GOPRO" onclick="changeBackground('gopro')">
                <i class="fas fa-camera item-icon"></i>
            </div>
        </div>

        <!-- Item Name Display -->
        <div class="item-name text-xl font-bold text-[#706f6c] dark:text-white text-center" id="itemName">LAPTOP</div>

        <!-- Content Container -->
<div class="content-container mx-auto max-w-4xl px-4">
    <div class="relative">
        <div class="led-border-side"></div>
        <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-4 shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] relative z-10">
            <div class="flex flex-row items-center gap-4">
                <!-- Text Content (Left) -->
                <div class="w-full lg:w-3/4 text-left">
                    <h1 class="text-2xl font-medium mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">COMPREHENSIVE INVENTORY MANAGEMENT</h1>
                    <h2 class="text-xl font-medium mb-2 text-[#706f6c] dark:text-white">Tech Inventory System: Track and Manage Your Equipment</h2>
                    <p class="text-x1 text-[#1b1b18] dark:text-[#EDEDEC] leading-relaxed">Our inventory management system provides real-time tracking of all your tech equipment. Easily monitor device status, check availability, and manage assignments. Keep your assets organized and maximize their utilization with our powerful tracking tools.</p>
                </div>

                <!-- Image and Social Links (Right) -->
                <div class="w-full lg:w-1/4 flex flex-col justify-center items-center gap-4">
                    <img src="https://img.freepik.com/free-photo/inventory-stock-manufacturing-assets-goods-concept_53876-133673.jpg" class="w-43 h-43 object-cover rounded-lg" loading="lazy" alt="Inventory Management">
                    
                    <!-- Social Links Container -->
                    <div class="w-full bg-gray-100 dark:bg-gray-800 p-3 rounded-lg">
                        <h3 class="text-center font-medium mb-2 text-[#1b1b18] dark:text-white">Connect With Us</h3>
                        <div class="flex justify-center space-x-4">
                            <a href="https://www.tiktok.com/@enz.consultancy" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 48 48" fill="currentColor">
                                    <path d="M38.0766847,15.8542954 C36.0693906,15.7935177 34.2504839,14.8341149 32.8791434,13.5466056 C32.1316475,12.8317108 31.540171,11.9694126 31.1415066,11.0151329 C30.7426093,10.0603874 30.5453728,9.03391952 30.5619062,8 L24.9731521,8 L24.9731521,28.8295196 C24.9731521,32.3434487 22.8773693,34.4182737 20.2765028,34.4182737 C19.6505623,34.4320127 19.0283477,34.3209362 18.4461858,34.0908659 C17.8640239,33.8612612 17.3337909,33.5175528 16.8862248,33.0797671 C16.4386588,32.6422142 16.0833071,32.1196657 15.8404292,31.5426268 C15.5977841,30.9658208 15.4727358,30.3459348 15.4727358,29.7202272 C15.4727358,29.0940539 15.5977841,28.4746337 15.8404292,27.8978277 C16.0833071,27.3207888 16.4386588,26.7980074 16.8862248,26.3604545 C17.3337909,25.9229017 17.8640239,25.5791933 18.4461858,25.3491229 C19.0283477,25.1192854 19.6505623,25.0084418 20.2765028,25.0219479 C20.7939283,25.0263724 21.3069293,25.1167239 21.794781,25.2902081 L21.794781,19.5985278 C21.2957518,19.4900128 20.7869423,19.436221 20.2765028,19.4380839 C18.2431278,19.4392483 16.2560928,20.0426009 14.5659604,21.1729264 C12.875828,22.303019 11.5587449,23.9090873 10.7814424,25.7878401 C10.003907,27.666593 9.80084889,29.7339663 10.1981162,31.7275214 C10.5953834,33.7217752 11.5748126,35.5530237 13.0129853,36.9904978 C14.4509252,38.4277391 16.2828722,39.4064696 18.277126,39.8028054 C20.2711469,40.1991413 22.3382874,39.9951517 24.2163416,39.2169177 C26.0948616,38.4384508 27.7002312,37.1209021 28.8296253,35.4300711 C29.9592522,33.7397058 30.5619062,31.7522051 30.5619062,29.7188301 L30.5619062,18.8324027 C32.7275484,20.3418321 35.3149087,21.0404263 38.0766847,21.0867664 L38.0766847,15.8542954 Z"></path>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/enzconsultancy" target="_blank" class="text-pink-600 hover:text-pink-800 dark:text-pink-400 dark:hover:text-pink-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 448 512" fill="currentColor">
                                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                                </svg>
                            </a>
                            <a href="https://www.youtube.com/@enzconsultancy" target="_blank" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 576 512" fill="currentColor">
                                    <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"></path>
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/enzecs" target="_blank" class="text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 320 512" fill="currentColor">
                                    <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/company/enz/" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 448 512" fill="currentColor">
                                    <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Footer Spacing Conditional -->
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <!-- Scripts -->
    <script>
        const itemButtons = document.querySelectorAll('.item-button');
        const itemName = document.getElementById('itemName');
        
        function changeBackground(item) {
            itemButtons.forEach(button => { 
                button.classList.remove('active'); 
            });
            
            const selectedButton = document.querySelector(`.item-button[data-item="${item}"]`);
            selectedButton.classList.add('active');
            
            itemName.textContent = selectedButton.getAttribute('data-itemname');
        }
        
        // Initialize with laptop selected
        changeBackground('laptop');
    </script>
</body>
</html>