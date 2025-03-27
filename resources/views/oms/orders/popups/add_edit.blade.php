{{-- add order modal --}}
<div id="addOrderModal"
    class="fixed inset-0 bg-black/50 items-center justify-center z-50 {{ $addEditOrderModal ? 'flex' : 'hidden' }}">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-900">{{ $editMode ? 'Edit Order' : 'Add New Order' }}</h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                <i class="ri-close-line w-6 h-6 flex items-center justify-center"></i>
            </button>
        </div>

        <form wire:submit.prevent="saveOrder('{{ isset($viewed_order) ? hash_id($viewed_order?->id) : null}}')" class="p-6">
            <div class="space-y-6">
                <!-- Customer Information -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer Information</label>
                    <div class="space-y-4">
                        {{-- <input type="text" wire:model.live="data.customer.name" placeholder="Customer Name"
                            class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary"> --}}
                            <div class="relative w-full">
                                <!-- Search Input -->
                                <div class="flex items-center border rounded-lg px-3 py-2 shadow-sm focus-within:ring-2 focus-within:ring-primary transition">
                                    <!-- Search Icon -->
                                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5 5m-5-5a7 7 0 1 0-10 0 7 7 0 0 0 10 0z" />
                                    </svg>

                                    <!-- Input Field -->
                                    <input
                                        type="text"
                                        value="{{$viewed_order?->customer?->name ?? ''}}"
                                        wire:model.live="searchCustomer"
                                        placeholder="Search or Enter Name"
                                        class="w-full px-3 py-1 text-sm bg-transparent focus:outline-none"
                                        autocomplete="off"
                                        aria-label="Search customers"
                                    />

                                    <!-- Loader Spinner -->
                                    <div wire:loading wire:target="searchCustomer" class="ml-2">
                                        <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Search Results Dropdown -->
                                @if ($showCustomerDropdown && !$customers->isEmpty())
                                    <div class="absolute left-0 w-full bg-white shadow-lg rounded-lg mt-1 z-50 max-h-60 overflow-y-auto">
                                        @foreach ($customers as $customer)
                                            <div
                                                class="px-4 py-2 hover:bg-primary/10 cursor-pointer transition"
                                                wire:click="selectCustomer({{ $customer->id }})"
                                                aria-label="Select customer {{ $customer->name }}"
                                            >
                                                <!-- Customer Name -->
                                                <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                                <!-- Customer Email -->
                                                <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($showCustomerDropdown && strlen($searchCustomer) > 1)
                                <span class="text-yellow-600 text-xs mt-1 block">{{ __("No such customer exists, add details manually.") }}</span>
                                {{-- <div class="absolute left-0 w-full bg-white shadow-lg rounded-lg mt-1 px-4 py-2 text-gray-500">
                                        No results found. Press Enter to add a new customer.
                                    </div> --}}
                                @endif

                                <!-- Validation Error -->
                                @error('data.customer.name')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        <input type="email" wire:model.live="data.customer.email"  value="{{ $selectedCustomer ? $selectedCustomer->email : ''}}" placeholder="Email Address"
                            class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
                        <span class="text-red-500 text-xs">@error('data.customer.email') {{ $message }} @enderror</span>

                        <input type="tel" wire:model.live="data.customer.phone" placeholder="Phone Number"
                            class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
                        <span class="text-red-500 text-xs">@error('data.customer.phone') {{ $message }} @enderror</span>
                    </div>
                </div>
                <!-- Order Details -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Details</label>
                    <div class="space-y-4" id="productList">
                        @foreach ($data['order'] as $index => $product)
                            <div class="flex gap-4 items-start product-row">
                                <div class="flex-1 flex flex-col">
                                    {{-- <input type="text" wire:model.live="data.order.{{ $index }}.name"
                                        placeholder="Product Name"
                                        class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary"> --}}
                                        {{--  --}}
                                        @include('livewire.components.product_search', ['outer_loop_index' => $index,'drop_down_id' => 'productDropDownId'.$index])
                                        {{--  --}}
                                    <span
                                        class="text-red-500 text-xs">@error('data.order.' . $index . '.name') {{ $message }} @enderror</span>
                                </div>
                                <div class="flex-1 flex flex-col">
                                    <input type="number" wire:model.live="data.order.{{ $index }}.quantity" placeholder="Qty"
                                        class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary"
                                        min="1">
                                    <span class="text-red-500 text-xs">@error('data.order.' . $index . '.quantity') {{ $message }} @enderror</span>
                                </div>
                                <div class="flex-1 flex flex-col">
                                    <input type="number" wire:model.live="data.order.{{ $index }}.price" placeholder="Price"
                                        class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary"
                                        step="0.01">
                                    <span
                                        class="text-red-500 text-xs">@error('data.order.' . $index . '.price') {{ $message }} @enderror</span>
                                </div>

                                <!-- Remove Product Button -->
                                <button type="button" wire:click="removeProduct({{ $index }})"
                                    class="text-red-500 hover:text-red-700 relative">
                                    <span wire:loading.remove wire:target="removeProduct({{ $index }})">
                                        <i class="ri-delete-bin-6-line w-5 h-5"></i>
                                    </span>
                                    <div wire:loading wire:target="removeProduct({{ $index }})">
                                        <svg class="animate-spin h-5 w-5 text-red-500" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Product Button -->
                    <button type="button" wire:click="addProduct"
                        class="text-primary text-sm flex items-center gap-1 mt-2 relative">
                        <span wire:loading.remove wire:target="addProduct">
                            <i class="ri-add-line w-4 h-4"></i> Add Another Product
                        </span>
                        <div wire:loading wire:target="addProduct">
                            <svg class="animate-spin h-5 w-5 text-primary" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Order Status & Date -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select wire:model.live="data.status"
                            class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <span class="text-red-500 text-xs">@error('data.status') {{ $message }} @enderror</span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Date</label>
                        <input type="date" wire:model.live="data.date"
                            class="w-full px-4 py-2 text-sm border rounded focus:outline-none focus:border-primary">
                        <span class="text-red-500 text-xs">@error('data.date') {{ $message }} @enderror</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex items-center justify-end gap-4">
                <button type="button" wire:loading.remove wire:target="closeModal" wire:click="closeModal"
                    class="px-4 py-2 text-sm border rounded hover:bg-gray-50">Cancel</button>
                <div wire:loading wire:target="closeModal">
                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
                <button type="submit"
                {{-- @disabled($errors->any()) --}}
                    class="px-4 py-2 text-sm bg-primary text-white rounded hover:bg-primary/90 flex items-center gap-2 relative">
                    <span wire:loading.remove wire:target="saveOrder">Create Order</span>
                    <div wire:loading wire:target="saveOrder">
                        <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>
