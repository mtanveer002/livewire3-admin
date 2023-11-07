<div class="grid grid-cols-4 gap-4">

    <x-admin.components.input.group label="{{ __('inputs.title') }}" for="menuItem.title" :error="$errors->first('menuItem.title')">
        <x-admin.components.input.text wire:model="menuItem.title" name="menuItem.title" id="menuItem.title"
            :error="$errors->first('menuItem.title')" />
    </x-admin.components.input.group>

    <x-admin.components.input.group label="{{ __('inputs.link') }}" for="menuItem.link" :error="$errors->first('menuItem.link')">
        <x-admin.components.input.text wire:model="menuItem.link" name="menuItem.link" id="menuItem.link"
            :error="$errors->first('menuItem.link')" />
    </x-admin.components.input.group>

    <x-admin.components.input.group label="{{ __('inputs.open_in') }}" for="menuItem.target" :error="$errors->first('menuItem.target')">
        <x-admin.components.input.select wire:model="menuItem.target" name="menuItem.target" :error="$errors->first('menuItem.target')">
            <option value="" selected>Same Tab</option>
            <option value="_blank">New Tab</option>
            </x-admin.components.select>
    </x-admin.components.input.group>

    <div class="text-right pt-5">
        <button type="button" wire:click="save"
            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span wire:loading.remove>
                {{ __('global.save') }}
            </span>
            @include('admin.layouts.livewire.button-loading')
        </button>
    </div>
</div>
