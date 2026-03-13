<div id="addEmployeeModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto overflow-x-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-900">Add New Employee</h2>
            <button type="button" onclick="closeModal('addEmployeeModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                
                <!-- Basic Info Section -->
                <div>
                    <h3 class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="full_name" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                            <select name="employment_type" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                                <option value="Regular">Regular</option>
                                <option value="Non-Regular">Non-Regular</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                            <input type="text" name="designation" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" required>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Compensation & Schedule -->
                <div>
                    <h3 class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-4">Compensation & Schedule</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Basic Rate</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" step="0.01" name="basic_rate" class="pl-7 w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pay Schedule</label>
                            <select name="pay_schedule" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                                <option value="Weekly">Weekly</option>
                                <option value="15/30">15/30</option>
                                <option value="10/25">10/25</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Deductions -->
                <div>
                    <h3 class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-4">Government & Other Deductions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- SSS -->
                        <div class="space-y-3 p-4 border border-gray-100 rounded-xl bg-slate-50/50">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">SSS Number</label>
                                <input type="text" name="sss_number" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">SSS Amount</label>
                                <input type="number" step="0.01" name="sss_amount" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- HDMF -->
                        <div class="space-y-3 p-4 border border-gray-100 rounded-xl bg-slate-50/50">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">HDMF Number</label>
                                <input type="text" name="hdmf_number" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">HDMF Amount</label>
                                <input type="number" step="0.01" name="hdmf_amount" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- PhilHealth -->
                        <div class="space-y-3 p-4 border border-gray-100 rounded-xl bg-slate-50/50">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">PhilHealth Number</label>
                                <input type="text" name="philhealth_number" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">PhilHealth Amount</label>
                                <input type="number" step="0.01" name="philhealth_amount" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="space-y-3 p-4 border border-gray-100 rounded-xl bg-slate-50/50">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Other Deductions (Amount)</label>
                                <input type="number" step="0.01" name="other_deductions" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3 rounded-b-2xl sticky bottom-0 z-10">
                <button type="button" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" onclick="closeModal('addEmployeeModal')">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">Save Employee</button>
            </div>
            
        </form>
    </div>
</div>