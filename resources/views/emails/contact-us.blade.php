@component('mail::message')
    # {{ __('global.email.contact-us') }}

    @foreach ($data as $key => $value)
        {{ Str::of($key)->replace('_', ' ')->title() }}: {{ $value }}
    @endforeach

    Thanks,
    {{ config('custom.site_title') }}
@endcomponent
