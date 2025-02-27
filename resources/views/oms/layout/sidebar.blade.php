<aside class="w-64 bg-white shadow-lg hidden lg:block" id="sidebar">
    <div class="p-4 border-b">
       <h1 class="text-2xl font-['Pacifico']">OMS</h1>
    </div>
    <nav class="p-4 space-y-2">
       <a href="{{route('oms.dashboard')}}" class="flex items-center p-3 {{ request()->routeIs('oms.dashboard') ? 'text-primary bg-indigo-50' : '' }}  rounded-button">
          <div class="w-6 h-6 flex items-center justify-center">
             <i class="ri-dashboard-line"></i>
          </div>
          <span class="ml-3">Dashboard</span>
       </a>
       <a href="{{route("oms.order.list")}}" class="flex items-center p-3 text-gray-600 hover:bg-gray-50 rounded-button  {{ request()->routeIs('oms.order.*') ? 'text-primary bg-indigo-50' : '' }}">
          <div class="w-6 h-6 flex items-center justify-center">
             <i class="ri-shopping-cart-line"></i>
          </div>
          <span class="ml-3">Orders</span>
       </a>
       <a href="{{route("oms.customer.list")}}" class="flex items-center p-3 text-gray-600 hover:bg-gray-50 rounded-button {{ request()->routeIs('oms.customer.*') ? 'text-primary bg-indigo-50' : '' }}">
          <div class="w-6 h-6 flex items-center justify-center">
             <i class="ri-user-line"></i>
          </div>
          <span class="ml-3">Customers</span>
       </a>
       <a href="{{route("oms.product.list")}}" class="flex items-center p-3 text-gray-600 hover:bg-gray-50 rounded-button {{ request()->routeIs('oms.product.*') ? 'text-primary bg-indigo-50' : '' }}">
          <div class="w-6 h-6 flex items-center justify-center">
             <i class="ri-shopping-bag-line"></i>
          </div>
          <span class="ml-3">Products</span>
       </a>
    </nav>
 </aside>
