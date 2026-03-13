<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Payroll System')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
            <div class="px-8 py-4 flex justify-between items-center">
                <div class="flex items-center text-sm font-medium text-gray-500">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    @yield('title', 'Dashboard')
                </div>
                
                @auth
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-700 bg-slate-100 py-1.5 px-3 rounded-full">
                        Admin User
                    </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="button" 
                            onclick="confirmAction({
                                title: 'Confirm Logout',
                                message: 'Are you sure you want to end your session?',
                                buttonText: 'Logout',
                                onConfirm: () => document.getElementById('logout-form').submit()
                            })"
                            class="text-sm text-red-500 hover:text-red-700 font-medium transition flex items-center gap-1">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                           Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </header>

        <!-- Main content area -->
        <main class="flex-1 p-8">
            @include('layouts.partials.toast')
            @include('layouts.partials.confirm_modal')
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>

</body>
</html>