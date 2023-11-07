<div class="col-span-12 space-y-4">
    <x-admin.components.card heading="Create Menu">
        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.name') }}" for="name" :error="$errors->first('name')">
                <x-admin.components.input.text wire:model="name" name="name" id="name" :error="$errors->first('name')" />
            </x-admin.components.input.group>
        </div>
    </x-admin.components.card>

    <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
        <button
            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            wire:click="saved">
            {{ __('menu.form.create.btn') }}
        </button>
    </div>
</div>
