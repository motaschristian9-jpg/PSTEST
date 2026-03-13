@extends('layouts.app')

@section('content')

<div class="max-w-screen-2xl mx-auto">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Payroll Processing</h2>
            <p class="text-sm text-gray-500 mt-1">Generate payroll calculations, review deductions, and print payslips.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openModal('payslipModal')" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-emerald-500/30 transition-all focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Payslips
            </button>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" class="flex flex-col lg:flex-row gap-4 lg:items-end">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 flex-1">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Employment Type</label>
                    <select name="employment_type" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="">All Types</option>
                        <option value="Regular" @if($employmentType == 'Regular') selected @endif>Regular</option>
                        <option value="Non-Regular" @if($employmentType == 'Non-Regular') selected @endif>Non-Regular</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pay Schedule</label>
                    <select name="pay_schedule" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="">All Schedules</option>
                        <option value="Weekly" @if($paySchedule == 'Weekly') selected @endif>Weekly</option>
                        <option value="15/30" @if($paySchedule == '15/30') selected @endif>15/30</option>
                        <option value="10/25" @if($paySchedule == '10/25') selected @endif>10/25</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 lg:mt-0">
                <button type="submit" class="w-full lg:w-auto px-6 py-2.5 rounded-xl bg-indigo-600 border border-transparent text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm shadow-indigo-500/30 whitespace-nowrap">
                    Generate Payroll
                </button>
            </div>
            
        </form>
    </div>

    <!-- Data Table Card (Wide Scrollable) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100/80">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center sticky left-0 bg-gray-50/95 backdrop-blur-sm z-10 w-12">
                            <span class="sr-only">Select</span>
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider sticky left-12 bg-gray-50/95 backdrop-blur-sm z-10 shadow-[inset_-1px_0_0_rgba(243,244,246,1)]">
                            Employee
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Basic Rate</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-amber-600">Total OT</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-indigo-600">Night Diff</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right bg-indigo-50/50">Gross Pay</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-rose-600">SSS</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-rose-600">PhilHealth</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-rose-600">HDMF</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-right text-rose-600">Other Ded.</th>
                        <th class="px-4 py-3 text-xs font-semibold text-rose-700 uppercase tracking-wider text-right bg-rose-50/50">Total Deductions</th>
                        <th class="px-6 py-3 text-xs font-bold text-emerald-700 uppercase tracking-wider text-right bg-emerald-50/50">Net Pay</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($payrolls as $p)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <!-- Checkbox -->
                            <td class="px-4 py-3 text-center sticky left-0 bg-white group-hover:bg-slate-50/50 transition duration-150 z-10 w-12 border-b border-gray-100">
                                <input type="checkbox" class="employeeCheckbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer" value="{{ $p['employee']->id }}">
                            </td>
                            <!-- Employee Info -->
                            <td class="px-4 py-3 sticky left-12 bg-white group-hover:bg-slate-50/50 transition duration-150 z-10 shadow-[inset_-1px_0_0_rgba(243,244,246,1)] border-b border-gray-100">
                                <div class="font-bold text-gray-900">{{ $p['employee']->full_name }}</div>
                                <div class="text-xs text-gray-400">ID: #{{ str_pad($p['employee']->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <!-- Period -->
                            <td class="px-4 py-3 text-gray-500 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($start)->format('M d') }} - {{ \Carbon\Carbon::parse($end)->format('M d') }}
                            </td>
                            <!-- Rates & Additionals -->
                            <td class="px-4 py-3 text-right font-medium text-gray-700">{{ number_format($p['employee']->basic_rate, 2) }}</td>
                            <td class="px-4 py-3 text-right font-medium text-amber-600">{{ number_format($p['ot_pay'], 2) }}</td>
                            <td class="px-4 py-3 text-right font-medium text-indigo-600">{{ number_format($p['night_diff_pay'], 2) }}</td>
                            <!-- Gross Pay -->
                            <td class="px-4 py-3 text-right font-bold text-gray-900 bg-indigo-50/30">{{ number_format($p['gross_pay'], 2) }}</td>
                            <!-- Deductions -->
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($p['employee']->sss_amount ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($p['employee']->philhealth_amount ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($p['employee']->hdmf_amount ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-right text-gray-600">{{ number_format($p['employee']->other_deductions ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-right font-bold text-rose-600 bg-rose-50/30">{{ number_format($p['total_deductions'], 2) }}</td>
                            <!-- Net Pay -->
                            <td class="px-6 py-3 text-right text-base font-extrabold text-emerald-600 bg-emerald-50/30">
                                ₱ {{ number_format($p['net_pay'], 2) }}
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="block font-medium">No payroll data found.</span>
                            <span class="block text-sm mt-1">Please adjust your date range or filters.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

    <!-- Include Separated Modal -->

    @include('payroll.modals.payslip')

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast("{{ $errors->first() }}", "error");
            });
        </script>
    @endif

    <script>

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        function printBulk() {
            let qs = window.location.search;
            window.open("/payroll/print-bulk" + qs, "_blank");
        }

        function printSelected() {
            let ids = [];
            document.querySelectorAll('.employeeCheckbox:checked').forEach(cb => ids.push(cb.value));

            if (ids.length === 0) {
                showToast("Please select at least one employee", "error");
                return;
            }

            let params = new URLSearchParams(window.location.search);
            params.set('ids', ids.join(','));
            window.open("/payroll/print-selected?" + params.toString(), "_blank");
        }

    </script>

@endsection