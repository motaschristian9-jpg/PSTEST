<div id="payslipModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm relative">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Print Payslips</h2>
            <button type="button" onclick="closeModal('payslipModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6">
            <div class="text-center mb-6">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Download Documents</h3>
                <p class="text-sm text-gray-500 mt-1">Select generation method to printable payslips.</p>
            </div>

            <div class="space-y-3">
                <button onclick="printBulk()" class="w-full flex justify-center items-center gap-2 bg-slate-900 text-white font-medium py-3 rounded-xl hover:bg-slate-800 transition-all shadow-sm focus:ring-2 focus:ring-slate-900 focus:ring-offset-1 focus:outline-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Print All (Bulk)
                </button>

                <button onclick="printSelected()" class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white font-medium py-3 rounded-xl hover:bg-indigo-700 transition-all shadow-sm shadow-indigo-500/30 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 focus:outline-none">
                    <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Print Selected
                </button>
            </div>
            
        </div>
    </div>
</div>
