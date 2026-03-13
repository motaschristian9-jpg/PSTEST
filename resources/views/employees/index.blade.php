@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Employee Directory</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your workforce, update details, and review compensation rates.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openModal('addEmployeeModal')" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 px-5 rounded-lg shadow-sm shadow-indigo-500/30 transition-all focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Employee
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100/80">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type & Role</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Basic Rate</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider lg:table-cell hidden">Gov Deductions</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Other Deductions</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <!-- ID -->
                        <td class="px-6 py-4 text-gray-500 font-medium">#{{ str_pad($emp->id, 4, '0', STR_PAD_LEFT) }}</td>
                        
                        <!-- Name & Schedule -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $emp->full_name }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">Pay Schedule: <span class="text-indigo-600 font-medium">{{ $emp->pay_schedule }}</span></div>
                        </td>
                        
                        <!-- Type & Designation -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $emp->employment_type == 'Regular' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $emp->employment_type }}
                            </span>
                            <div class="text-gray-500 mt-1">{{ $emp->designation }}</div>
                        </td>
                        
                        <!-- Basic Rate -->
                        <td class="px-6 py-4 text-right font-medium text-gray-900">
                            ₱ {{ number_format($emp->basic_rate, 2) }}
                        </td>
                        
                        <!-- Gov Deductions (Condensed) -->
                        <td class="px-6 py-4 lg:table-cell hidden text-gray-500 text-xs space-y-1">
                            <div><span class="font-medium">SSS:</span> ₱ {{ number_format($emp->sss_amount ?? 0, 2) }}</div>
                            <div><span class="font-medium">PHealth:</span> ₱ {{ number_format($emp->philhealth_amount ?? 0, 2) }}</div>
                            <div><span class="font-medium">HDMF:</span> ₱ {{ number_format($emp->hdmf_amount ?? 0, 2) }}</div>
                        </td>
                        
                        <!-- Other Deductions -->
                        <td class="px-6 py-4 text-right font-medium text-gray-900">
                            ₱ {{ number_format($emp->other_deductions ?? 0, 2) }}
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="editEmployee({{ $emp->id }})" class="text-indigo-500 hover:text-indigo-800 font-medium transition" title="Edit Employee">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                
                                <form id="delete-employee-{{ $emp->id }}" action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="confirmAction({
                                            title: 'Delete Employee',
                                            message: 'Are you sure you want to delete {{ $emp->full_name }}? This action is permanent.',
                                            buttonText: 'Delete Now',
                                            onConfirm: () => document.getElementById('delete-employee-{{ $emp->id }}').submit()
                                        })"
                                        class="text-red-400 hover:text-red-600 font-medium transition" 
                                        title="Delete Employee">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="block font-medium">No employees found.</span>
                            <span class="block text-sm mt-1">Start by adding a new employee to the system.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Modals -->
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

                document.getElementById('editEmployeeForm').action = `/employees/${id}`;
                openModal('editEmployeeModal');
            });
    }
</script>
@endsection