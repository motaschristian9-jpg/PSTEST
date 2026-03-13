<div id="editTimecardModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto relative">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-900">Edit Timecard</h2>
            <button type="button" onclick="closeModal('editTimecardModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="editTimecardForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="editTimecardId">

            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <select id="editEmployeeId" name="employee_id" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer shadow-sm" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">#{{ $emp->id }} — {{ $emp->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="editDate" name="date" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm cursor-pointer" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Day Type</label>
                    <select id="editDayType" name="day_type" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer shadow-sm" required>
                        <option value="Regular">Regular</option>
                        <option value="Holiday">Holiday</option>
                        <option value="Special Non-Working Day">Special Non-Working Day</option>
                        <option value="Special Working Day">Special Working Day</option>
                        <option value="Rest Day">Rest Day</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-100 py-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Time In</label>
                        <input type="time" id="editTimeIn" name="time_in" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Time Out</label>
                        <input type="time" id="editTimeOut" name="time_out" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm cursor-pointer">
                    </div>
                </div>

                <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100/50">
                    <label class="block text-sm font-medium text-indigo-900 mb-1">Break Hours</label>
                    <div class="relative">
                        <input type="number" step="0.01" id="editBreakHours" name="break_hours" class="w-full border border-indigo-200 bg-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" value="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-xs text-indigo-400 font-medium">hrs</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3 rounded-b-2xl sticky bottom-0 z-10">
                <button type="button" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" onclick="closeModal('editTimecardModal')">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">Update Timecard</button>
            </div>
        </form>
    </div>
</div>