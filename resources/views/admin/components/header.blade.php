<div class="top-navbar flex-between gap-16">
            <div class="flex-align gap-16">
                <!-- Toggle Button Start -->
                <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500"><i class="ph ph-list"></i></button>
                <!-- Toggle Button End -->
                
                <form action="#" class="w-350 d-sm-block d-none">
                    <div class="position-relative">
                        <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none"><i class="ph ph-magnifying-glass"></i></button> 
                        <input type="text" class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15" placeholder="Search...">
                    </div>
                </form>
            </div>

            <div class="flex-align gap-16">
                <div class="flex-align gap-8">
                    <!-- Notification Start -->
                    <div class="dropdown">
                        <button class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="position-relative">
                                <i class="ph ph-bell"></i>
                                <span class="alarm-notify position-absolute end-0"></span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                            <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="py-8 px-24 bg-main-600">
                                        <div class="flex-between">
                                            <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                                            <div class="flex-align gap-12">
                                                <button type="button" class="bg-white rounded-6 text-sm px-8 py-2 hover-text-primary-600"> New </button>
                                                <button type="button" class="close-dropdown hover-scale-1 text-xl text-white"><i class="ph ph-x"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-24 max-h-270 overflow-y-auto scroll-sm">
                                            @foreach(App\Helper\AdminHeader::setHeaderNotification() as $notif)
                                            <div class="d-flex align-items-start gap-12 mb-24 border-bottom border-gray-100 pb-24">
                                                <img src="{{ $notif['avatar'] }}" alt="" class="w-48 h-48 rounded-circle object-fit-cover">
                                                <div>
                                                    <div class="flex-align gap-4">
                                                        <a href="#" class="fw-medium text-15 text-gray-300 hover-text-main-600 text-line-2">
                                                            {{ $notif['user'] }} {{ $notif['message'] }}
                                                        </a>
                                                    </div>
                                                    @if($notif['file'])
                                                    <div class="flex-align gap-6 mt-8">
                                                        <img src="{{ $notif['icon'] }}" alt="">
                                                        <div class="flex-align gap-4">
                                                            <p class="text-gray-900 text-sm text-line-1">{{ $notif['file'] }}</p>
                                                            <span class="text-xs text-gray-200 flex-shrink-0">{{ $notif['size'] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-16 flex-align gap-8">
                                                        <button type="button" class="btn btn-main py-8 text-15 fw-normal px-16">Accept</button>
                                                        <button type="button" class="btn btn-outline-gray py-8 text-15 fw-normal px-16">Decline</button>
                                                    </div>
                                                    @endif
                                                    <span class="text-gray-200 text-13 mt-8 d-block">{{ $notif['time'] }}</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    <a href="#" class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline"> View All </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notification Start -->
                </div>

                <!-- User Profile Start -->
                <div class="dropdown">
                    <button class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="position-relative">
                            <img src="{{Auth::user()->foto_profile ? Storage::url(Auth::user()->foto_profile) : asset('admin/images/thumbs/avatar-img1.png')}}" alt="Image" class="h-32 w-32 rounded-circle">
                            <span class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                            <div class="card-body">
                                <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                    <img src="{{Auth::user()->foto_profile ? Storage::url(Auth::user()->foto_profile) : asset('admin/images/thumbs/avatar-img1.png')}}" alt="" class="w-54 h-54 rounded-circle">
                                    <div class="">
                                        <h4 class="mb-0">{{Auth::user()->nama}}</h4>
                                        <p class="fw-medium text-13 text-gray-200">{{ Auth::user()->email }}</p>
                                        <p class="fw-medium text-13 text-gray-200">Peran : {{ Auth::user()->roles->first()->name }}</p>
                                    </div>
                                </div>
                                <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                    @foreach (App\Helper\AdminHeader::setHeaderMenu() as $menu)
                                        <li class="mb-4 {{ $loop->last ? '' : '' }} {{ $menu['class'] ?? '' }}">
                                            <a href="{{ $menu['url'] }}" 
                                            class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15 {{ Str::contains($menu['class'], 'text-danger') ? 'hover-bg-danger-50 hover-text-danger-600' : '' }}">
                                                <span class="text-2xl {{ Str::contains($menu['class'], 'text-danger') ? 'text-danger-600' : 'text-primary-600' }} d-flex">
                                                    <i class="{{ $menu['icon'] }}"></i>
                                                </span>
                                                <span class="text">{{ $menu['text'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                        <li class="mb-4">
                                            <a href="javascript:void(0);" id="post-logout" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                                <span class="text-2xl text-danger-600 d-flex">
                                                    <i class="ph ph-sign-out"></i>
                                                </span>
                                                <span class="text">Logout</span>
                                            </a>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Start -->
            </div>
        </div>

        <script>
            $('#post-logout').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: "/auth/logout/logout-action", 
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // CSRF Token
                    },
                    success: function (response) {
                        $('#message').html(response);
                        window.location.href = "/login";
                    },
                    error: function () {
                        alert("Gagal logout!");
                    }
                });
            })
        </script>