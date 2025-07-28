<!--==============================
      Blog Area
  ==============================-->
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="title-area text-center wow fadeInUp" data-wow-delay="0.3s">
              
                <span class="sec-subtitle">Berita dan Pengumuman Terbaru</span>
                <h2 class="sec-title">Informasi Terupdate</h2>
            </div>
            <div class="row vs-carousel" data-slide-show="2" data-md-slide-show="2">
                @foreach (App\Helper\LandingArtikel::setArtikel() as $item)
                <div class="col-lg-6">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <img class="w-100" src="{{$item['image']}}" alt="Blog Img">
                        </div>
                        <div class="blog-content">
                            <div class="date-box">
                                <span class="day">{{$item['tanggal']}}</span>
                                <span class="month">{{$item['bulan']}} {{$item['tahun']}}</span>
                                {{-- <span class="post-comment">03 Comments</span> --}}
                            </div>
                            <h4 class="blog-title"><a href="blog-details.html">{{$item['title']}}</a></h4>
                            <p>{{$item['description']}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mb-30">
                <a href="{{url('berita')}}" class="vs-btn style3 mt-2"><i class="far fa-angle-right"></i>Berita Selengkapnya</a>
            </div>
        </div>
    </section>