@extends('layouts.auth')
@section('content')

    
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <div class="side-overlay"></div>

    <section class="auth d-flex">
        <div class="auth-left bg-main-50 flex-center p-24">
            {{-- <img src="{{asset('admin/images/thumbs/auth-img1.png')}}" alt=""> --}}
        </div>
        <div class="auth-right py-40 px-24 flex-center flex-column">
            <div class="auth-right__inner mx-auto w-100">
                <a href="{{url('/')}}" class="auth-right__logo">
                    <img src="{{asset('img/Logo-SMPN20.png')}}" style="max-height: 70px" alt="">
                </a>
                <h2 class="mb-8">Selamat Datang di LMS SMPN 20 Jakarta &#128075;</h2>
                <p class="text-gray-600 text-15 mb-32">Login dengan akun Anda</p>

                <form action="#">
                    <div class="mb-24">
                        <label for="fname" class="form-label mb-8 h6">Email</label>
                        <div class="position-relative">
                            <input type="email" class="form-control py-11 ps-40" id="fname" placeholder="Tuliskan email Anda">
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-user"></i></span>
                        </div>
                    </div>
                    <div class="mb-24">
                        <label for="current-password" class="form-label mb-8 h6">Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-11 ps-40" id="current-password" placeholder="Tuliskan Password Anda" value="">
                            <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash" id="#current-password"></span>
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-lock"></i></span>
                        </div>
                    </div>
                    <div class="mb-32 flex-between flex-wrap gap-8">
                        <div class="form-check mb-0 flex-shrink-0">
                            <input class="form-check-input flex-shrink-0 rounded-4" type="checkbox" value="" id="remember">
                            <label class="form-check-label text-15 flex-grow-1" for="remember">Ingat Saya </label>
                        </div>
                        <a href="{{url('reset-password')}}" class="text-main-600 hover-text-decoration-underline text-15 fw-medium">Lupa Password?</a>
                    </div>
                    <button type="submit" class="btn btn-main rounded-pill w-100">Log In</button>
                    <p class="mt-32 text-gray-600 text-center">Tidak punya akun?
                        <a href="{{url('register')}}" class="text-main-600 hover-text-decoration-underline">Buat Akun Baru</a>
                    </p>

                    {{-- <div class="divider my-32 position-relative text-center">
                        <span class="divider__text text-gray-600 text-13 fw-medium px-26 bg-white">or</span>
                    </div> --}}
                </form>
            </div>
        </div>
    </section>
    
@endsection