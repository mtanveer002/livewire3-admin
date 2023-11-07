<div class="flex">
    <aside class="z-20 w-64 hidden overflow-y-auto bg-white dark:bg-gray-800 md:block">
        <div class="flex flex-col h-full">
            <div class="py-4 text-gray-500 dark:text-gray-400 flex flex-col grow">
                <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                    {!! $appName !!}
                </a>
                <ul class="mt-6">
                    <x-admin.components.menu name="main" current="{{ request()->route()->getName() }}">
                        @foreach ($component->items as $item)
                            @can($item->permission)
                                @include('admin.components.menu-item')
                            @endcan
                        @endforeach
                    </x-admin.components.menu>
                </ul>
            </div>
            @include('admin.components.side-bar-profile')
        </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    
</div>
