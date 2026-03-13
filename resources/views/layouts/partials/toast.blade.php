<!-- Global Toast Notification System -->
<div id="toast-container" class="fixed top-4 right-4 z-70 flex flex-col gap-3 pointer-events-none">
    
    @if(session('success'))
        <div class="toast bg-white border border-gray-100 shadow-xl rounded-xl p-4 flex items-start gap-3 w-80 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto">
            <div class="flex-shrink-0 bg-emerald-100 rounded-full p-1.5 mt-0.5">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-gray-900">Success</h4>
                <p class="text-xs text-gray-500 mt-1">{{ session('success') }}</p>
            </div>
            <button onclick="this.closest('.toast').remove()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="toast bg-white border border-gray-100 shadow-xl rounded-xl p-4 flex items-start gap-3 w-80 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto">
            <div class="flex-shrink-0 bg-red-100 rounded-full p-1.5 mt-0.5">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-gray-900">Error</h4>
                <p class="text-xs text-gray-500 mt-1">{{ session('error') }}</p>
            </div>
            <button onclick="this.closest('.toast').remove()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

</div>

<!-- JS Toast Controller -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toasts = document.querySelectorAll('.toast');
        
        toasts.forEach((toast, index) => {
            // Animate in one by one
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100 + (index * 150));

            // Auto dismiss after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300); // Wait for animation to finish
            }, 4000 + (index * 150));
        });
    });

    // Global function to trigger custom toasts from JS (e.g., from an aborted fetch or alert)
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const isSuccess = type === 'success';

        const toastHtml = `
            <div class="toast bg-white border border-gray-100 shadow-xl rounded-xl p-4 flex items-start gap-3 w-80 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto">
                <div class="flex-shrink-0 ${isSuccess ? 'bg-emerald-100' : 'bg-red-100'} rounded-full p-1.5 mt-0.5">
                    ${isSuccess 
                        ? `<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`
                        : `<svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`
                    }
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">${isSuccess ? 'Success' : 'Error'}</h4>
                    <p class="text-xs text-gray-500 mt-1">${message}</p>
                </div>
                <button onclick="this.closest('.toast').remove()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', toastHtml);
        const newToast = container.lastElementChild;
        
        // Trigger animation
        requestAnimationFrame(() => {
            setTimeout(() => {
                newToast.classList.remove('translate-x-full', 'opacity-0');
            }, 10);
        });

        // Auto remove
        setTimeout(() => {
            newToast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => newToast.remove(), 300);
        }, 4000);
    }
</script>
