<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">

        <!-- Responsif profile ketika mobile -->
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{asset('img/team/profile-picture-3.jpg')}}" class="card-img-top rounded-circle border-white" alt="Bonnie Green" />
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi, Jane</h2>
                    <a href="#" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                        <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Menu Sidebar -->
        <ul class="nav flex-column pt-3 pt-md-0">
{{--            <li class="nav-item">--}}
{{--                <a href="{{asset('/')}}" class="nav-link">--}}
{{--                    <img src="{{asset("img/logo-car-serv.png")}}" style="filter:brightness(0) invert(1); max-height: 20px" alt="Volt Logo">--}}
{{--                </a>--}}
{{--            </li>--}}

            @php use Illuminate\Support\Str; @endphp
            @foreach(\App\Helper\MenuSidebarHelper::generateMenuSidebar() as $data => $menu)
                @if(isset($menu['submenu']))
                    <li class="nav-item">
                        <span class="nav-link collapse d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenu-{{ Str::slug($data) }}">
                            <span>
                                <span class="sidebar-icon"><i class="{{$menu['icon']}}"></i></span>
                                <span class="sidebar-text">{{$data}}</span>
                            </span>
                            <span class="link-arrow"></span>
                        </span>
                        <div class="multi-level collapse" role="list" id="submenu-{{ Str::slug($data) }}" aria-expanded="true">
                            <ul class="flex-column nav">
                                @foreach($menu['submenu'] as $submenu => $detail)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{$detail['url']}}">
                                            <span class="sidebar-icon"><i class="{{$detail['icon']}}"></i></span>
                                            <span class="sidebar-text">{{$submenu}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{$menu['url']}}" class="nav-link">
                        <span class="sidebar-icon"><i class="{{$menu['icon']}}"></i></span>
                            <span class="sidebar-text">{{$data}}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
