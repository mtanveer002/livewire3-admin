<x-slot name="pageTitle">
    {{ __('pages.index.title') }}
</x-slot>
<div x-data="{
    copyText(text){
        navigator.clipboard.writeText(text);
        this.$dispatch('notify', {message: 'Copied.', level: 'success'})
    }
}">
    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.cms.pages.create') }}" wire:navigate>
            {{ __('pages.index.action.create') }}
        </x-admin.components.button>
    </div>

    <div
        class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('pages.index.search.placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" autocomplete="off">
                            {{ __('global.show_deleted') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>

        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>{{ __('global.title') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.slug') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.published') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.deleted') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.actions') }}</x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($this->pages as $page)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $page->title }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell class="whitespace-nowrap">
                            <span class="align-super">
                                {{ $page->slug }}
                            </span>
                            <button 
                                title="Copy Link"
                                @click="copyText('{{ $page->slug }}')"
                                class="w-7 h-7 font-semibold leading-tight text-xs text-gray-500 p-1 dark:bg-gray-500 dark:text-green-100">
                                <x-icon ref="document-duplicate" class="text-xs" />
                            </button>
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $page->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="$page->is_published && !$page->deleted_at ? 'check' : 'x'" :class="$page->is_published && !$page->deleted_at
                                ? 'text-green-500'
                                : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            <x-icon :ref="$page->deleted_at ? 'check' : 'x'" :class="$page->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>

                        <x-admin.components.table.cell>
                            @if (!$page->deleted_at)
                                <a href="{{ route('admin.cms.pages.show', $page->id) }}" wire:navigate
                                    class="text-indigo-500 hover:underline">
                                    {{ __('pages.index.action.edit') }}
                                </a>
                                |
                                <a class="text-indigo-500 hover:underline"
                                    href="{{ route('admin.cms.pages.editor', $page) }}" target="_blank">
                                    {{ __('global.editor') }}
                                </a>
                               
                            @endif
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
        </x-admin.components.table>

        @if($this->pages->hasPages())
            <div class="p-4 space-y-4">
                {{ $this->pages->links() }}
            </div>
        @endif
    </div>
</div>
