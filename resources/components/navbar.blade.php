<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0 mb-3">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">

            <!-- Ini untuk teks judul -->
            <div class="d-flex align-items-center">
                <h3 id="dashboard-title">Dashboard Administrasi</h3>
            </div>

            <div id="message"></div>

            <!-- Navbaar -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">

                    <!-- ini notifikasi -->
                    {{--                    <a class="nav-link text-dark notification-bell unread dropdown-toggle" data-unread-notifications="true" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">--}}
                    {{--                        <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>--}}
                    {{--                    </a>--}}
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
                        <div class="list-group list-group-flush">
                            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Notifications</a>
                            <a href="#" class="list-group-item list-group-item-action border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="{{asset('img/team/profile-picture-1.jpg')}}" class="avatar-md rounded">
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Jose Leos</h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-danger">a few moments ago</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">Added you to an event "Project stand-up" tomorrow at 12:30 AM.</p>
                                    </div>
                                </div>
                            </a>
                            <!-- Jika ada banyak notif -->
                            <a href="#" class="dropdown-item text-center fw-bold rounded-bottom py-3">View all</a>
                        </div>
                    </div>
                </li>

                <!-- Untuk dropdown menu profile -->
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="media d-flex align-items-center">
                            <img class="avatar rounded-circle" alt="Image placeholder" src="{{asset('img/team/profile-picture-3.jpg')}}">
                            <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                <span class="mb-0 font-small fw-bold text-gray-900">{{ Auth::user()->nama }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('admin/profile')}}">
                            My Profile
                        </a>
                        <div role="separator" class="dropdown-divider my-1"></div>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" id="post-logout">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    $('#post-logout').click(function(e){
        e.preventDefault();

        $.ajax({
            url: "/auth/logout/logout-action", // URL logout
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // CSRF Token
            },
            success: function (response) {
                $('#message').html(response);
                window.location.href = "/login"; // Redirect ke halaman login
            },
            error: function () {
                alert("Gagal logout!");
            }
        });
    })
</script>
