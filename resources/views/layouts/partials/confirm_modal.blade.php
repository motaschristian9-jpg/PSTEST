<!-- Custom Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-60 transition-all p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm relative overflow-hidden transform transition-all scale-95 opacity-0" id="confirmModalCard">
        
        <!-- Header -->
        <div class="p-6 text-center">
            <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2" id="confirmTitle">Confirm Action</h3>
            <p class="text-sm text-gray-500" id="confirmMessage">Are you sure you want to proceed? This action cannot be undone.</p>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 flex gap-3">
            <button type="button" onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 transition-all">
                Cancel
            </button>
            <button type="button" id="confirmSubmitBtn" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-all shadow-sm shadow-red-500/30">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    let confirmCallback = null;

    window.confirmAction = function(options) {
        const modal = document.getElementById('confirmModal');
        const card = document.getElementById('confirmModalCard');
        const title = document.getElementById('confirmTitle');
        const message = document.getElementById('confirmMessage');
        const submitBtn = document.getElementById('confirmSubmitBtn');

        title.innerText = options.title || 'Confirm Action';
        message.innerText = options.message || 'Are you sure?';
        submitBtn.innerText = options.buttonText || 'Confirm';
        
        // Remove old event listeners
        const newSubmitBtn = submitBtn.cloneNode(true);
        submitBtn.parentNode.replaceChild(newSubmitBtn, submitBtn);

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger entrance animation
        requestAnimationFrame(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        });

        newSubmitBtn.addEventListener('click', () => {
            if (options.onConfirm) options.onConfirm();
            closeConfirmModal();
        });
    }

    window.closeConfirmModal = function() {
        const modal = document.getElementById('confirmModal');
        const card = document.getElementById('confirmModalCard');

        card.classList.add('scale-95', 'opacity-0');
        card.classList.remove('scale-100', 'opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>
