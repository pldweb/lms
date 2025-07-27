@extends('layouts.landing')
@section('title', $title)
@section('content')
    
    <!--============================== Hero Area ==============================-->
    @include('landing.components.hero')

    <!--============================== About Area ==============================-->
    @include('landing.components.about')
    
    <!--============================== Category Area ==============================-->
    <section class="space-bottom">
        <div class="container">
            <div class="title-area text-center wow fadeInUp" data-wow-delay="0.3s">
                <div class="sec-icon">
                    <img src="{{asset('img/logo-SMPN20.png')}}" alt="">
                </div>
                <h2 class="sec-title">Topics by Category</h2>
            </div>
            <div class="row vs-carousel wow fadeInUp" data-wow-delay="0.4s" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="2" data-xs-slide-show="2" data-center-mode="true">
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{asset('landing/img/category/category-2-1.png')}}" alt="category">
                            <div class="icon">
                                <span class="far fa-layer-group"></span>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title"><a href="course.html">Software Development</a></h5>
                            <span class="subtitle">over 600 courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{asset('landing/img/category/category-2-2.png')}}" alt="">
                            <div class="icon">
                                <span class="fas fa-briefcase-medical"></span>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title"><a href="course.html">Medical Health</a></h5>
                            <span class="subtitle">over 450 courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{asset('landing/img/category/category-2-3.png')}}" alt="category">
                            <div class="icon">
                                <span class="far fa-microchip"></span>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title"><a href="course.html">Technology</a></h5>
                            <span class="subtitle">over 336 courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{asset('landing/img/category/category-2-4.png')}}" alt="category">
                            <div class="icon">
                                <span class="fas fa-flask"></span>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title"><a href="course.html">Chemistry</a></h5>
                            <span class="subtitle">over 778 courses</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{asset('landing/img/category/category-2-6.png')}}" alt="category">
                            <div class="icon">
                                <i class="fal fa-globe-europe"></i>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title"><a href="course.html">Earth History</a></h5>
                            <span class="subtitle">over 115 courses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div data-bg-src="{{asset('landing/img/bg/course-bg-pattern.jpg')}}">
    <!--============================== CTA Area ==============================-->
        <section class="space-top space-bottom">
            <div class="container">
                <div class="cta-style2">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="cta-content">
                                <p class="cta-text">Youtube SMPN 20 Jakarta</p>
                                <h3 class="cta-title h3">MODIS (Model Displin) : Dari Kantin menuju Integritas</h2>
                                <a href="team.html" class="vs-btn">Sekolah Anti Korupsi</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="cta-img">
                                <img src="{{asset('landing/img/play-youtube.png')}}" alt="About Img">
                                <a href="https://www.youtube.com/watch?v=hpP6f7Ve3O8" class="play-btn popup-video position-center"><i class="fas fa-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    </div>

    @include('landing.components.blog')
    
@endsection