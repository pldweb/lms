<section class="blog-area section-padding bg-white mt-12 mb-12" >
    <div class="container">

        {{-- Daftar Berita --}}
        <div class="row">
            <div class="col-md-12">
                <div class="title-area text-center wow fadeInUp" data-wow-delay="0.3s">
                    <img src="{{ asset('img/' . $informasi->favicon) }}" style="max-height: 50px; margin-bottom: 20px;" alt="">
                    <h2 class="sec-title">Berita Terbaru</h2>
                    <p class="sec-text">Daftar Berita di SMP Negeri 20 Jakarta Timur</p>
                </div>
            </div>
        </div>

        <div class="row">
            @if($beritaTerbaru->count() > 0)
                @foreach($beritaTerbaru as $berita)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="blog-card">
                        @if($berita->gambar)
                        <div class="blog-img">
                            <img src="{{ asset('img/artikel/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                            <div class="blog-date">
                                <span class="day">{{ $berita->tanggal_publish->format('d') }}</span>
                                <span class="month">{{ $berita->tanggal_publish->format('M') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> {{ $berita->penulis->nama }}</span>
                                <span><i class="fas fa-eye"></i> {{ number_format($berita->views) }}</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ url('/artikel/' . $berita->slug) }}">
                                    {{ Str::limit($berita->judul, 55) }}
                                </a>
                            </h3>
                            @if($berita->ringkasan)
                            <p class="blog-text">
                                {{ Str::limit($berita->ringkasan, 90) }}
                            </p>
                            @endif
                            <a href="{{ url('/artikel/' . $berita->slug) }}" class="read-more-btn">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada berita tersedia</h5>
                    </div>
                </div>
            @endif
        </div>

        {{-- Pengumuman --}}
        <div class="row mb-9">
            <div class="col-md-12">
                <div class="text-center wow fadeInUp" style="margin-top: 50px;" data-wow-delay="0.3s">
                    <h2 class="sec-title">Pengumuman Terbaru</h2>
                    <p class="sec-text">Daftar Pengumuman di SMP Negeri 20 Jakarta Timur</p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            @if($pengumumanTerbaru->count() > 0)
                @foreach($pengumumanTerbaru as $pengumuman)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="blog-card">
                        @if($pengumuman->gambar)
                        <div class="blog-img">
                            <img src="{{ asset('img/artikel/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}">
                            <div class="blog-date">
                                <span class="day">{{ $pengumuman->tanggal_publish->format('d') }}</span>
                                <span class="month">{{ $pengumuman->tanggal_publish->format('M') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> {{ $pengumuman->penulis->nama }}</span>
                                <span><i class="fas fa-eye"></i> {{ number_format($pengumuman->views) }}</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ url('/artikel/' . $pengumuman->slug) }}">
                                    {{ $pengumuman->judul }}
                                </a>
                            </h3>
                            @if($pengumuman->ringkasan)
                            <p class="blog-text">
                                {{ Str::limit($pengumuman->ringkasan, 100) }}
                            </p>
                            @endif
                            <a href="{{ url('/artikel/' . $pengumuman->id) }}" class="read-more-btn">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada pengumuman tersedia</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
