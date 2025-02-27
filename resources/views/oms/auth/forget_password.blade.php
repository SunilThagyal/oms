<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#f43f5e'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        .toast {
            animation: slideIn 0.3s ease-in-out, fadeOut 0.3s ease-in-out 4.7s forwards;
        }
        @keyframes slideIn {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="font-['Pacifico'] text-3xl mb-2 text-primary">logo</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Forgot Password</h2>
            <p class="text-gray-600">Enter your email address to reset your password</p>
        </div>

        <form id="resetForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-mail-line text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Enter your email">
                </div>
                <p id="emailError" class="mt-1 text-sm text-secondary hidden">Please enter a valid email address</p>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed !rounded-button whitespace-nowrap flex items-center justify-center">
                <span id="buttonText">Reset Password</span>
                <div id="loadingSpinner" class="hidden">
                    <i class="ri-loader-4-line animate-spin ml-2"></i>
                </div>
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Back to Login</a>
        </div>
    </div>

    <div id="toast" class="fixed top-4 right-4 hidden bg-green-500 text-white px-6 py-3 rounded shadow-lg toast">
        <div class="flex items-center space-x-2">
            <i class="ri-checkbox-circle-line"></i>
            <span>Password reset link has been sent to your email</span>
        </div>
    </div>

    <script>
        const form = document.getElementById('resetForm');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const submitBtn = document.getElementById('submitBtn');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const toast = document.getElementById('toast');

        let isSubmitting = false;

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email.toLowerCase());
        }

        function showError() {
            emailError.classList.remove('hidden');
            emailInput.classList.add('border-secondary');
        }

        function hideError() {
            emailError.classList.add('hidden');
            emailInput.classList.remove('border-secondary');
        }

        function showToast() {
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 5000);
        }

        emailInput.addEventListener('input', (e) => {
            if (validateEmail(e.target.value)) {
                hideError();
                submitBtn.disabled = false;
            } else {
                showError();
                submitBtn.disabled = true;
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isSubmitting) return;
            const email = emailInput.value;
            if (!validateEmail(email)) {
                showError();
                return;
            }

            isSubmitting = true;
            buttonText.textContent = 'Sending...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;

            try {
                await new Promise(resolve => setTimeout(resolve, 1500));
                showToast();
                emailInput.value = '';
            } finally {
                isSubmitting = false;
                buttonText.textContent = 'Reset Password';
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
