<div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
    <div class="text-sm text-gray-500">
        Showing
        <span>{{ $paginator->firstItem() }}</span>
        to
        <span>{{ $paginator->lastItem() }}</span>
        of
        <span>{{ $paginator->total() }}</span>
        entries
    </div>

    <div class="flex items-center gap-2">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <button class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50 disabled:opacity-50" disabled>
                Previous
            </button>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled"
                    class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50">
                Previous
            </button>
        @endif

        {{-- Page Numbers --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <button wire:click="gotoPage({{ $page }})"
                    class="px-3 py-1 border rounded !rounded-button text-sm  {{ $paginator->currentPage() == $page ? 'bg-blue-500 disabled:opacity-50 text-white' : 'hover:bg-gray-50' }}">
                {{ $page }}
            </button>
        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled"
                    class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50">
                Next
            </button>
        @else
            <button class="px-3 py-1 border rounded !rounded-button text-sm hover:bg-gray-50 disabled:opacity-50" disabled>
                Next
            </button>
        @endif
    </div>

    {{--  --}}
</div>
