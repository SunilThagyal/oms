<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <!-- Load Tailwind first -->
      <script src="https://cdn.tailwindcss.com" data-cfasync="false"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
      <style>
         :where([class^="ri-"])::before { content: "\f3c2"; }
         @keyframes float {
         0% { transform: translateY(0px); }
         50% { transform: translateY(-20px); }
         100% { transform: translateY(0px); }
         }
         @keyframes fadeIn {
         from { opacity: 0; transform: translateY(20px); }
         to { opacity: 1; transform: translateY(0); }
         }
         .floating { animation: float 6s ease-in-out infinite; }
         .fade-in { animation: fadeIn 0.6s ease-out forwards; }
         .fade-in-delay-1 { animation-delay: 0.2s; }
         .fade-in-delay-2 { animation-delay: 0.4s; }
         .fade-in-delay-3 { animation-delay: 0.6s; }
         .glass-effect {
         background: rgba(255, 255, 255, 0.8);
         backdrop-filter: blur(16px);
         box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
         }
      </style>
      <script data-cfasync="false">
         tailwind.config = {
         theme: {
         extend: {
         colors: {
         primary: '#4F46E5',
         secondary: '#E5E7EB'
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
   </head>
   <body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
      <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
         <div class="floating absolute top-1/4 left-1/4 w-32 h-32 bg-gradient-to-br from-blue-200/30 to-blue-100/30 rounded-full blur-xl"></div>
         <div class="floating absolute top-3/4 right-1/4 w-40 h-40 bg-gradient-to-br from-indigo-200/30 to-indigo-100/30 rounded-full blur-xl" style="animation-delay: -2s;"></div>
         <div class="floating absolute bottom-1/4 left-1/3 w-24 h-24 bg-gradient-to-br from-purple-200/30 to-purple-100/30 rounded-full blur-xl" style="animation-delay: -4s;"></div>
      </div>
      <div class="glass-effect w-full max-w-md p-8 rounded-2xl shadow-2xl opacity-0 fade-in border border-white/20">
         <div class="text-center mb-8">
            <h1 class="font-['Pacifico'] text-4xl text-primary mb-2">{{config("app.name")}}</h1>
            <p class="text-gray-600">Welcome back! Please login to your account.</p>
         </div>
         <x-alert/>
         <form id="loginForm" action="{{route("auth.login")}}" method="post" class="space-y-6">
            @csrf
            <div class="opacity-0 fade-in fade-in-delay-1">
               <div class="relative">
                  <input type="email" name="email" id="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white/50 focus:border-primary focus:outline-none transition-colors text-sm placeholder:text-gray-400" placeholder="Email address" required>
                  <div class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                     <i class="ri-mail-line"></i>
                  </div>
               </div>
            </div>
            <div class="opacity-0 fade-in fade-in-delay-2">
               <div class="relative">
                  <input type="password"  name="password" id="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white/50 focus:border-primary focus:outline-none transition-colors text-sm placeholder:text-gray-400" placeholder="Password" required>
                  <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                  <i class="ri-eye-line"></i>
                  </button>
               </div>
            </div>
            <div class="flex items-center justify-between opacity-0 fade-in fade-in-delay-2">
               <label class="flex items-center">
               <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 border-2 border-gray-300 rounded text-primary focus:ring-primary">
               <span class="ml-2 text-sm text-gray-600">Remember me</span>
               </label>
               <a href="{{route("auth.foget_password")}}" class="text-sm text-primary hover:text-primary/80 transition-colors">Forgot password?</a>
            </div>
            <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl hover:bg-primary/90 transition-all transform hover:scale-[1.02] active:scale-[0.98] opacity-0 fade-in fade-in-delay-3 !rounded-button whitespace-nowrap shadow-lg shadow-primary/25">
            Sign in
            </button>
            <div class="relative opacity-0 fade-in fade-in-delay-3">
               <div class="absolute inset-0 flex items-center">
                  <div class="w-full border-t border-gray-200"></div>
               </div>
               <div class="relative flex justify-center text-sm">
                  <span class="px-2 bg-white text-gray-500">Or continue with</span>
               </div>
            </div>
            <div class="grid grid-cols-3 gap-4 opacity-0 fade-in fade-in-delay-3">
               <button type="button" class="flex items-center justify-center py-2 px-4 border-2 border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors !rounded-button whitespace-nowrap shadow-md">
               <i class="ri-google-fill text-[#DB4437] text-xl"></i>
               </button>
               <button type="button" class="flex items-center justify-center py-2 px-4 border-2 border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors !rounded-button whitespace-nowrap shadow-md">
               <i class="ri-apple-fill text-black text-xl"></i>
               </button>
               <button type="button" class="flex items-center justify-center py-2 px-4 border-2 border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors !rounded-button whitespace-nowrap shadow-md">
               <i class="ri-github-fill text-black text-xl"></i>
               </button>
            </div>
         </form>
         <p class="text-center mt-8 text-sm text-gray-600 opacity-0 fade-in fade-in-delay-3">
            Don't have an account?
            <a href="#" class="text-primary hover:text-primary/80 transition-colors">Sign up</a>
         </p>
      </div>
      <div id="notification" class="fixed top-4 right-4 bg-white rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300 flex items-center">
         <i class="ri-error-warning-line text-red-500 mr-2"></i>
         <span id="notificationText"></span>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notificationText');
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePassword.innerHTML = type === 'password' ?
                    '<i class="ri-eye-line"></i>' :
                    '<i class="ri-eye-off-line"></i>';
            });
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                if (!email || !password) {
                    showNotification('Please fill in all fields');
                    return;
                }
                if (!email.includes('@')) {
                    showNotification('Please enter a valid email address');
                    return;
                }
                if (password.length < 6) {
                    showNotification('Password must be at least 6 characters');
                    return;
                }
                showNotification('Logging in...', 'success');
                form.submit();
            });

            function showNotification(message, type = 'error') {
                notificationText.textContent = message;
                notification.classList.remove('translate-x-full');
                notification.style.backgroundColor = type === 'error' ? '#FEE2E2' : '#D1FAE5';
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                }, 3000);
            }
        });
    </script>
   </body>
</html>
