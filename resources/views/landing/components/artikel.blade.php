<!--============================== Berita & Pengumuman ==============================-->
<section class="blog-area section-padding bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center">
                    <h2 class="title text-capitalize mb-3">Berita & Pengumuman Terbaru</h2>
                    <p class="section-subtitle">Informasi terkini seputar kegiatan dan pengumuman sekolah</p>
                </div>
            </div>
        </div>

        <!-- Berita Terbaru -->
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-primary"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h4>
                    <a href="{{ url('/berita') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Berita</a>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            @if($beritaTerbaru->count() > 0)
                @foreach($beritaTerbaru as $berita)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card blog-card h-100 border-0 shadow-sm">
                        @if($berita->gambar)
                        <div class="blog-img">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="blog-meta mb-2">
                                <span class="badge bg-primary mb-2">Berita</span>
                                <div class="text-muted small">
                                    <i class="fas fa-calendar me-1"></i>{{ $berita->tanggal_publish->format('d M Y') }}
                                    <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ number_format($berita->views) }} views</span>
                                </div>
                            </div>
                            <h5 class="card-title">
                                <a href="{{ url('/artikel/' . $berita->id) }}" class="text-decoration-none text-dark">
                                    {{ $berita->judul }}
                                </a>
                            </h5>
                            @if($berita->ringkasan)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($berita->ringkasan, 100) }}
                            </p>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ url('/artikel/' . $berita->id) }}" class="btn btn-primary btn-sm">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
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

        <!-- Pengumuman Terbaru -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-info"><i class="fas fa-bullhorn me-2"></i>Pengumuman Terbaru</h4>
                    <a href="{{ url('/pengumuman') }}" class="btn btn-outline-info btn-sm">Lihat Semua Pengumuman</a>
                </div>
            </div>
        </div>

        <div class="row">
            @if($pengumumanTerbaru->count() > 0)
                @foreach($pengumumanTerbaru as $pengumuman)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card blog-card h-100 border-0 shadow-sm">
                        @if($pengumuman->gambar)
                        <div class="blog-img">
                            <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="blog-meta mb-2">
                                <span class="badge bg-info mb-2">Pengumuman</span>
                                <div class="text-muted small">
                                    <i class="fas fa-calendar me-1"></i>{{ $pengumuman->tanggal_publish->format('d M Y') }}
                                    <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ number_format($pengumuman->views) }} views</span>
                                </div>
                            </div>
                            <h5 class="card-title">
                                <a href="{{ url('/artikel/' . $pengumuman->id) }}" class="text-decoration-none text-dark">
                                    {{ $pengumuman->judul }}
                                </a>
                            </h5>
                            @if($pengumuman->ringkasan)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($pengumuman->ringkasan, 100) }}
                            </p>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ url('/artikel/' . $pengumuman->id) }}" class="btn btn-info btn-sm">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
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

<style>
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.blog-card .card-title a:hover {
    color: var(--bs-primary) !important;
}

.blog-meta .badge {
    font-size: 0.75em;
}
</style>
