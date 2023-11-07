<footer>
    <div class="footer-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-wrapper">

                        {{-- <livewire:frontend.newsletter.newsletter /> --}}
                        
                        <div class="footer-nav-list">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="footer-logo-wrap">
                                        <a href="{{ route('homepage') }}">
                                            <img src="/frontend/images/topdot-logo.jpeg" class="img img-fluid" alt="logo">
                                        </a>
                                        <div class="footer-social div-flex">
                                            @if (config('custom.facebook_url'))
                                                <a href="{{ config('custom.facebook_url') }}" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                            @endif
                                            @if (config('custom.pinterest_url'))
                                                <a href="{{ config('custom.pinterest_url') }}" target="_blank"><i class="fa fa-pinterest"></i></a>
                                            @endif
                                            @if (config('custom.twitter_url'))
                                                <a href="{{ config('custom.twitter_url') }}" target="_blank"><i class="fa fa-twitter"></i></a>
                                            @endif
                                            @if (config('custom.instagram_url'))
                                                <a href="{{ config('custom.instagram_url') }}" target="_blank"><i class="fa fa-instagram"></i></a>
                                            @endif
                                            @if (config('custom.youtube_url'))
                                                <a href="{{ config('custom.youtube_url') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-sm-4 col-6">
                                            <div class="footer-list-wrap">
                                                <h4>Navigation</h4>
                                                <ul>
                                                    @foreach (get_menu('navigation') as $item)
                                                        <li>
                                                            <a href="{{ url($item->link) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-7 mt-5 mt-sm-0">
                                            <div class="footer-list-wrap">
                                                <h4>{{ __('support') }}</h4>
                                                <p>{{ config('custom.address') }}</p>
                                                <p style="margin: 19px 0;">
                                                    <a href="tel:{{ config('custom.phone_number') }}">
                                                        <strong>{{ config('custom.phone_number') }}</strong>
                                                    </a>
                                                </p>
                                                <p><a href="mailto:{{ config('custom.information_email') }}">{{ config('custom.information_email') }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="copy-right-wrap">
                            <div class="copy-right text-center">
                                <p>
                                    © {{ date('Y') }}
                                    <strong class="text-uppercase">
                                        {{ config('custom.site_title') }}
                                    </strong>
                                    {{ config('custom.copyright_text') }} 
                                    <br class="d-block d-sm-none">
                                    @foreach (get_menu('footer') as $item)
                                        <span>|</span>
                                        <a href="{{ url($item->link) }}" target="{{ $item->target }}"> {{ $item->title }} </a>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
