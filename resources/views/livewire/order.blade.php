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
                            <input type="text" value="{{$filters['searchOrder']}}"   wire:model.live="filters.searchOrder"  id="searchInput" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
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
                                    <span> {{!empty($filters['status']) ?  ucfirst($filters['status']) : ucfirst('All Status') }}</span>
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
                                            wire:target="toggleModal('addEditOrderModal', '{{ hash_id($order->id) }}')"
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
                                            <button   onclick="deleteOrder('ORD-{{hash_id($order->id)}}')" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-500">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- PAGINATION --}}
                <x-pagination :paginator="$orders" />
                {{-- end PAGINATION --}}
            </div>
        </div>
    </div>
    @include("oms.orders.popups.add_edit")
    @include("oms.orders.popups.view_order")
</main>

<script>
    function deleteOrder(orderId) {
        const confirmModal = document.createElement('div');
        confirmModal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        confirmModal.innerHTML = `
            <div class="bg-white rounded-lg w-full max-w-md mx-4">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto">
                        <i class="ri-error-warning-line text-red-600 text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-center text-gray-900">Delete Order</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">Are you sure you want to delete this order? This action cannot be undone.</p>
                    <div class="mt-6 flex items-center justify-center gap-4">
                        <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-sm border rounded !rounded-button hover:bg-gray-50">Cancel</button>
                        <button onclick="confirmDelete('${orderId}', this)" class="px-4 py-2 text-sm bg-red-600 text-white rounded !rounded-button hover:bg-red-700">Delete</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(confirmModal);
    }

    function confirmDelete(orderId, button) {
        Livewire.dispatch('delete-order', {'orderId': orderId});
        Livewire.on('order-deleted', (data) => {
            showToast(data[0].message, data[0].status);
            // Optional: Update local lists
            orders = orders.filter(o => o.id !== orderId);
            filteredOrders = filteredOrders.filter(o => o.id !== orderId);
            renderOrders();
            button.closest('.fixed').remove();
        });
    }
</script>
