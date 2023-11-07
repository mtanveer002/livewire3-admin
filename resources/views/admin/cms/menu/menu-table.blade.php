<div class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg mt-5">

    <x-admin.components.table class="w-full whitespace-no-wrap p-2">
        <x-slot name="head">
            <x-admin.components.table.heading>{{ __('menu.name') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading></x-admin.components.table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($menus as $menu)
                <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                    <x-admin.components.table.cell>{{ ucfirst($menu->name) }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $menu->created_at->format('m/d/Y') }}
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        @if (!$menu->deleted_at)
                            <a href="{{ route('admin.cms.menu.builder', $menu) }}" wire:navigate class="text-gray-500 mr-2">
                                {{ __('menu.index.action.customizer') }}
                            </a>
                        @endif
                    </x-admin.components.table.cell>
                </x-admin.components.table.row>
            @empty
                <x-admin.components.table.no-results />
            @endforelse
        </x-slot>
    </x-admin.components.table>
    <div>
        {{ $menus->links() }}
    </div>
</div>
