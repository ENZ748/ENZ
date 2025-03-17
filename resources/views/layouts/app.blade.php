<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inventory Management') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

<<<<<<< HEAD
        <!-- Main Content -->
        <div class="flex-1">
            @include('layouts.navigation')
=======
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @include('layouts.navigation')
>>>>>>> 72400776f0e0117747e5abc5a27d345510702102

        <div class="min-h-screen bg-gray-100 flex">

        @include('layouts.sidebar')
            <!-- Main Content Area -->
            <div class="flex-1 p-6">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    <div class="content">
                        @yield('content')
                    </div>
<<<<<<< HEAD
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')  {{-- Replace $slot with @yield('content') --}}
            </main>
=======
                </main>
            </div>
>>>>>>> 72400776f0e0117747e5abc5a27d345510702102
        </div>
    </div>
</body>
</html>
