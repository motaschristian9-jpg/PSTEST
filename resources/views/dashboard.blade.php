@extends('layouts.app')

@section('title', 'Overview & Analytics')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Welcome back, Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Here is what's happening with your payroll today.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('payrolls.index') }}" class="items-center justify-center inline-flex bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-200">
                Run Payroll
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="h-12 w-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Employees</p>
                <h3 class="text-2xl font-bold text-gray-900">Manage</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="h-12 w-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Active Timecards</p>
                <h3 class="text-2xl font-bold text-gray-900">Review</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="h-12 w-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Last Payroll Run</p>
                <h3 class="text-2xl font-bold text-gray-900">Calculated</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="h-12 w-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Next 13th Month</p>
                <h3 class="text-2xl font-bold text-gray-900">Pending</h3>
            </div>
        </div>
        
    </div>

    <!-- Content Split Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Main Panel -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('employees.index') }}" class="p-4 rounded-xl border border-gray-100 hover:bg-slate-50 transition group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <span class="font-medium text-gray-900">Add New Employee</span>
                    <span class="text-xs text-gray-500 mt-1">Onboard staff to the system</span>
                </a>
                <a href="{{ route('timecards.index') }}" class="p-4 rounded-xl border border-gray-100 hover:bg-slate-50 transition group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-medium text-gray-900">Input Timecards</span>
                    <span class="text-xs text-gray-500 mt-1">Log attendance & OT hours</span>
                </a>
            </div>
        </div>
        
        <!-- Side Panel -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-4">System Status</h3>
            <div class="flex-1 flex flex-col justify-center items-center text-center space-y-3">
                 <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center">
                     <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                 </div>
                 <h4 class="font-bold text-gray-800">All Systems Operational</h4>
                 <p class="text-sm text-gray-500">Payroll engine is ready to process batches.</p>
            </div>
        </div>
    </div>

</div>
@endsection