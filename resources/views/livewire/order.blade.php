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
                                <button id="addOrderBtn" wire:click="toggleModal('addEditOrderModal')" class="w-full bg-blue-600 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-blue-500 justify-center z-50">                                    <i class="ri-add-line w-4 h-4 flex items-center justify-center"></i>
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
                            @forelse ($orders as $order)
                                <tr wire:key="{{'ORD-'.hash_id($order->id)}}" class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-4 text-sm">ORD-{{hash_id($order->id)}}</td>
                                    <td class="py-4 px-4 text-sm">{{($order->customer->name)}}</td>
                                    <td class="py-4 px-4 text-sm">{{$order->created_at}}</td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{$order->status_class}}">{{$order->status}}</span>
                                    </td>
                                    <td class="py-4 px-4 text-sm">${{$order->total_price}}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Show the "view" button unless it's in loading state -->
                                            <button wire:click="toggleModal('viewOrderModal', '{{ hash_id($order->id) }}')"
                                                wire:loading.remove
                                                wire:target="toggleModal('viewOrderModal', '{{ hash_id($order->id) }}')"
                                                wire:loading.attr="disabled"
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500 relative">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button wire:loading.delay wire:target="toggleModal('viewOrderModal', '{{ hash_id($order->id) }}')"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500 relative">
                                                <div class="absolute inset-0 flex items-center justify-center bg-gray-50 opacity-75 rounded-full">
                                                    <svg class="animate-spin h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.2"/>
                                                        <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                                    </svg>
                                                </div>
                                            </button>
                                            {{-- edit button --}}
                                            <button
                                            wire:click="toggleModal('addEditOrderModal', '{{ hash_id($order->id) }}')"
                                            wire:loading.remove
                                            wire:target="toggleModal('viewOrderModal', '{{ hash_id($order->id) }}')"
                                            wire:loading.attr="disabled"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button wire:loading.delay wire:target="toggleModal('addEditOrderModal', '{{ hash_id($order->id) }}')"
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500 relative">
                                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50 opacity-75 rounded-full">
                                                        <svg class="animate-spin h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.2"/>
                                                            <path d="M4 12a8 8 0 0116 0" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                                                        </svg>
                                                    </div>
                                            </button>
                                            {{--  --}}
                                            <button onclick="deleteOrder('ORD-{{hash_id($order->id)}}')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
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
                            {{-- <tr class="border-b hover:bg-gray-50">
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
                            </tr> --}}
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
    @include("oms.orders.popups.add_edit")
    @include("oms.orders.popups.view_order")
</main>
