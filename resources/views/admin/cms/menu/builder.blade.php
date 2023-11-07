<x-slot name="pageTitle">
    {{ __('menu.index.title') }}
</x-slot>

<div class="grid grid-cols-12">
    <div class="col-span-12 space-y-4">
        <x-admin.components.card heading="Customizer">
            <div>
                <livewire:admin.cms.menu.menu-item-builder :menu="$menu" />
            </div>
            <hr class="my-5">
            <div>
                <livewire:admin.cms.menu.menu-builder :menu="$menu" />
            </div>
        </x-admin.components.card>
    </div>
</div>
