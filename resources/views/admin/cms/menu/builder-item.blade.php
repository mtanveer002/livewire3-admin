<li class="item dd-item pl-2 {{ $item->children->isNotEmpty() ? 'pt-2' : 'py-2' }} my-1 items-center text-indigo-100 leading-none"
    data-id="{{ $item->id }}">
    <div class="bg-gray-100 rounded p-4">
        <span class="uppercase text-gray-700 text-md font-bold mr-3 dd-handle cursor-move inline">
            <x-icon ref="menu" class="inline" />
        </span>
        <span
            class="font-semibold mx-3 text-left flex-auto text-gray-500 max-w-xs overflow-hidden whitespace-nowrap inline-block">{{ $item->title }}</span>
        <small class="text-gray-400 max-w-xs overflow-hidden whitespace-nowrap inline-block">
            {{ $item->link }}
        </small>
        <span class="float-right">
            <button wire:click.prevent="$dispatch('edit-item', { menuItem: {{ $item->id }} })"
                class="w-7 h-7 font-semibold leading-tight text-gray-500 rounded-full dark:bg-gray-500 dark:text-green-100">
                <x-icon ref="pencil-alt" class="text-xs" />
            </button>

            <button wire:click.prevent="$dispatch('delete-item', { menuItem: {{ $item->id }} })"
                class="w-7 h-7 font-semibold leading-tight text-xs text-gray-500 rounded-full dark:bg-gray-500 dark:text-green-100">
                <x-icon ref="x-circle" class="text-xs" />
            </button>
        </span>
    </div>

    @if ($item->children->isNotEmpty())
        <ol wire:ignore class="nested-group dd-list pt-2">
            @foreach ($item->children as $child)
                @include('admin.cms.menu.builder-item', [
                    'item' => $child,
                ])
            @endforeach
        </ol>
    @endif
</li>
