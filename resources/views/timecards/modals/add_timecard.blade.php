<!-- resources/views/timecard/modals/add_timecard.blade.php -->
<div id="addTimecardModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto relative">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold text-gray-900">Add Timecard</h2>
            <button type="button" onclick="closeModal('addTimecardModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="addTimecardForm" action="{{ route('timecards.store') }}" method="POST">
            @csrf
 
            <div class="p-6 space-y-5">
                <!-- Searchable Employee Input -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="employeeSearch" placeholder="Search ID or Name" class="pl-9 w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm" autocomplete="off" required>
                    </div>
                    <input type="hidden" name="employee_id" id="employeeId">
                    <ul id="employeeList" class="border border-gray-200 mt-1 rounded-xl bg-white shadow-lg max-h-40 overflow-y-auto hidden absolute z-50 w-full divide-y divide-gray-100 text-sm"></ul>
                </div>
 
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm cursor-pointer" value="{{ date('Y-m-d') }}" required>
                </div>
 
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Day Type</label>
                    <select name="day_type" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer shadow-sm" required>
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
                        <input type="time" name="time_in" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Time Out</label>
                        <input type="time" name="time_out" class="w-full border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm cursor-pointer">
                    </div>
                </div>
 
                <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100/50">
                    <label class="block text-sm font-medium text-indigo-900 mb-1">Break Hours</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="break_hours" class="w-full border border-indigo-200 bg-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" value="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-xs text-indigo-400 font-medium">hrs</span>
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3 rounded-b-2xl sticky bottom-0 z-10">
                <button type="button" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" onclick="closeModal('addTimecardModal')">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">Save Timecard</button>
            </div>
        </form>
    </div>
 
    <!-- JavaScript for Searchable Employee -->
    <script>
        const employees = @json($employees); // Laravel passes the employees array
        const searchInput = document.getElementById('employeeSearch');
        const employeeIdInput = document.getElementById('employeeId');
        const list = document.getElementById('employeeList');
        const addTimecardForm = document.getElementById('addTimecardForm');
 
        // Handle Form Submission via AJAX
        addTimecardForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (response.ok) {
                    showToast(data.message, "success");
                    // Clear only employee related fields to allow adding more entries for same date/type
                    searchInput.value = '';
                    employeeIdInput.value = '';
                    searchInput.focus();
                } else {
                    const errorMsg = data.message || "Failed to save timecard.";
                    showToast(errorMsg, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast("An unexpected error occurred.", "error");
            });
        });
 
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            list.innerHTML = '';
 
            if(query.length === 0) {
                list.classList.add('hidden');
                employeeIdInput.value = '';
                return;
            }
 
            const matches = employees.filter(emp => 
                emp.full_name.toLowerCase().includes(query) || emp.id.toString().includes(query)
            );
 
            if(matches.length === 0){
                list.classList.add('hidden');
                employeeIdInput.value = '';
                return;
            }
 
            matches.forEach(emp => {
                const li = document.createElement('li');
                li.classList.add('px-4','py-3','hover:bg-slate-50','cursor-pointer', 'text-gray-700', 'font-medium');
                li.innerHTML = `<span class="text-indigo-600 text-xs bg-indigo-50 px-2 py-0.5 rounded-md mr-2">#${emp.id}</span> ${emp.full_name}`;
                li.addEventListener('click', () => {
                    searchInput.value = emp.full_name + ' (' + emp.id + ')';
                    employeeIdInput.value = emp.id;
                    list.classList.add('hidden');
                });
                list.appendChild(li);
            });
 
            list.classList.remove('hidden');
        });
 
        document.addEventListener('click', function(e) {
            if(!searchInput.contains(e.target) && !list.contains(e.target)){
                list.classList.add('hidden');
            }
        });
    </script>
</div>