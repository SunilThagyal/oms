@extends('oms.layout.app')

@section('content')
<main class="flex-1 overflow-y-auto p-6">
    <div class="p-6">
        <div class="w-full max-w-[1400px] mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Orders</h1>
                <div class="flex flex-wrap gap-2 border-b overflow-x-auto pb-2">
                    <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button active" data-status="all">
                        All Orders
                        <span class="ml-2 px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full" id="all-count">0</span>
                    </button>
                    <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button" data-status="Pending">
                        Pending
                        <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full" id="pending-count">0</span>
                    </button>
                    <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button" data-status="Processing">
                        Processing
                        <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full" id="processing-count">0</span>
                    </button>
                    <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button" data-status="Completed">
                        Completed
                        <span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full" id="completed-count">0</span>
                    </button>
                    <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button" data-status="Cancelled">
                        Cancelled
                        <span class="ml-2 px-2 py-0.5 text-xs bg-red-100 text-red-800 rounded-full" id="cancelled-count">0</span>
                    </button>
                </div>
            </div>
            <div class="bg-white rounded shadow-sm p-4 sm:p-6 mb-6">
                <div class="flex flex-col gap-4 mb-6">
                    <div class="flex flex-col gap-4">
                        <div class="relative w-full">
                            <input type="text" id="searchInput" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                                <i class="ri-search-line"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="relative">
                                <button id="dateFilter" class="w-full px-4 py-2 text-sm border rounded !rounded-button flex items-center gap-2 hover:bg-gray-50">
                                    <i class="ri-calendar-line w-4 h-4 flex items-center justify-center"></i>
                                    <span>Date Range</span>
                                </button>
                            </div>
                            <div class="relative">
                                <button id="statusFilter" class="w-full px-4 py-2 text-sm border rounded !rounded-button flex items-center gap-2 hover:bg-gray-50">
                                    <i class="ri-filter-3-line w-4 h-4 flex items-center justify-center"></i>
                                    <span>All Status</span>
                                </button>
                            </div>
                            <div class="relative">
                                <button id="exportBtn" class="w-full px-4 py-2 text-sm border rounded !rounded-button flex items-center gap-2 hover:bg-gray-50">
                                    <i class="ri-download-line w-4 h-4 flex items-center justify-center"></i>
                                    <span>Export</span>
                                </button>
                            </div>
                            <div class="relative">
                                <button id="addOrderBtn" class="w-full bg-primary text-white px-4 py-2 rounded !rounded-button flex items-center gap-2 hover:bg-primary/90 justify-center">
                                    <i class="ri-add-line w-4 h-4 flex items-center justify-center"></i>
                                    <span class="whitespace-nowrap">Add Order</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-container overflow-x-auto">
                    <table class="w-full min-w-[800px] table-auto">
                        <thead>
                            <tr class="border-b">
                                <th class="py-4 px-4 text-left text-sm font-medium text-gray-500">Order ID</th>
                                <th class="py-4 px-4 text-left text-sm font-medium text-gray-500">Customer</th>
                                <th class="py-4 px-4 text-left text-sm font-medium text-gray-500">Date</th>
                                <th class="py-4 px-4 text-left text-sm font-medium text-gray-500">Status</th>
                                <th class="py-4 px-4 text-left text-sm font-medium text-gray-500">Total</th>
                                <th class="py-4 px-4 text-right text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">ORD-2025-001</td>
                                <td class="py-4 px-4 text-sm">Emily Thompson</td>
                                <td class="py-4 px-4 text-sm">2025-02-26</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                </td>
                                <td class="py-4 px-4 text-sm">$299.99</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="viewOrder('ORD-2025-001')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button onclick="editOrder('ORD-2025-001')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button onclick="deleteOrder('ORD-2025-001')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">ORD-2025-002</td>
                                <td class="py-4 px-4 text-sm">Michael Chen</td>
                                <td class="py-4 px-4 text-sm">2025-02-26</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                </td>
                                <td class="py-4 px-4 text-sm">$149.50</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="viewOrder('ORD-2025-002')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button onclick="editOrder('ORD-2025-002')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button onclick="deleteOrder('ORD-2025-002')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">ORD-2025-003</td>
                                <td class="py-4 px-4 text-sm">Sarah Williams</td>
                                <td class="py-4 px-4 text-sm">2025-02-25</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Processing</span>
                                </td>
                                <td class="py-4 px-4 text-sm">$499.99</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="viewOrder('ORD-2025-003')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button onclick="editOrder('ORD-2025-003')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button onclick="deleteOrder('ORD-2025-003')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">ORD-2025-004</td>
                                <td class="py-4 px-4 text-sm">David Rodriguez</td>
                                <td class="py-4 px-4 text-sm">2025-02-25</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>
                                </td>
                                <td class="py-4 px-4 text-sm">$89.99</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="viewOrder('ORD-2025-004')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button onclick="editOrder('ORD-2025-004')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button onclick="deleteOrder('ORD-2025-004')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">ORD-2025-005</td>
                                <td class="py-4 px-4 text-sm">Jessica Lee</td>
                                <td class="py-4 px-4 text-sm">2025-02-24</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                </td>
                                <td class="py-4 px-4 text-sm">$199.99</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="viewOrder('ORD-2025-005')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        <button onclick="editOrder('ORD-2025-005')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-edit-line"></i>
                                        </button>
                                        <button onclick="deleteOrder('ORD-2025-005')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                    <div class="text-sm text-gray-500">
                        Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalItems">100</span> entries
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50 disabled:opacity-50" id="prevPage" disabled>Previous</button>
                        <button class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50" id="nextPage">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addOrderModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900">Add New Order</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
                    </button>
                </div>
            </div>
            <form id="orderForm" class="p-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Information</label>
                        <div class="space-y-4">
                            <input type="text" name="customerName" placeholder="Customer Name" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                            <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                            <input type="tel" name="phone" placeholder="Phone Number" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Details</label>
                        <div class="space-y-4" id="productList">
                            <div class="flex gap-4 product-row">
                                <input type="text" name="productName" placeholder="Product Name" class="flex-1 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                                <input type="number" name="quantity" placeholder="Quantity" class="w-24 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required min="1">
                                <input type="number" name="price" placeholder="Price" class="w-32 px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required step="0.01">
                            </div>
                        </div>
                        <button type="button" id="addProduct" class="text-primary text-sm hover:text-primary/80 flex items-center gap-1 mt-2">
                            <i class="ri-add-line w-4 h-4 flex items-center justify-center"></i>
                            <span>Add Another Product</span>
                        </button>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Order Date</label>
                            <input type="date" name="date" class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary" required>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-4">
                    <button type="button" class="px-4 py-2 text-sm border rounded !rounded-button hover:bg-gray-50" id="cancelOrder">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-primary text-white rounded !rounded-button hover:bg-primary/90">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{asset("assets/js/order.js")}}"></script>
@endpush
