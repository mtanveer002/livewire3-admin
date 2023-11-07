<x-slot name="pageTitle">
    {{ __('settings.settings.title') }}
</x-slot>
<form action="submit" method="POST" wire:submit.prevent="update">
    <div class="flex flex-col">
        @include('admin.system.settings.settings-form')
    </div>
</form>