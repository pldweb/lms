<section class="space-bottom">
    <div class="container">
        <div class="title-area text-center wow fadeInUp" data-wow-delay="0.3s">
            <div class="sec-icon">
                <img src="{{ asset('img/logo-SMPN20.png') }}" alt="">
            </div>
            <h2 class="sec-title">Informasi Unggulan</h2>
        </div>

        <div class="row vs-carousel wow fadeInUp" data-wow-delay="0.4s" 
             data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="4" 
             data-sm-slide-show="2" data-xs-slide-show="2" data-center-mode="false">

            @foreach(App\Helper\LandingKategori::setLandingKategori() as $info)
                <div class="col-6 col-lg-4 col-xl-3">
                    <div class="category-style1">
                        <div class="category-img">
                            <img class="w-100" src="{{$info['image']}}" alt="{{ $info['title'] }}">
                            <div class="icon">
                                <span class="{{ $info['icon'] }}"></span>
                            </div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-title">
                                <a href="{{ $info['link'] }}">{{ $info['title'] }}</a>
                            </h5>
                            <span class="subtitle">{{ $info['subtitle'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
