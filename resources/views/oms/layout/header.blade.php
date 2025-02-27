<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between p-4">
       <button class="lg:hidden w-8 h-8 flex items-center justify-center" id="sidebarToggle">
       <i class="ri-menu-line text-xl"></i>
       </button>
       <div class="flex items-center flex-1 px-4">
          <div class="relative flex-1 max-w-md">
             <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 text-sm border rounded-button">
             <div class="absolute left-3 top-2.5 w-4 h-4 flex items-center justify-center text-gray-400">
                <i class="ri-search-line"></i>
             </div>
          </div>
       </div>
       <div class="flex items-center space-x-4">
          <button class="w-8 h-8 flex items-center justify-center relative">
          <i class="ri-notification-line text-xl"></i>
          <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="relative">
             <button id="userMenuBtn" class="flex items-center space-x-2">
             <img src="https://public.readdy.ai/ai/img_res/f1a1d0525db06a36a653c30f6f0461a3.jpg" class="w-8 h-8 rounded-full object-cover">
             <span class="hidden md:block text-sm font-medium">James Wilson</span>
             </button>
             <div id="userMenu" class="dropdown absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
             </div>
          </div>
       </div>
    </div>
 </header>
