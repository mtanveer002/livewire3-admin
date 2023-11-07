<header class="header-wrap @yield('header_classes')">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar">
                    <a href="{{ route('homepage') }}" class="navbar-brand">
                        @if ($logo_full_svg = config('custom.logo_full_svg'))
                            {!! $logo_full_svg !!}
                        @else
                            <img src="/frontend/images/topdot-logo.jpeg" height="36px" class="img img-responsive w-48"
                                alt="logo">
                        @endif
                    </a>

                    <div class="navbar mob-nav">
                        <ul class="nav-menu">
                            @foreach (get_menu('header') as $item)
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ url($item->link) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                                </li>
                            @endforeach
                            <div class="header-btn d-flex align-items-center">
                                <a class="contact-btn" href="{{ route('page', 'contact-us') }}">contact us</a>
                            </div>
                        </ul>
                    </div>

                    <div class="hamburger">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
