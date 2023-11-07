<div class="w-full max-w-2xl mx-auto">

    <x-admin.components.card heading="{{ __('staff.profile.title') }}">
        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.firstname') }}" for="firstname" :error="$errors->first('staff.first_name')">
                <x-admin.components.input.text wire:model="staff.first_name" name="first_name" id="first_name"
                    :error="$errors->first('staff.first_name')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.lastname') }}" for="lastname" :error="$errors->first('staff.last_name')">
                <x-admin.components.input.text wire:model="staff.last_name" name="lastname" id="lastname"
                    :error="$errors->first('staff.last_name')" />
            </x-admin.components.input.group>
        </div>

        <x-admin.components.input.group label="{{ __('inputs.email') }}" for="email" :error="$errors->first('staff.email')">
            <x-admin.components.input.text wire:model="staff.email" type="email" name="email" id="email"
                :error="$errors->first('staff.email')" readonly />
        </x-admin.components.input.group>

        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.current_password') }}" for="currentPassword"
                :error="$errors->first('currentPassword')">
                <x-admin.components.input.text wire:model="currentPassword" type="password" name="currentPassword"
                    id="currentPassword" :error="$errors->first('currentPassword')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.new_password') }}" for="password" :error="$errors->first('password')">
                <x-admin.components.input.text wire:model="password" type="password" name="password" id="password"
                    :error="$errors->first('password')" />
            </x-admin.components.input.group>
        </div>
        <x-admin.components.input.group label="{{ __('staff.form.staff.profileImage') }}" for="profileImage"
            :error="$errors->first('profileImage')">
            <div x-data="{
                profileImage: @entangle('profileImage')
            }" x-show="!profileImage">
                <x-admin.components.input.fileupload wire:model="profileImage" :imagesHolder="null" :maxFiles="1"
                    label="<span class='plus text-gray-400'>+</span>" :multiple="false" />
            </div>

            @if ($profileImage)
                <div class="feature-upload relative flex-wrap d-flex flex-row rounded border p-2">
                    <div class="preview-img">
                        <img class="img-fluid d-block mx-auto h-[150px]" src="{{ $this->profileImagePreview }}"
                            alt="">
                    </div>
                    <button wire:loading.attr="disabled"
                        class="inline-flex absolute top-2 right-2 justify-center items-center w-6 h-6 text-xs opacity-80 font-bold text-white bg-gray-700 rounded-full cursor-pointer"
                        wire:click.prevent="$set('profileImage', null)">
                        x
                    </button>
                </div>
            @endif
        </x-admin.components.input.group>

    </x-admin.components.card>

    <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
        <button type="submit"
            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('staff.profile.btn') }}
        </button>
    </div>

</div>
