<!-- Sidebar Overlay (Mobile Only) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity duration-300 opacity-0" onclick="toggleSidebar()"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1e1b4b] text-white flex flex-col border-r border-[#2e2b5e] transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out shrink-0 h-screen">
    
    <!-- Logo Area -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-indigo-900/50 bg-[#1e1b4b] shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img class="h-11 w-auto object-contain" src="{{ asset('images/Picture1.png') }}" alt="Logo">
            <div class="flex flex-col leading-tight">
                <span class="font-bold text-sm tracking-tight text-white uppercase">DCJ's Construction</span>
                <span class="text-[10px] text-indigo-300 font-medium uppercase tracking-[0.15em]">Services</span>
            </div>
        </a>
        <!-- Mobile Close Button -->
        <button onclick="toggleSidebar()" class="lg:hidden text-indigo-300 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    @auth
    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">Management</p>
        </div>

        <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('employees.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('employees.*') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium">Employees</span>
        </a>

        <a href="{{ route('timecards.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('timecards.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('timecards.*') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">Timecards</span>
        </a>

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">Finance</p>
        </div>

        <a href="{{ route('payrolls.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('payrolls.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('payrolls.*') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
            <span class="font-medium">Payroll Data</span>
        </a>

        <a href="{{ route('thirteenth_month.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('thirteenth_month.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-indigo-200 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('thirteenth_month.*') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">13th Month</span>
        </a>

    </nav>
    
    <!-- Embedded minimal logout replaced inside of app.blade.php so handled natively above but keeping bottom info area here -->
    <div class="px-6 py-4 border-t border-indigo-900/50 text-xs text-indigo-400">
        System Core v1.2
    </div>
    @endauth
</aside>