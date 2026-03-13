<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DCJ's Construction Services - Payroll System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    <!-- Vite Loading -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <!-- Logo Section -->
                    <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-3">
                        <img class="h-16 w-auto object-contain" src="{{ asset('images/Picture1.png') }}" alt="DCJ's Construction Services Logo">
                    </a>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition tracking-wide mr-4">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-md text-sm font-semibold transition shadow-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-md text-sm font-medium transition shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center bg-linear-to-br from-blue-50 to-white pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="flex flex-col md:flex-row items-center justify-center gap-4 text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                <img class="h-16 md:h-20 w-auto" src="{{ asset('images/Picture1.png') }}" alt="Logo">
                <div>
                    DCJ's Construction <span class="text-blue-600">Services</span>
                </div>
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto mb-10">
                Building With Integrity. Reliable payroll and employee management system tailored for construction operations.
            </p>
            
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3.5 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition">
                        Go to Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3.5 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition">
                        Access System
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} DCJ's Construction Services. All rights reserved. Built with Integrity.
        </div>
    </footer>

</body>
</html>
