<!-- This example requires Tailwind CSS v2.0+ -->
<div @class([
    'rounded-md p-4',
    'bg-blue-50' => !$level,
    'bg-yellow-50' => $level == 'warning',
    'bg-red-50' => $level == 'danger',
])>
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div @class([
                'text-yellow-400' => $level == 'warning',
                'text-red-500' => $level == 'danger',
                'text-blue-500' => !$level,
            ])>
                @switch($level)
                    @case('danger')
                        <x-icon ref="exclamation-circle"></x-icon>
                    @break

                    @default
                        <x-icon ref="information-circle"></x-icon>
                @endswitch
            </div>
        </div>
        <div class="flex-1 ml-3 md:flex md:justify-between">
            <p @class([
                'text-sm',
                'text-yellow-700' => $level == 'warning',
                'text-red-700' => $level == 'danger',
                'text-blue-700' => !$level,
            ])>
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
