<nav x-data="{ open: false }" class="bg-blue">
    <!-- Primary Navigation Menu -->
    <div class="max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14"> <!-- Reduced height from h-16 to h-14 -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo />
                    </a>
                </div>
            </div>
<body>           
        <!-- Flag Selector -->
        <div class="flag-selector">
            <div class="flag-container">
                <div class="flag-button flag-australia" data-flag="australia" data-country="Australia" onclick="changeBackground('australia')"></div>
                <span class="flag-name">Australia</span>
            </div>
            <div class="flag-container">
                <div class="flag-button flag-canada" data-flag="canada" data-country="Canada" onclick="changeBackground('canada')"></div>
                <span class="flag-name">Canada</span>
            </div>
            <div class="flag-container">
                <div class="flag-button flag-newzealand" data-flag="newzealand" data-country="New Zealand" onclick="changeBackground('newzealand')"></div>
                <span class="flag-name">New Zealand</span>
            </div>
            <div class="flag-container">
                <div class="flag-button flag-germany" data-flag="germany" data-country="Germany" onclick="changeBackground('germany')"></div>
                <span class="flag-name">Germany</span>
            </div>
            <div class="flag-container">
                <div class="flag-button flag-ireland" data-flag="ireland" data-country="Ireland" onclick="changeBackground('ireland')"></div>
                <span class="flag-name">Ireland</span>
            </div>
            <div class="flag-container">
                <div class="flag-button flag-unitedkingdom" data-flag="unitedkingdom" data-country="United Kingdom" onclick="changeBackground('unitedkingdom')"></div>
                <span class="flag-name">UK</span>
            </div>
        </div>

            <!-- Social Media Icons Container -->
            <div class="flex items-center space-x-1"> <!-- More compact spacing -->
                <!-- TikTok -->
                <div class="social-icon">
                    <a href="https://www.tiktok.com/@enz.consultancy" target="_blank">
                        <button class="button btn-1">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 48 48" fill="#1e90ff"> 
                                <path d="M38.0766847,15.8542954 C36.0693906,15.7935177 34.2504839,14.8341149 32.8791434,13.5466056 C32.1316475,12.8317108 31.540171,11.9694126 31.1415066,11.0151329 C30.7426093,10.0603874 30.5453728,9.03391952 30.5619062,8 L24.9731521,8 L24.9731521,28.8295196 C24.9731521,32.3434487 22.8773693,34.4182737 20.2765028,34.4182737 C19.6505623,34.4320127 19.0283477,34.3209362 18.4461858,34.0908659 C17.8640239,33.8612612 17.3337909,33.5175528 16.8862248,33.0797671 C16.4386588,32.6422142 16.0833071,32.1196657 15.8404292,31.5426268 C15.5977841,30.9658208 15.4727358,30.3459348 15.4727358,29.7202272 C15.4727358,29.0940539 15.5977841,28.4746337 15.8404292,27.8978277 C16.0833071,27.3207888 16.4386588,26.7980074 16.8862248,26.3604545 C17.3337909,25.9229017 17.8640239,25.5791933 18.4461858,25.3491229 C19.0283477,25.1192854 19.6505623,25.0084418 20.2765028,25.0219479 C20.7939283,25.0263724 21.3069293,25.1167239 21.794781,25.2902081 L21.794781,19.5985278 C21.2957518,19.4900128 20.7869423,19.436221 20.2765028,19.4380839 C18.2431278,19.4392483 16.2560928,20.0426009 14.5659604,21.1729264 C12.875828,22.303019 11.5587449,23.9090873 10.7814424,25.7878401 C10.003907,27.666593 9.80084889,29.7339663 10.1981162,31.7275214 C10.5953834,33.7217752 11.5748126,35.5530237 13.0129853,36.9904978 C14.4509252,38.4277391 16.2828722,39.4064696 18.277126,39.8028054 C20.2711469,40.1991413 22.3382874,39.9951517 24.2163416,39.2169177 C26.0948616,38.4384508 27.7002312,37.1209021 28.8296253,35.4300711 C29.9592522,33.7397058 30.5619062,31.7522051 30.5619062,29.7188301 L30.5619062,18.8324027 C32.7275484,20.3418321 35.3149087,21.0404263 38.0766847,21.0867664 L38.0766847,15.8542954 Z"></path>
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- Instagram -->
                <div class="social-icon">
                    <a href="https://www.instagram.com/enzconsultancy" target="_blank">
                        <button class="button btn-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#ff00ff">
                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- YouTube -->
                <div class="social-icon">
                    <a href="https://www.youtube.com/@enzconsultancy" target="_blank">
                        <button class="button btn-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="red"> 
                                <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"></path>
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- Facebook -->
                <div class="social-icon">
                    <a href="https://www.facebook.com/enzecs" target="_blank">
                        <button class="button btn-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512" fill="#1e90ff">
                                <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- LinkedIn -->
                <div class="social-icon">
                    <a href="https://www.linkedin.com/company/enz/" target="_blank">
                        <button class="button btn-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="#1e90ff">
                                <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- Admin Profile Dropdown -->
                <div class="ml-2 hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="20">
                        <x-slot name="trigger">
                            <button class="profile-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                                <span>ADMIN</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <button class="Btn">
                                    <div class="sign">
                                        <svg viewBox="0 0 19 19">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                             <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                                        </svg>
                                    </div>
                                    <div class="text">Profile</div>
                                </button>
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link onclick="event.preventDefault(); this.closest('form').submit();">
                                    <button class="Btn">
                                        <div class="sign">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                            </svg>
                                        </div>
                                        <div class="text">Logout</div>
                                    </button>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
