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
                <p class="text-gray-600 text-15 mb-32">Reset Password Akun LMS</p>

                <form action="#">
                    <div class="mb-24">
                        <label for="email" class="form-label mb-8 h6">Email </label>
                        <div class="position-relative">
                            <input type="email" class="form-control py-11 ps-40" id="email" placeholder="Tuliskan Email Anda">
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-envelope"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-main rounded-pill w-100">Kirim Link Reset Password</button>
                    <a href="{{url('login')}}" class="my-32 text-main-600 flex-align gap-8 justify-content-center"> <i class="ph ph-arrow-left d-flex"></i> Kembali ke Halaman Login</a>
                </form>
            </div>
        </div>
    </section>
    
@endsection