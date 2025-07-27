<section>
        <div class="vs-carousel hero-layout1 style2" data-fade="true" data-dots="true">
            @foreach ($heroSection as $heroAsset)
            <div>
                <div class="hero-inner">
                    <div class="dark-overlay"></div>
                    <div class="hero-bg" data-bg-src="{{$heroAsset['image']}}"></div>
                    <div class="container">
                        <div class="hero-content">
                            <h1 class="hero-title animated">{{$heroAsset['title']}}</h1>
                            <p class="hero-text animated">{{$heroAsset['deskripsi']}}</p>
                            <div class="hero-btns animated">
                                <a href="{{$heroAsset['link']}}" class="vs-btn style5"><i class="far fa-angle-right"></i>{{$heroAsset['tombol_text']}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>