<!DOCTYPE html>
<html lang="en">

<head>
    <title> @yield('meta_title', $title ?? '') | {{ config('app.name') }} </title>
    <link rel="icon" sizes="57x57" href="/frontend/images/fav-icon.png">

    <meta charset="UTF-8">
    <meta name="author" content="Box Store">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=3.0">

    <meta name="description" content="@yield('description', $description ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', $keywords ?? '')">
    <meta property="og:title" content="@yield('meta_title')">
    <meta property="og:description" content=@yield('meta_description')>
    <meta property="og:image" content="@yield('image', '/frontend/images/logo.png')">
    <meta property="og:url" content="@yield('url', request()->url())">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="@yield('image', '/images/logo.png')">

    @include('frontend.layouts.css')
    @stack('page_css')
    @livewireStyles

</head>

<body>
    <div class="main-site">
        <!-- page-loader  -->
        @include('frontend.layouts.page-loader')
        <!-- page-loader  -->

        <!-- header  -->
        @include('frontend.layouts.header')
        <!-- header  -->

        <div class="clearfix"></div>

        <div class="inner-section">

            @yield('page')
            {{ $slot ?? '' }}
        </div>

        <div class="clearfix"></div>

        <x-notify-component />
        @include('frontend.layouts.footer')
    </div>
    @include('frontend.layouts.js')
    @livewireScripts
    @include('frontend.layouts.livewirejs')
    @include('frontend.layouts.toastr-events')
    @stack('page_js')
    
    <script>
        function initLightGallery(){
            $('.lightgallery').each(function(i, item) {
                $(item).lightGallery({
                    thumbnail: false,
                });
            });
        }

        jQuery(document).ready(initLightGallery);

        Livewire.hook('message.processed', function() {
            $('.phone_number, .mask_us_phone').trigger('input');
            $('.card_number, .mask_us_credit_card').trigger('input');

            initLightGallery();
        });

        jQuery(document).on('click', '.lg img', function(e){
            let src = $(this).attr('src');
            let url = $('#lightgallery, .lightgallery').find(`img[src="${src}"]`).data('url');

            if(url){
                window.open(url, '_blank').focus();
            }
        })

        $(document).on('DOMNodeInserted', function(e) {
            if ( $(e.target).is('.lg-outer .lg-item .lg-img-wrap') ) {
                let img = $(e.target).find('.lg-image');

                let src = img.attr('src');
                let url = $('#lightgallery, .lightgallery').find(`img[src="${src}"]`).data('url');

                if(url){
                    img.addClass('cursor-pointer')
                }
            }
        });
    </script>
</body>

</html>
