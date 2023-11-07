<form action="submit" method="POST" wire:submit.prevent="save">
    <div class="grid grid-cols-12">
        <div class="col-span-12 space-y-4">
            <x-admin.components.card heading="">
                <header>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        @lang($pageTitle)
                    </h3>
                </header>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.components.input.group label="{{ __('inputs.title') }}" for="title" :error="$errors->first('page.title')">
                        <x-admin.components.input.text wire:model="page.title" name="title" id="title"
                            :error="$errors->first('page.title')" />
                    </x-admin.components.input.group>

                    <x-admin.components.input.group label="{{ __('pages.form.inputs.slug') }}" for="slug"
                        :error="$errors->first('page.slug')">
                        <x-admin.components.input.text wire:model="page.slug" name="slug" id="slug"
                            :error="$errors->first('page.slug')" />
                    </x-admin.components.input.group>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin.components.input.group label="{{ __('pages.form.inputs.meta_title') }}" for="meta_title"
                        :error="$errors->first('page.meta_title')">
                        <x-admin.components.input.text wire:model="page.meta_title" name="meta_title" id="meta_title"
                            :error="$errors->first('page.meta_title')" />
                    </x-admin.components.input.group>
                    <x-admin.components.input.group label="{{ __('pages.form.inputs.meta_keywords') }}"
                        for="meta_keywords" :error="$errors->first('page.meta_keywords')">
                        <x-admin.components.input.text wire:model="page.meta_keywords" name="meta_keywords"
                            id="meta_keywords" :error="$errors->first('page.meta_keywords')" />
                    </x-admin.components.input.group>
                </div>

                <x-admin.components.input.group label="{{ __('pages.form.inputs.meta_description') }}"
                    for="meta_description" :error="$errors->first('page.meta_description')">
                    <x-admin.components.input.textarea wire:model="page.meta_description" name="meta_description"
                        id="meta_description" :error="$errors->first('page.meta_description')" />
                </x-admin.components.input.group>

                <x-admin.components.input.group label="{{ __('pages.form.inputs.raw_meta') }}" for="raw_meta"
                    :error="$errors->first('page.raw_meta')">
                    <x-admin.components.input.textarea wire:model="page.raw_meta" name="raw_meta" id="raw_meta"
                        :error="$errors->first('page.raw_meta')" />
                </x-admin.components.input.group>

            </x-admin.components.card>

            <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
                <div class="flex flex-row justify-end gap-x-2">
                    <x-admin.components.publish-dropdown wire:model="page.is_published" type="page" />
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span wire:loading.remove>
                            {{ __('global.save') }}
                        </span>
                        @include('admin.layouts.livewire.button-loading')
                    </button>
                </div>
            </div>

            @if ($page->exists && !$page->wasRecentlyCreated)
                <div class="bg-white border border-red-300 rounded shadow">
                    <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                        {{ __('inputs.danger_zone.title') }}
                    </header>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <strong>{{ __('pages.form.danger_zone.label') }}</strong>
                                <p class="text-xs text-gray-600">{{ __('pages.form.danger_zone.instructions') }}</p>
                            </div>
                            <div class="col-span-9 lg:col-span-4">
                                <x-admin.components.input.text wire:model.live="deleteConfirm" />
                            </div>
                            <div class="col-span-3 text-right lg:col-span-2">
                                <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete"
                                    type="button">{{ __('global.delete') }}</x-admin.components.button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>
