
@extends('oms.layout.app')
@section('content')
<main class="flex-1 overflow-y-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <div class="flex items-center">
             <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 text-primary rounded-full">
                <i class="ri-shopping-cart-line text-xl"></i>
             </div>
             <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Orders</h3>
                <p class="text-2xl font-semibold">2,451</p>
                <p class="text-sm text-green-500">+15.3% vs last month</p>
             </div>
          </div>
       </div>
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <div class="flex items-center">
             <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                <i class="ri-time-line text-xl"></i>
             </div>
             <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                <p class="text-2xl font-semibold">145</p>
                <p class="text-sm text-red-500">+4.2% vs last month</p>
             </div>
          </div>
       </div>
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <div class="flex items-center">
             <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                <i class="ri-check-line text-xl"></i>
             </div>
             <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Completed</h3>
                <p class="text-2xl font-semibold">2,306</p>
                <p class="text-sm text-green-500">+18.5% vs last month</p>
             </div>
          </div>
       </div>
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <div class="flex items-center">
             <div class="w-12 h-12 flex items-center justify-center bg-purple-100 text-purple-600 rounded-full">
                <i class="ri-money-dollar-circle-line text-xl"></i>
             </div>
             <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Revenue</h3>
                <p class="text-2xl font-semibold">$84,245</p>
                <p class="text-sm text-green-500">+12.8% vs last month</p>
             </div>
          </div>
       </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <h3 class="text-lg font-medium mb-4">Order Trends</h3>
          <div id="orderTrends" class="chart-container"></div>
       </div>
       <div class="bg-white p-6 rounded-lg shadow-sm">
          <h3 class="text-lg font-medium mb-4">Top Products</h3>
          <div id="topProducts" class="chart-container"></div>
       </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm">
       <div class="p-6 border-b">
          <div class="flex items-center justify-between">
             <h3 class="text-lg font-medium">Recent Orders</h3>
             <button class="px-4 py-2 bg-primary text-white rounded-button whitespace-nowrap">View All</button>
          </div>
       </div>
       <div class="overflow-x-auto">
          <table class="w-full">
             <thead>
                <tr class="text-left bg-gray-50">
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                   <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
             </thead>
             <tbody class="divide-y divide-gray-200" id="orderTableBody">
                <tr>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-001</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Emily Thompson</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Premium Wireless Headphones</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$299.99</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Completed
                      </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-02-26</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-primary hover:text-indigo-900">View</button>
                   </td>
                </tr>
                <tr>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-002</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Michael Roberts</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Smart Home Security System</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$549.99</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                      Pending
                      </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-02-26</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-primary hover:text-indigo-900">View</button>
                   </td>
                </tr>
                <tr>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-003</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sarah Anderson</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4K Ultra HD Smart TV</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$899.99</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                      Processing
                      </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-02-25</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-primary hover:text-indigo-900">View</button>
                   </td>
                </tr>
                <tr>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-004</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">David Wilson</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Gaming Laptop Pro</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$1,499.99</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Completed
                      </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-02-25</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-primary hover:text-indigo-900">View</button>
                   </td>
                </tr>
                <tr>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD-2025-005</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jennifer Martinez</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Fitness Smartwatch</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$199.99</td>
                   <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Completed
                      </span>
                   </td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-02-24</td>
                   <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <button class="text-primary hover:text-indigo-900">View</button>
                   </td>
                </tr>
             </tbody>
          </table>
       </div>
    </div>
 </main>
@endsection
@push('scripts')
    <script src="{{asset("assets/js/dashboard-graph.js")}}"></script>
@endpush
