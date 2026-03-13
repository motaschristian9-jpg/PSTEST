<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - System Core</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    <!-- Vite Loading -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased h-screen flex">

    <!-- Left side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white shadow-xl z-10 relative">
        <div class="w-full max-w-md space-y-8">
            
            <div class="text-center">
                <!-- Branding -->
                <div class="flex justify-center mb-6">
                    <img class="h-20 w-auto object-contain" src="{{ asset('images/Picture1.png') }}" alt="Logo">
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Access Dashboard</h2>
                <p class="mt-2 text-sm text-gray-500">Sign in to manage payroll, timecards, and reporting.</p>
            </div>

            <!-- Display validation errors as toasts handled by the partial below -->
            @include('layouts.partials.toast')
            @include('layouts.partials.confirm_modal')

            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        showToast("{{ $errors->first() }}", "error");
                    });
                </script>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6 mt-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Admin Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="username" class="pl-10 w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" placeholder="Enter username" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" class="pl-10 w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember" class="text-sm text-gray-600 block">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign In to Portal
                </button>
            </form>
            
        </div>
    </div>

    <!-- Right side: Visual / Brand Area -->
    <div class="hidden lg:flex w-1/2 bg-[#1e1b4b] relative overflow-hidden items-center justify-center">
        <!-- Abstract Decoration -->
        <div class="absolute inset-0 bg-linear-to-br from-indigo-900 to-[#1e1b4b] opacity-90"></div>
        
        <!-- Graphical overlapping elements to give the SaaS vibe -->
        <div class="absolute w-160 h-160 bg-indigo-600 rounded-full blur-3xl opacity-20 -top-20 -right-20 pointer-events-none"></div>
        <div class="absolute w-120 h-120 bg-pink-600 rounded-full blur-3xl opacity-10 bottom-10 -left-10 pointer-events-none"></div>

        <div class="relative z-10 text-center px-12 pt-20">
            <h1 class="text-5xl font-bold text-white mb-6 leading-tight">Next-Generation <br><span class="text-transparent bg-clip-text bg-linear-to-r from-indigo-400 to-pink-400">Payroll System</span></h1>
            <p class="text-indigo-200 text-lg max-w-lg mx-auto leading-relaxed">Automate timecards, calculate precise payslips, and manage your workforce effectively with our integrated modular tools.</p>
        </div>
    </div>

</body>
</html>