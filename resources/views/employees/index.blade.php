@extends('layouts.app')

@section('content')
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Employee Directory</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your workforce, update details, and review compensation rates.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <!-- Search & Bulk Delete Group -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- Search Bar -->
                    <form action="{{ route('employees.index') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative w-full sm:w-64">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name or ID..."
                                class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('employees.index') }}"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-lg shadow-sm transition-all focus:outline-none">
                            Search
                        </button>
                    </form>

                    <!-- Delete Selected Button -->
                    <button id="bulkDeleteBtn" onclick="confirmBulkDelete()"
                        class="hidden items-center justify-center gap-2 bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-semibold py-2.5 px-5 rounded-lg border border-rose-100 transition-all focus:outline-none whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Delete Selected (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <button onclick="openModal('addEmployeeModal')"
                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-indigo-500/30 transition-all focus:ring-2 focus:ring-indigo-500 focus:outline-none whitespace-nowrap ml-auto sm:ml-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Employee
                </button>
            </div>
        </div>

        <!-- Messages -->

        <!-- Data Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100/80">
                        <tr>
                            <th class="px-6 py-4 w-10">
                                <input type="checkbox" id="selectAll"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider lg:table-cell hidden">
                                Type & Role</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Basic Rate</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider lg:table-cell hidden">
                                Allowances</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider lg:table-cell hidden">
                                Gov Deductions</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Other Deductions</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm italic font-medium">
                        @forelse($employees as $emp)
                            <tr class="hover:bg-slate-50/50 transition duration-150 group">
                                <!-- Bulk Selection -->
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="ids[]" value="{{ $emp->id }}"
                                        class="row-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                                </td>
                                <!-- ID -->
                                <td class="px-6 py-4 text-gray-500 font-bold italic tracking-tighter">
                                    #{{ str_pad($emp->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- Name & Schedule -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 border-l-2 border-indigo-500 pl-3">{{ $emp->full_name }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 pl-3 uppercase tracking-widest font-black">Pay:
                                        <span class="text-indigo-600">{{ $emp->pay_schedule }}</span></div>
                                </td>

                                <!-- Type & Designation -->
                                <td class="px-6 py-4 lg:table-cell hidden">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $emp->employment_type == 'Regular' ? 'bg-emerald-50 text-emerald-800 border border-emerald-100' : 'bg-amber-50 text-amber-800 border border-amber-100' }}">
                                        {{ $emp->employment_type }}
                                    </span>
                                    <div class="text-gray-500 mt-1 italic text-xs">{{ $emp->designation }}</div>
                                </td>

                                <!-- Basic Rate -->
                                <td class="px-6 py-4 text-right font-black text-slate-900 italic tracking-tight">
                                    ₱ {{ number_format($emp->basic_rate, 2) }}
                                </td>

                                <!-- Allowances (Condensed) -->
                                <td class="px-6 py-4 lg:table-cell hidden text-gray-400 text-[10px] space-y-1">
                                    <div class="flex justify-between border-b border-slate-50"><span>Allow:</span> <span
                                            class="font-bold text-slate-600">₱
                                            {{ number_format($emp->allowance ?? 0, 2) }}</span></div>
                                    <div class="flex justify-between border-b border-slate-50"><span>Accom:</span> <span
                                            class="font-bold text-slate-600">₱
                                            {{ number_format($emp->accommodation ?? 0, 2) }}</span></div>
                                    <div class="flex justify-between border-b border-slate-50"><span>Load:</span> <span
                                            class="font-bold text-slate-600">₱
                                            {{ number_format($emp->load_allowance ?? 0, 2) }}</span></div>
                                    <div class="flex justify-between border-b border-slate-50"><span>Travel:</span> <span
                                            class="font-bold text-slate-600">₱
                                            {{ number_format($emp->travel_allowance ?? 0, 2) }}</span></div>
                                </td>

                                <!-- Gov Deductions (Condensed) -->
                                <td class="px-6 py-4 lg:table-cell hidden text-gray-400 text-[10px] space-y-1">
                                    <div class="flex justify-between"><span>SSS:</span> <span
                                            class="font-bold text-slate-600 italic">₱
                                            {{ number_format($emp->sss_amount ?? 0, 2) }}</span></div>
                                    <div class="flex justify-between"><span>PHealth:</span> <span
                                            class="font-bold text-slate-600 italic">₱
                                            {{ number_format($emp->philhealth_amount ?? 0, 2) }}</span></div>
                                    <div class="flex justify-between"><span>HDMF:</span> <span
                                            class="font-bold text-slate-600 italic">₱
                                            {{ number_format($emp->hdmf_amount ?? 0, 2) }}</span></div>
                                </td>

                                <!-- Other Deductions -->
                                <td class="px-6 py-4 text-right font-black text-rose-600 italic tracking-tight">
                                    ₱ {{ number_format($emp->other_deductions ?? 0, 2) }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button onclick="editEmployee({{ $emp->id }})"
                                            class="text-indigo-500 hover:text-indigo-800 font-medium transition"
                                            title="Edit Employee">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="delete-employee-{{ $emp->id }}"
                                            action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmAction({
                                                    title: 'Delete Employee',
                                                    message: 'Are you sure you want to delete {{ $emp->full_name }}? This action is permanent.',
                                                    buttonText: 'Delete Now',
                                                    onConfirm: () => document.getElementById('delete-employee-{{ $emp->id }}').submit()
                                                })" class="text-red-400 hover:text-red-600 font-medium transition"
                                                title="Delete Employee">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500 italic">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="block font-medium">No employees found matching your criteria.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($employees->hasPages())
                <div class="px-6 py-4 bg-slate-50/30 border-t border-gray-100">
                    {{ $employees->appends(['search' => request('search')])->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>

        <!-- Hidden Bulk Delete Form -->
        <form id="bulkDeleteForm" action="{{ route('employees.bulkDelete') }}" method="POST" class="hidden">
            @csrf
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                const selectedCount = document.getElementById('selectedCount');
                const bulkDeleteForm = document.getElementById('bulkDeleteForm');

                function updateBulkDeleteUI() {
                    const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                    selectedCount.textContent = checkedCount;

                    if (checkedCount > 0) {
                        bulkDeleteBtn.classList.remove('hidden');
                        bulkDeleteBtn.classList.add('inline-flex');
                    } else {
                        bulkDeleteBtn.classList.add('hidden');
                        bulkDeleteBtn.classList.remove('inline-flex');
                    }
                }

                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        document.querySelectorAll('.row-checkbox').forEach(cb => {
                            cb.checked = selectAll.checked;
                        });
                        updateBulkDeleteUI();
                    });

                    // Attach change listener directly to table for delegation or re-bind to checkboxes
                    document.querySelector('table').addEventListener('change', function (e) {
                        if (e.target.classList.contains('row-checkbox')) {
                            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
                            const allChecked = Array.from(rowCheckboxes).every(c => c.checked);
                            selectAll.checked = allChecked;
                            updateBulkDeleteUI();
                        }
                    });
                }

                window.confirmBulkDelete = function () {
                    const checkedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);

                    confirmAction({
                        title: 'Bulk Delete Employees',
                        message: `Are you sure you want to delete ${checkedIds.length} selected employees? This action is permanent.`,
                        buttonText: 'Delete Selected',
                        onConfirm: () => {
                            // Inject IDs into the form
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
                };
            });
        </script>

        <!-- Modals -->
        @include('employees.modals.add_employee')
        @include('employees.modals.edit_employee')

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

        // Fetch employee data for edit modal
        function editEmployee(id) {
            fetch(`/employees/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editEmployeeId').value = data.id;
                    document.getElementById('editFullName').value = data.full_name;
                    document.getElementById('editEmploymentType').value = data.employment_type;
                    document.getElementById('editDesignation').value = data.designation;
                    document.getElementById('editBasicRate').value = data.basic_rate;
                    document.getElementById('editSssNumber').value = data.sss_number ?? '';
                    document.getElementById('editSssAmount').value = data.sss_amount ?? 0;
                    document.getElementById('editHdmfNumber').value = data.hdmf_number ?? '';
                    document.getElementById('editHdmfAmount').value = data.hdmf_amount ?? 0;
                    document.getElementById('editPhilhealthNumber').value = data.philhealth_number ?? '';
                    document.getElementById('editPhilhealthAmount').value = data.philhealth_amount ?? 0;
                    document.getElementById('editOtherDeductions').value = data.other_deductions ?? 0;
                    document.getElementById('editPaySchedule').value = data.pay_schedule;
                    document.getElementById('editAllowance').value = data.allowance ?? 0;
                    document.getElementById('editAccommodation').value = data.accommodation ?? 0;
                    document.getElementById('editLoadAllowance').value = data.load_allowance ?? 0;
                    document.getElementById('editTravelAllowance').value = data.travel_allowance ?? 0;

                    document.getElementById('editEmployeeForm').action = `/employees/${id}`;
                    openModal('editEmployeeModal');
                });
        }
    </script>
@endsection