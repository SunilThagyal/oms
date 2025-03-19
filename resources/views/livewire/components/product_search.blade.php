<div class="relative w-full">
    <!-- Search Input -->
    <div class="flex items-center border rounded-lg px-3 py-1 shadow-sm focus-within:ring-2 focus-within:ring-primary transition">
        <!-- Search Icon -->
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l5 5m-5-5a7 7 0 1 0-10 0 7 7 0 0 0 10 0z" />
        </svg>

        <!-- Input Field -->
        <input
            type="text"
            wire:model.live="searchProduct.{{ $outer_loop_index }}"
            value="{{ $data['order'][$outer_loop_index]['name'] ?? '' }}"
            placeholder="Product Name"
            class="w-full px-3 py-1 text-sm bg-transparent focus:outline-none"
            autocomplete="off"
            aria-label="Search products"
        />

        <!-- Loader Spinner -->
        <div wire:loading wire:target="searchProduct.{{ $outer_loop_index }}" class="ml-2">
            <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Search Results Dropdown -->
    @if ( isset($showProductDropdown) && $showProductDropdown != 'none' && ($drop_down_id == $showProductDropdown) &&  !$products->isEmpty())
        <div  class="absolute left-0 w-full bg-white shadow-lg rounded-lg mt-1 z-50 max-h-60 overflow-y-auto">
            @foreach ($products as $product)
                <div
                    data-id="{{$outer_loop_index}}"
                    class="px-4 py-2 hover:bg-primary/10 cursor-pointer transition"
                    wire:click="selectProduct({{ $product->id}},{{ $outer_loop_index}})"
                    wire:key="product-{{ $product->id }}"
                    aria-label="Select product {{ $product->name }}"
                >
                    <!-- product Name -->
                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                    <!-- product Email -->
                    <div class="text-sm text-gray-500">{{ $product->store->name }}</div>
                </div>
            @endforeach
        </div>
    @elseif($showProductDropdown && isset($searchProduct[$outer_loop_index]) && strlen($searchProduct[$outer_loop_index]) > 1)
        <span class="text-yellow-600 text-xs mt-1 block">{{ __("No product found, add manually.") }}</span>
    @endif
</div>
