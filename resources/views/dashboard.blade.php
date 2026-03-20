@extends('layouts.app')

@section('title', 'Overview & Analytics')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between px-1">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight italic">Welcome back, <span class="text-indigo-600 underline decoration-indigo-200">Admin</span></h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Here is what's happening with your payroll system as of {{ now()->format('M d, Y') }}.</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <a href="{{ route('payrolls.index') }}" class="items-center justify-center inline-flex bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-0.5">
                Run Payroll
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Employees -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-500 group border-b-4 border-b-blue-500">
            <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Employees</p>
                <h3 class="text-3xl font-black text-slate-900 italic tracking-tighter">{{ number_format($totalEmployees) }}</h3>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-xl hover:shadow-emerald-50/50 transition-all duration-500 group border-b-4 border-b-emerald-500">
            <div class="h-14 w-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Attendance Today</p>
                <h3 class="text-3xl font-black text-slate-900 italic tracking-tighter">{{ number_format($todayTimecards) }}</h3>
            </div>
        </div>

        <!-- Total Monthly Payroll -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-xl hover:shadow-amber-50/50 transition-all duration-500 group border-b-4 border-b-amber-500">
            <div class="h-14 w-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Monthly Payroll</p>
                <h3 class="text-2xl font-black text-slate-900 italic tracking-tighter">₱ {{ number_format($totalPayrollMonth, 2) }}</h3>
            </div>
        </div>

        <!-- 13th Month Count -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-xl hover:shadow-purple-50/50 transition-all duration-500 group border-b-4 border-b-purple-500">
            <div class="h-14 w-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">13th Month Runs</p>
                <h3 class="text-3xl font-black text-slate-900 italic tracking-tighter">{{ number_format($thirteenthMonthPaid) }}</h3>
            </div>
        </div>
        
    </div>

    <!-- Content Area: Recent Activity & New Joinees -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        
        <!-- Recent Attendance Logs (Main Column) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
                    <h3 class="text-lg font-black text-slate-800 italic tracking-tight">Recent Attendance Activity</h3>
                    <a href="{{ route('timecards.index') }}" class="text-indigo-600 text-xs font-bold hover:underline">View All Records</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400">Employee</th>
                                <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400">Date/Time</th>
                                <th class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Hours</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 italic font-medium text-sm">
                            @forelse($recentTimecards as $rtc)
                            <tr class="hover:bg-indigo-50/30 transition duration-200">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $rtc->employee->full_name }}</div>
                                    <div class="text-[10px] text-indigo-500 uppercase font-black tracking-tighter">{{ $rtc->day_type }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-600">{{ \Carbon\Carbon::parse($rtc->date)->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($rtc->time_in)->format('h:i A') }} - {{ \Carbon\Carbon::parse($rtc->time_out)->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-slate-900 tracking-tighter">
                                    {{ number_format($rtc->total_hours, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic">No recent attendance found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6">
                <a href="{{ route('employees.index') }}" class="relative overflow-hidden p-6 rounded-3xl bg-indigo-600 text-white group transition-all duration-300 hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <span class="text-lg font-black italic block">Onboard Employee</span>
                        <span class="text-indigo-100 text-xs font-medium">Add new staff records to the system</span>
                    </div>
                </a>
                <a href="{{ route('timecards.index') }}" class="relative overflow-hidden p-6 rounded-3xl bg-slate-900 text-white group transition-all duration-300 hover:shadow-xl hover:shadow-slate-300 hover:-translate-y-1">
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-lg font-black italic block">Log Daily Time</span>
                        <span class="text-slate-400 text-xs font-medium">Update attendance or check OT hours</span>
                    </div>
                </a>
            </div>
        </div>
        <!-- Sidebar Column: Workforce & New Joinees -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-black text-slate-800 italic tracking-tight mb-5 underline decoration-indigo-100 decoration-4">Workforce Mix</h3>
                <div class="space-y-4">
                    @foreach($employmentTypes as $type)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $type->employment_type == 'Regular' ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest">{{ $type->employment_type }}</span>
                        </div>
                        <span class="text-lg font-black text-slate-900 italic tracking-tighter">{{ $type->total }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-black text-slate-800 italic tracking-tight mb-5 underline decoration-indigo-100 decoration-4">Newest Employees</h3>
                <div class="space-y-4">
                    @forelse($newEmployees as $ne)
                    <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black italic text-xs shadow-inner">
                            {{ substr($ne->full_name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-900 text-sm truncate">{{ $ne->full_name }}</h4>
                            <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest truncate">{{ $ne->designation }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-400 italic text-center py-4">No employees added yet.</p>
                    @endforelse
                </div>
                @if($newEmployees->count() >= 5)
                <a href="{{ route('employees.index') }}" class="block text-center mt-6 text-xs font-black text-indigo-500 hover:text-indigo-700 uppercase tracking-widest">Show All Directory</a>
                @endif
            </div>

            <div class="bg-indigo-50 rounded-3xl p-6 border border-indigo-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center animate-pulse">
                        <div class="w-2 h-2 rounded-full bg-white"></div>
                    </div>
                    <span class="text-sm font-black text-indigo-900 italic">System Health</span>
                </div>
                <p class="text-xs text-indigo-700 font-medium leading-relaxed">Everything is running smoothly. The payroll engine is synced and ready for the next run.</p>
            </div>
        </div>
    </div>

</div>
@endsection