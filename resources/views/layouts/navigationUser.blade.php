<nav x-data="{ open: false, sidebarOpen: false }" class="bg-gradient-to-r from-blue-700 to-blue-900 shadow-xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Left Side - Logo and Navigation Links -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <div class="mr-4 flex items-center md:hidden">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-blue-200 hover:text-white focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/cmY5BZBwJOjDMpbqlHkj/media/e31bd3b3-041a-43fd-99ee-474eaeeced24.png" 
                         alt="ENZ Education Consultancy Services Logo" 
                         class="w-32 h-32 object-contain" 
                         loading="lazy">
                </div>
            </div>

            <!-- Right Side Elements -->
            <div class="flex items-center space-x-4">
                <!-- Social Media Icons - Hidden on mobile -->
                <div class="hidden md:flex items-center space-x-3">
                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@enz.consultancy" target="_blank" class="social-icon group">
                        <div class="icon-container group-hover:bg-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5 fill-white group-hover:fill-[#FE2C55]">
                            <path d="M38.0766847,15.8542954 C36.0693906,15.7935177 34.2504839,14.8341149 32.8791434,13.5466056 C32.1316475,12.8317108 31.540171,11.9694126 31.1415066,11.0151329 C30.7426093,10.0603874 30.5453728,9.03391952 30.5619062,8 L24.9731521,8 L24.9731521,28.8295196 C24.9731521,32.3434487 22.8773693,34.4182737 20.2765028,34.4182737 C19.6505623,34.4320127 19.0283477,34.3209362 18.4461858,34.0908659 C17.8640239,33.8612612 17.3337909,33.5175528 16.8862248,33.0797671 C16.4386588,32.6422142 16.0833071,32.1196657 15.8404292,31.5426268 C15.5977841,30.9658208 15.4727358,30.3459348 15.4727358,29.7202272 C15.4727358,29.0940539 15.5977841,28.4746337 15.8404292,27.8978277 C16.0833071,27.3207888 16.4386588,26.7980074 16.8862248,26.3604545 C17.3337909,25.9229017 17.8640239,25.5791933 18.4461858,25.3491229 C19.0283477,25.1192854 19.6505623,25.0084418 20.2765028,25.0219479 C20.7939283,25.0263724 21.3069293,25.1167239 21.794781,25.2902081 L21.794781,19.5985278 C21.2957518,19.4900128 20.7869423,19.436221 20.2765028,19.4380839 C18.2431278,19.4392483 16.2560928,20.0426009 14.5659604,21.1729264 C12.875828,22.303019 11.5587449,23.9090873 10.7814424,25.7878401 C10.003907,27.666593 9.80084889,29.7339663 10.1981162,31.7275214 C10.5953834,33.7217752 11.5748126,35.5530237 13.0129853,36.9904978 C14.4509252,38.4277391 16.2828722,39.4064696 18.277126,39.8028054 C20.2711469,40.1991413 22.3382874,39.9951517 24.2163416,39.2169177 C26.0948616,38.4384508 27.7002312,37.1209021 28.8296253,35.4300711 C29.9592522,33.7397058 30.5619062,31.7522051 30.5619062,29.7188301 L30.5619062,18.8324027 C32.7275484,20.3418321 35.3149087,21.0404263 38.0766847,21.0867664 L38.0766847,15.8542954 Z"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/enzconsultancy" target="_blank" class="social-icon group">
                        <div class="icon-container group-hover:bg-gradient-to-r from-purple-500 to-pink-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-5 w-5 fill-white">
                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- YouTube -->
                    <a href="https://www.youtube.com/@enzconsultancy" target="_blank" class="social-icon group">
                        <div class="icon-container group-hover:bg-red-600 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-5 w-5 fill-white">
                            <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/enzecs" target="_blank" class="social-icon group">
                        <div class="icon-container group-hover:bg-blue-600 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="h-5 w-5 fill-white">
                                <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                            </svg>
                        </div>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/company/enz/" target="_blank" class="social-icon group">
                        <div class="icon-container group-hover:bg-blue-700 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-5 w-5 fill-white">
                                <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- User Profile Dropdown -->
                <div class="ml-2 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 focus:outline-none group">
                                <div class="relative">
                                    <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center transition-all duration-300 group-hover:bg-white/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 bg-green-400 rounded-full h-3 w-3 border-2 border-blue-600"></span>
                                </div>
                                <span class="hidden lg:inline-block text-white font-medium max-w-[120px] truncate">
                                {{ Auth::user()->employees?->first_name ?: 'No employee info' }}
                                </span>
                                <svg class="hidden lg:inline-block h-4 w-4 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link 
                                    href="{{ route('logout') }}" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="flex items-center text-gray-700 hover:bg-blue-50 border-t border-gray-100"
                                >
                                    <i class="fas fa-sign-out-alt mr-2 text-blue-600"></i>
                                    <span>Log Out</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 -translate-x-full"
         class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-800 shadow-lg md:hidden"
         @click.away="sidebarOpen = false">
         
        <div class="flex items-center justify-center h-20 px-4 bg-blue-900">
            <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/cmY5BZBwJOjDMpbqlHkj/media/e31bd3b3-041a-43fd-99ee-474eaeeced24.png" 
                 alt="ENZ Logo" 
                 class="h-12 object-contain">
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 p-4 bg-blue-900">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-blue-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-blue-300 text-xs">{{ Auth::user()->email }}</div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-700 hover:bg-blue-600 rounded-lg text-white transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Overlay for mobile sidebar -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"
     @click="sidebarOpen = false"
     style="display: none;">
</div>

<style>
    /* Enhanced Social Icons */
    .icon-container {
        height: 36px;
        width: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .social-icon:hover .icon-container {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Remove all link borders and outlines */
    a {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        text-decoration: none !important;
    }
    
    /* Remove focus states */
    a:focus, a:active {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    
    /* Remove any bottom borders */
    .border-b, .border-t {
        border-bottom: none !important;
        border-top: none !important;
    }

    /* Smooth transitions */
    .transition-slow {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Gradient animation */
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradientShift 10s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Focus styles */
    button:focus, input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Better font rendering */
    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }
</style>