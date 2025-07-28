<aside class="sidebar">
    <button type="button" class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute">
        <i class="ph ph-x"></i>
    </button>

    <a href="{{ url('/') }}" class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
        <img src="{{ asset('img/Logo-SMPN20.png') }}" alt="Logo">
    </a>

    <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">
                @foreach (App\Helper\AdminSidebar::setSidebarMenu() as $item)
                    @if(isset($item['type']) && $item['type'] === 'label')
                        <li class="sidebar-menu__item">
                            <span class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">
                                {{ $item['text'] }}
                            </span>
                        </li>
                    @elseif(isset($item['submenu']))
                        <li class="sidebar-menu__item has-dropdown">
                            <a href="javascript:void(0)" class="sidebar-menu__link">
                                <span class="icon"><i class="{{ $item['icon'] }}"></i></span>
                                <span class="text">{{ $item['text'] }}</span>
                                @if(isset($item['badge']))
                                    <span class="link-badge">{{ $item['badge'] }}</span>
                                @endif
                            </a>
                            <ul class="sidebar-submenu">
                                @foreach ($item['submenu'] as $sub)
                                    <li class="sidebar-submenu__item">
                                        <a href="{{ url($sub['link']) }}" class="sidebar-submenu__link">{{ $sub['text'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="sidebar-menu__item">
                            <a href="{{ url($item['link']) }}" class="sidebar-menu__link">
                                <span class="icon"><i class="{{ $item['icon'] }}"></i></span>
                                <span class="text">{{ $item['text'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>
