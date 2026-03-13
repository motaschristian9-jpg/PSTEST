@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">13th Month Pay Records</h2>
            <p class="text-sm text-gray-500 mt-1">Review eligible employees and generate annual bonus payouts.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button type="button" onclick="openModal('thirteenthMonthModal')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-emerald-500/30 transition-all focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Generate 13th Month Pay
            </button>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-auto">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Year</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="number" name="year" value="{{ $year ?? now()->year }}" class="pl-9 w-full md:w-32 border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
            </div>
            
            <div class="w-full md:w-auto">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Employment Type</label>
                <select name="employment_type" class="w-full md:w-48 border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                    <option value="">All Types</option>
                    <option value="Regular" @if($employmentType == 'Regular') selected @endif>Regular</option>
                    <option value="Non-Regular" @if($employmentType == 'Non-Regular') selected @endif>Non-Regular</option>
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pay Schedule</label>
                <select name="pay_schedule" class="w-full md:w-48 border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                    <option value="">All Schedules</option>
                    <option value="Weekly" @if($paySchedule == 'Weekly') selected @endif>Weekly</option>
                    <option value="15/30" @if($paySchedule == '15/30') selected @endif>15/30</option>
                    <option value="10/25" @if($paySchedule == '10/25') selected @endif>10/25</option>
                </select>
            </div>
            
            <div class="w-full md:w-auto mt-4 md:mt-0">
                <button type="submit" class="w-full md:w-auto px-6 py-2 rounded-xl bg-slate-900 border border-transparent text-white text-sm font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition-all">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100/80">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-16 text-center">
                           <span class="sr-only">Select</span>
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee Name</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <!-- Checkbox -->
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" class="employeeCheckbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer" value="{{ $emp->id }}">
                            </td>
                            <!-- ID -->
                            <td class="px-6 py-4 text-gray-500 font-medium whitespace-nowrap">
                                #{{ str_pad($emp->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $emp->full_name }}</div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="block font-medium">No employees found.</span>
                            <span class="block text-sm mt-1">Adjust your filters to see results.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    @include('thirteenth_month.modals.thirteenthMonth')
@endsection