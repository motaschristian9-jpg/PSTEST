@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Timecards & Attendance</h2>
            <p class="text-sm text-gray-500 mt-1">Review employee daily logs, night differentials, and calculate overtime.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openModal('addTimecardModal')" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-indigo-500/30 transition-all focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Log Attendance
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100/80">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Day Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Time In/Out</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Hours</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Pay & OT</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="timecardTableBody" class="divide-y divide-gray-100 text-sm">
                    @forelse($timecards as $tc)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <!-- Date -->
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($tc->date)->format('M d, Y') }}
                        </td>
                        
                        <!-- Employee -->
                        <td class="px-6 py-4">
                            <span class="font-medium text-indigo-700">{{ $tc->employee->full_name }}</span>
                            <div class="text-xs text-gray-400 mt-0.5">ID: #{{ str_pad($tc->employee_id, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        
                        <!-- Day Type -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $tc->day_type }}
                            </span>
                        </td>
                        
                        <!-- Time In/Out -->
                        <td class="px-6 py-4 text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <span class="text-emerald-600 font-medium">{{ \Carbon\Carbon::parse($tc->time_in)->format('h:i A') }}</span>
                                <span class="text-gray-400">&rarr;</span>
                                <span class="text-rose-600 font-medium">{{ \Carbon\Carbon::parse($tc->time_out)->format('h:i A') }}</span>
                            </div>
                            <div class="text-xs text-gray-400 mt-0.5">Break: {{ $tc->break_hours }} hrs</div>
                        </td>
                        
                        <!-- Hours -->
                        <td class="px-6 py-4 text-right">
                            <div class="font-medium text-gray-900">{{ number_format($tc->total_hours, 2) }} Regular</div>
                            @if($tc->ot_hours > 0)
                                <div class="text-xs text-amber-600 font-medium mt-0.5">+ {{ number_format($tc->ot_hours, 2) }} OT</div>
                            @endif
                        </td>
                        
                        <!-- Pay & OT -->
                        <td class="px-6 py-4 text-right">
                            <div class="font-bold text-gray-900">₱ {{ number_format($tc->overall_total, 2) }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">ND: ₱ {{ number_format($tc->night_diff_pay, 2) }} | OT Pay: ₱ {{ number_format($tc->ot_pay, 2) }}</div>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="editTimecard({{ $tc->id }})" class="text-indigo-500 hover:text-indigo-800 font-medium transition" title="Edit Timecard">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                
                                <form id="delete-timecard-{{ $tc->id }}" action="{{ route('timecards.destroy', $tc->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="confirmAction({
                                            title: 'Delete Timecard',
                                            message: 'Delete timecard entry for {{ $tc->date }}? This cannot be undone.',
                                            buttonText: 'Delete Now',
                                            onConfirm: () => document.getElementById('delete-timecard-{{ $tc->id }}').submit()
                                        })"
                                        class="text-red-400 hover:text-red-600 font-medium transition" 
                                        title="Delete Timecard">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="block font-medium">No timecards recorded.</span>
                            <span class="block text-sm mt-1">Start by logging employee attendance.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($timecards->hasPages())
            <div class="px-6 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $timecards->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

<!-- Include Add/Edit Modals -->
@include('timecards.modals.add_timecard')
@include('timecards.modals.edit_timecard')

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("{{ $errors->first() }}", "error");
        });
    </script>
@endif

</div>

<script>
function openModal(id) { 
    document.getElementById(id).classList.remove('hidden'); 
    document.getElementById(id).classList.add('flex'); 
}
function closeModal(id) { 
    document.getElementById(id).classList.add('hidden'); 
    document.getElementById(id).classList.remove('flex'); 
}

// Edit Timecard
function editTimecard(id) {
    fetch(`/timecards/${id}/edit`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('editTimecardId').value = data.id;
        document.getElementById('editEmployeeId').value = data.employee_id;
        document.getElementById('editDate').value = data.date;
        document.getElementById('editDayType').value = data.day_type;
        document.getElementById('editTimeIn').value = data.time_in ? data.time_in.substring(0, 5) : '';
        document.getElementById('editTimeOut').value = data.time_out ? data.time_out.substring(0, 5) : '';
        document.getElementById('editBreakHours').value = data.break_hours ?? 0;
        document.getElementById('editTimecardForm').action = `/timecards/${id}`;
        openModal('editTimecardModal');
    });
}
</script>
@endsection