</body>

<style>
    body {
            background: linear-gradient(to right,#449DD1,rgb(243, 249, 252));
        }
    
    * Icons Container */
        .icons-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Uniform Icon Styling */
        .icon-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .icon-wrapper:hover {
            background-color: rgba(0,0,0,0.1);
            transform: scale(1.1);
        }

        .icon-wrapper svg {
            width: 24px;
            height: 24px;
        }
        /* Flag Selector */
        .flag-selector {
            display: flex;
            gap: 50px;
            align-items: center;
        }

        .flag-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .flag-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .flag-button:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }

        .flag-button.active {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.3);
        }

        .flag-name {
            font-size: 13px;
            color: #333;
            text-align: center;
        }

        /* Flag SVGs (kept from previous implementation) */
        .flag-australia { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='30' fill='%230052B4'/%3E%3Cpath fill='%23FFF' d='M30 0l15 25.98-15 25.98L15 25.98z'/%3E%3Cpath fill='%23C8102E' d='M0 30l30-15 30 15-30 15z'/%3E%3C/svg%3E"); }
        .flag-canada { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='30' fill='%23FFF'/%3E%3Cpath fill='%23FF0000' d='M0 0h25v60H0zM35 0h25v60H35z'/%3E%3Cpath fill='%23FF0000' d='M30 15l-6 9h12z M30 45l-6-9h12z'/%3E%3C/svg%3E"); }
        .flag-newzealand { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='30' fill='%23012169'/%3E%3Cpath fill='%23FFF' d='M0 0l30 15L0 30z'/%3E%3Cpath fill='%23C8102E' d='M0 0h15l45 60h-15zM60 0h-15L0 60h15z'/%3E%3Cpath fill='%23FFF' d='M24.75 21l-2.25-6.75-2.25 6.75h-7.5l6 4.5-2.25 6.75 6-4.5 6 4.5-2.25-6.75 6-4.5z'/%3E%3C/svg%3E"); }
        .flag-germany { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='30' fill='%23000000'/%3E%3Crect width='60' height='20' y='0' fill='%23DD0000'/%3E%3Crect width='60' height='20' y='20' fill='%23FFCC00'/%3E%3Crect width='60' height='20' y='40' fill='%23FF0000'/%3E%3C/svg%3E"); }
        .flag-ireland { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='30' fill='%23FFF'/%3E%3Crect width='20' height='60' fill='%23169B62'/%3E%3Crect width='20' height='60' x='40' fill='%23FF883E'/%3E%3C/svg%3E"); }
        .flag-unitedkingdom { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 60'%3E%3Crect width='60' height='60' fill='%23012169'/%3E%3Cpath fill='%23FFF' d='M30 0v30h30v-30z'/%3E%3Cpath fill='%23FFF' d='M0 0v30h30v-30z'/%3E%3Cpath fill='%23C8102E' d='M0 0l30 30h30l-30-30z'/%3E%3Cpath fill='%23C8102E' d='M0 30l30-30h30l-30 30z'/%3E%3Cpath fill='%23C8102E' d='M30 0l-15 15h10v30h10v-30h10z'/%3E%3Cpath fill='%23C8102E' d='M30 30h15v10l-15-10z'/%3E%3C/svg%3E"); }
    /* General navigation styling */
    nav {
        min-height: 56px; /* Fixed minimum height */
        max-height: 56px; /* Fixed maximum height */
    }
    
    /* Social media icons styling */
    .social-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 32px; /* Reduced from 40px */
        height: 32px; /* Reduced from 40px */
        transition: all 0.3s ease-in-out;
        border-radius: 50%;
    }
    
    .social-icon:hover {
        background-color: white;
        transform: rotate3d(0.5, 1, 0, 30deg);
        transform: perspective(180px) rotateX(60deg) translateY(2px);
        box-shadow: 0px 5px 5px rgb(1, 49, 182); /* Reduced shadow size */
    }
    
    .button {
        background: transparent;
        border: none;
        padding: 6px; /* Reduced padding */
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .button svg {
        width: 16px; /* Reduced from implied 1em */
        height: 16px; /* Reduced from implied 1em */
    }
    
    /* Profile button styling */
    .profile-btn {
        padding: 0;
        border: 0;
        background-color: transparent;
        display: flex;
        align-items: center;
        padding-left: 8px; /* Reduced padding */
        border-left: 1px solid #ddd; /* Thinner border */
    }
    
    .profile-btn span {
        font-size: 14px; /* Smaller font */
        line-height: 20px;
        font-weight: 700;
        margin-left: 4px;
    }
    
    /* Dropdown button styling */
    .Btn {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition-duration: .3s;
        background-color: #f3f3f3;
    }
    
    .sign {
        width: 24%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .sign svg {
        width: 20px; /* Smaller icon */
    }
    
    .sign svg path {
        fill: #2e2e2e;
    }
    
    .text {
        position: center;
        right: 0;
        width: 0;
        opacity: 0;
        color: #2e2e2e;
        font-size: 14px; /* Smaller font */
        font-weight: 100;
        transition-duration: .3s;
    }
    
    .Btn:hover {
        width: 120px; /* Fixed width on hover */
        transition-duration: .3s;
    }
    
    .Btn:hover .sign {
        width: 24%;
        transition-duration: .3s;
        padding-left: 16px; /* Reduced padding */
    }
    
    .Btn:hover .text {
        opacity: 1;
        width: 70%;
        transition-duration: .3s;
        padding-right: 8px; /* Reduced padding */
    }
    
    .Btn:active {
        transform: translate(1px, 1px); /* Smaller movement */
    }
</style>

<script>
        const flagButtons = document.querySelectorAll('.flag-button');

        function changeBackground(country) {
            // Remove active class from all buttons
            flagButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Add active class to selected button
            const selectedButton = document.querySelector(`.flag-${country}`);
            selectedButton.classList.add('active');

            // Optional: Add additional functionality as needed
            console.log(`Selected country: ${country}`);
        }

        // Set initial background to first flag
        changeBackground('australia');
    </script>