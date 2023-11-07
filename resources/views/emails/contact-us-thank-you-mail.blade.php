@component('mail::message')
    # {{ __('global.email.contact-us-thank-you') }}

    {{ __('frontend/contact-us.success.message') }}

    Thanks,
    {{ config('custom.site_title') }}
@endcomponent
