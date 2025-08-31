<section>
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach ($heroSection as $heroAsset)
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="dark-overlay"></div>
                        <div class="hero-bg" style="background-image: url('{{$heroAsset['image']}}');"></div>
                        <div class="container">
                            <div class="hero-content">
                                <h1 class="hero-title animated text-white">{{$heroAsset['title']}}</h1>
                                <p class="hero-text animated text-white">{{$heroAsset['deskripsi']}}</p>
                                {{-- <div class="hero-btns animated">
                                    <a href="{{$heroAsset['link']}}" class="vs-btn style5"><i class="far fa-angle-right"></i>{{$heroAsset['tombol_text']}}</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.hero-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    effect: 'slide',
                    direction: 'horizontal',
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    speed: 800,
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            });
        </script>
    </section>