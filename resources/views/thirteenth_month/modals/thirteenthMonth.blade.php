<div id="thirteenthMonthModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm relative">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">13th Month Report</h2>
            <button type="button" onclick="closeModal('thirteenthMonthModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6">
            <div class="text-center mb-6">
                <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Generate Payouts</h3>
                <p class="text-sm text-gray-500 mt-1">Select generation method for the filtered period.</p>
            </div>

            <div class="space-y-3">
                <button onclick="generateBulk()" class="w-full flex justify-center items-center gap-2 bg-slate-900 text-white font-medium py-3 rounded-xl hover:bg-slate-800 transition-all shadow-sm focus:ring-2 focus:ring-slate-900 focus:ring-offset-1 focus:outline-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Generate All (Bulk)
                </button>

                <button onclick="generateSelected()" class="w-full flex justify-center items-center gap-2 bg-emerald-600 text-white font-medium py-3 rounded-xl hover:bg-emerald-700 transition-all shadow-sm shadow-emerald-500/30 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1 focus:outline-none">
                    <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Generate Selected
                </button>
            </div>
            
        </div>
    </div>
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

    function generateBulk() {
        let year = document.querySelector('input[name="year"]').value;
        window.open("{{ route('thirteenth_month.printBulk') }}?year=" + year, "_blank");
    }

    function generateSelected() {
        let ids = [];
        document.querySelectorAll('.employeeCheckbox:checked').forEach(cb => ids.push(cb.value));

        if (ids.length === 0) {
            showToast("Please select at least one employee", "error");
            return;
        }

        let year = document.querySelector('input[name="year"]').value;
        window.open("{{ route('thirteenth_month.printSelected') }}?ids=" + ids.join(',') + "&year=" + year, "_blank");
    }
</script>