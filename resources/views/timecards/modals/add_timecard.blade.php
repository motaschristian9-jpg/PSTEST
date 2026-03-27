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
                    
                    // Dynamically add the new row to the table
                    const tbody = document.getElementById('timecardTableBody');
                    if (tbody) {
                        // Remove "No records" row if it exists
                        const emptyRow = tbody.querySelector('tr td[colspan="8"]')?.closest('tr');
                        if (emptyRow) emptyRow.remove();

                        const tc = data.data;
                        const date = new Date(tc.date).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
                        const employeeId = tc.employee_id.toString().padStart(4, '0');
                        
                        function formatTime(timeStr) {
                            if (!timeStr) return '';
                            const [h, m] = timeStr.split(':');
                            const hh = parseInt(h);
                            const suffix = hh >= 12 ? 'PM' : 'AM';
                            const hours = hh % 12 || 12;
                            return `${hours}:${m} ${suffix}`;
                        }

                        const timeIn = formatTime(tc.time_in);
                        const timeOut = formatTime(tc.time_out);
                        
                        const newRow = document.createElement('tr');
                        newRow.className = 'hover:bg-slate-50/50 transition duration-150 animate-pulse bg-indigo-50/30';
                        newRow.innerHTML = `
                            <td class="px-6 py-4">
                                <input type="checkbox" name="ids[]" value="${tc.id}" class="row-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 border-l-2 border-indigo-500 pl-3 italic">
                                ${date}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                ${tc.employee.full_name}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider ${['Rest Day', 'Holiday'].includes(tc.day_type) ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-slate-50 text-slate-600 border border-slate-100'}">
                                    ${tc.day_type}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 tabular-nums">
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-600 font-bold tracking-tighter">${timeIn}</span>
                                    <span class="text-gray-300">→</span>
                                    <span class="text-rose-500 font-bold tracking-tighter">${timeOut}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="text-gray-900 font-black italic tracking-tight">${Number(tc.total_hours).toFixed(2)} hrs</div>
                                <div class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Total Work</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="text-emerald-600 font-black tabular-nums tracking-tighter">₱ ${Number(tc.overall_total).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                                ${tc.ot_pay > 0 ? `<div class="text-[10px] text-rose-500 font-black uppercase tracking-widest">+ OT ₱ ${Number(tc.ot_pay).toFixed(2)}</div>` : ''}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <button onclick="editTimecard(${tc.id})" class="text-indigo-500 hover:text-indigo-800 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form id="delete-timecard-${tc.id}" action="/timecards/${tc.id}" method="POST" class="inline">
                                        <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" 
                                            onclick="confirmAction({
                                                title: 'Delete Timecard',
                                                message: 'Delete timecard entry for ${date}? This action is permanent.',
                                                buttonText: 'Delete Now',
                                                onConfirm: () => document.getElementById('delete-timecard-${tc.id}').submit()
                                            })"
                                            class="text-rose-400 hover:text-rose-600 transition-colors" 
                                            title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        `;
                        tbody.prepend(newRow);
                        
                        // Remove highlight after 2 seconds
                        setTimeout(() => {
                            newRow.classList.remove('animate-pulse', 'bg-indigo-50/30');
                        }, 2000);
                    }

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