<!--============================== Mobile Menu ============================== -->
    <div class="vs-menu-wrapper">
        <div class="vs-menu-area text-center">
            <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="index.html"><img src="{{asset('landing/img/logo.svg')}}" alt="Educino"></a>
            </div>
            <div class="vs-mobile-menu">
                <ul>
                    @foreach (App\Helper\LandingMenu::setLandingMenu() as $menu)
                        <li class="{{ isset($menu['children']) ? 'menu-item-has-children' : '' }}">
                            <a href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                            @if (isset($menu['children']))
                                <ul class="sub-menu">
                                    @foreach ($menu['children'] as $child)
                                        <li><a href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <header class="vs-header header-layout2">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-between align-items-center gx-50">
                    <div class="col d-none d-xl-block">
                        <div class="header-links">
                            <ul>
                                @foreach (App\Helper\LandingMenu::setContactMenu() as $item)
                                    <li><i class="{{$item['icon']}}"></i><a href="{{$item['link']}}">{{$item['text']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a class="user-login" href="{{url('login')}}"><i class="fas fa-user-circle"></i> Login LMS</a>
                    </div>
                    <div class="col-auto">
                        <div class="header-social">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="sticky-active">
                <div class="container position-relative z-index-common">
                    <div class="row gx-50 align-items-center justify-content-between master-menu">
                        <div class="col-auto col-xl align-self-stretch">
                            <div class="vs-logo style2">
                                <a href="index.html"><img src="{{asset('img/logo-SMPN20.png')}}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu menu-style3 d-none d-lg-block">
                                <ul>
                                    @foreach (App\Helper\LandingMenu::setLandingMenu() as $menu)
                                        <li class="{{ isset($menu['children']) ? 'menu-item-has-children' : '' }}">
                                            <a href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                                            @if (isset($menu['children']))
                                                <ul class="sub-menu">
                                                    @foreach ($menu['children'] as $child)
                                                        <li><a href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                            <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-btns style2">
                                <button type="button" class="searchBoxTggler"><i class="far fa-search"></i></button>
                                <a href="find-program.html" class="vs-btn style6"><i class="fal fa-graduation-cap"></i>Tentang Kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>