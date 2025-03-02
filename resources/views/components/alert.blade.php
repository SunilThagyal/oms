<div>
    <!-- Success Alert -->
    @if (session('success'))
        <div id="success-alert" class="max-w-lg mx-auto mt-4 flex items-center justify-between p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md transition-opacity duration-1000 ease-out opacity-100">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
            <button onclick="fadeOutAlert('success-alert')" class="text-green-500 hover:text-green-700 focus:outline-none">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Error Alert -->
    @if ($errors->has('error'))
        <div id="error-alert" class="max-w-lg mx-auto mt-4 flex items-center justify-between p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md transition-opacity duration-1000 ease-out opacity-100">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636A9 9 0 115.636 18.364 9 9 0 0118.364 5.636zM12 8v4m0 4h.01"/>
                </svg>
                <p class="font-semibold">{{ $errors->first('error') }}</p>
            </div>
            <button onclick="fadeOutAlert('error-alert')" class="text-red-500 hover:text-red-700 focus:outline-none">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Warning Alert -->
    @if (session('warning'))
        <div id="warning-alert" class="max-w-lg mx-auto mt-4 flex items-center justify-between p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg shadow-md transition-opacity duration-1000 ease-out opacity-100">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.257 3.099c.366-.446.976-.446 1.342 0l7.071 8.614c.6.732.072 1.787-.923 1.787H3.768c-.995 0-1.523-1.055-.923-1.787l7.071-8.614zM12 14h.01m-.01 4h.01"/>
                </svg>
                <p class="font-semibold">{{ session('warning') }}</p>
            </div>
            <button onclick="fadeOutAlert('warning-alert')" class="text-yellow-500 hover:text-yellow-700 focus:outline-none">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <script>
        // Smooth fade-out function
        function fadeOutAlert(id) {
            const alert = document.getElementById(id);
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 1000); // Remove after fade-out
            }
        }

        // Auto-hide after 5 seconds with fade-out
        setTimeout(() => {
            fadeOutAlert('success-alert');
            fadeOutAlert('error-alert');
            fadeOutAlert('warning-alert');
        }, 5000);
    </script>
</div>
