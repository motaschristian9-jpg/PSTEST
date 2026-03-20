@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Timecards & Attendance</h2>
            <p class="text-sm text-gray-500 mt-1">Review employee daily logs, night differentials, and calculate overtime.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Delete Selected Button -->
            <button id="bulkDeleteBtn" onclick="confirmBulkDelete()" class="hidden inline-flex items-center justify-center gap-2 bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-semibold py-2.5 px-5 rounded-lg border border-rose-100 transition-all focus:outline-none whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            <button onclick="openModal('addTimecardModal')" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-indigo-500/30 transition-all focus:ring-2 focus:ring-indigo-500 focus:outline-none whitespace-nowrap">
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
                        <th class="px-6 py-4 w-10">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Day Type</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Time In/Out</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Hours</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Pay & OT</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="timecardTableBody" class="divide-y divide-gray-100 text-sm italic font-medium">
                    @forelse($timecards as $tc)
                    <tr class="hover:bg-slate-50/50 transition duration-150 group">
                        <!-- Bulk Selection -->
                        <td class="px-6 py-4">
                            <input type="checkbox" name="ids[]" value="{{ $tc->id }}" class="row-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                        </td>
                        <!-- Date -->
                        <td class="px-6 py-4 font-bold text-gray-900 border-l-2 border-indigo-500 pl-3 italic">
                            {{ \Carbon\Carbon::parse($tc->date)->format('M d, Y') }}
                        </td>
                        
                        <!-- Employee -->
                        <td class="px-6 py-4 font-bold text-gray-900">
                            {{ $tc->employee->full_name }}
                        </td>
                        
                        <!-- Day Type -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ in_array($tc->day_type, ['Rest Day', 'Holiday']) ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-slate-50 text-slate-600 border border-slate-100' }}">
                                {{ $tc->day_type }}
                            </span>
                        </td>
                        
                        <!-- Times -->
                        <td class="px-6 py-4 text-gray-600 tabular-nums">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold tracking-tighter">{{ \Carbon\Carbon::parse($tc->time_in)->format('h:i A') }}</span>
                                <span class="text-gray-300">→</span>
                                <span class="text-rose-500 font-bold tracking-tighter">{{ \Carbon\Carbon::parse($tc->time_out)->format('h:i A') }}</span>
                            </div>
                        </td>
                        
                        <!-- Hours -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-gray-900 font-black italic tracking-tight">{{ number_format($tc->total_hours, 2) }} hrs</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Total Work</div>
                        </td>
                        
                        <!-- Pay & OT -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-emerald-600 font-black tabular-nums tracking-tighter">₱ {{ number_format($tc->total_pay, 2) }}</div>
                            @if($tc->overtime_pay > 0)
                                <div class="text-[10px] text-rose-500 font-black uppercase tracking-widest">+ OT ₱ {{ number_format($tc->overtime_pay, 2) }}</div>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="editTimecard({{ $tc->id }})" class="text-indigo-500 hover:text-indigo-800 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('timecards.destroy', $tc->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-600 transition-colors" title="Delete" onclick="return confirm('Are you sure you want to delete this entry?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 italic text-sm">
                            No timecard records found for the selection.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($timecards->hasPages())
        <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-100">
            {{ $timecards->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>

    <!-- Hidden Bulk Delete Form -->
    <form id="bulkDeleteForm" action="{{ route('timecards.bulkDelete') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCount = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');

            function updateBulkDeleteUI() {
                const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                if (selectedCount) selectedCount.textContent = checkedCount;
                
                if (bulkDeleteBtn) {
                    if (checkedCount > 0) {
                        bulkDeleteBtn.classList.remove('hidden');
                        bulkDeleteBtn.classList.add('inline-flex');
                    } else {
                        bulkDeleteBtn.classList.add('hidden');
                        bulkDeleteBtn.classList.remove('inline-flex');
                    }
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.row-checkbox').forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                    updateBulkDeleteUI();
                });
            }

            document.querySelector('table').addEventListener('change', function(e) {
                if (e.target.classList.contains('row-checkbox')) {
                    if (selectAll) {
                        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
                        const allChecked = Array.from(rowCheckboxes).every(c => c.checked);
                        selectAll.checked = allChecked;
                    }
                    updateBulkDeleteUI();
                }
            });

            window.confirmBulkDelete = function() {
                const checkedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
                
                if (typeof confirmAction === 'function') {
                    confirmAction({
                        title: 'Bulk Delete Timecards',
                        message: `Are you sure you want to delete ${checkedIds.length} selected timecard entries? This action is permanent.`,
                        buttonText: 'Delete Selected',
                        onConfirm: () => {
                            checkedIds.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkDeleteForm.appendChild(input);
                            });
                            bulkDeleteForm.submit();
                        }
                    });
                } else if (confirm(`Are you sure you want to delete ${checkedIds.length} records?`)) {
                    checkedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        bulkDeleteForm.appendChild(input);
                    });
                    bulkDeleteForm.submit();
                }
            };
        });

        // Modal Logic remains outside listener for general access
        function openModal(id) { 
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden'); 
                el.classList.add('flex');
            }
        }
        function closeModal(id) { 
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('hidden'); 
                el.classList.remove('flex');
            }
        }

        // Edit Timecard AJAX
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