@php
    $statuses = [
        'all' => ['label' => 'All Orders', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600',  'count' => orderCount('all')],
        'pending' => ['label' => 'Pending', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800',  'count' => orderCount('pending')],
        'processing' => ['label' => 'Processing', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800',  'count' => orderCount('processing')],
        'completed' => ['label' => 'Completed', 'bg' => 'bg-green-100', 'text' => 'text-green-800',  'count' => orderCount('completed')],
        'cancelled' => ['label' => 'Cancelled', 'bg' => 'bg-red-100', 'text' => 'text-red-800',  'count' => orderCount('cancelled')]
    ];
@endphp

<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Orders</h1>
    <div class="flex flex-wrap gap-2 border-b overflow-x-auto pb-2">
        @foreach ($statuses as $status => $data)
            <button wire:click="setFilter('status', '{{ $status == 'all' ? null : $status }}')"
                    class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap tab-button
                           {{ $filters['status'] == $status ? ' text-gray-900 font-semibold' : '' }}"
                    data-status="{{ ucfirst($status) }}">
                {{ $data['label'] }}
                <span class="ml-2 px-2 py-0.5 text-xs {{ $data['bg'] }} {{ $data['text'] }} rounded-full" id="{{ $status }}-count">
                    {{ $data['count'] ?? 0 }}
                </span>
            </button>
        @endforeach
    </div>
</div>
