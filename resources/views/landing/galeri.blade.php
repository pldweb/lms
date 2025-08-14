@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-3">Galeri Sekolah</h1>
                    <p class="lead mb-4">Dokumentasi kegiatan dan momen berharga di SMP 20 Jakarta</p>
                    <div class="hero-stats d-flex gap-4">
                        <div class="stat-item">
                            <h3 class="fw-bold mb-1">{{ $kategori->count() }}</h3>
                            <p class="mb-0">Kategori</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="fw-bold mb-1">{{ $kategori->sum('galeri_aktif_count') }}</h3>
                            <p class="mb-0">Total Item</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @if($galeriTerbaru->count() > 0)
                <div class="hero-gallery">
                    <div class="row g-2">
                        @foreach($galeriTerbaru->take(4) as $index => $item)
                        <div class="col-6">
                            <div class="gallery-item position-relative overflow-hidden rounded-3" style="height: {{ $index < 2 ? '200px' : '150px' }};">
                                @if($item->tipe == 'foto' && $item->file_path)
                                    <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                    <img src="{{ $item->youtube_thumbnail }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="ph ph-play-circle text-white" style="font-size: 3rem; text-shadow: 0 0 10px rgba(0,0,0,0.5);"></i>
                                    </div>
                                @endif
                                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-20"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Kategori Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title fw-bold">Kategori Galeri</h2>
                    <p class="text-muted">Jelajahi koleksi foto dan video berdasarkan kategori</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($kategori as $kat)
            <div class="col-lg-4 col-md-6">
                <div class="category-card h-100">
                    <a href="{{ url('/galeri/' . $kat->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden">
                            <div class="position-relative" style="height: 250px;">
                                @if($kat->gambar_cover)
                                    <img src="{{ asset('img/galeri/kategori/' . $kat->gambar_cover) }}" alt="{{ $kat->nama_kategori }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="ph ph-images text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-30"></div>
                                <div class="category-info position-absolute bottom-0 start-0 w-100 p-3 text-white">
                                    <h5 class="fw-bold mb-1">{{ $kat->nama_kategori }}</h5>
                                    <p class="mb-0 small">{{ $kat->galeri_aktif_count }} item</p>
                                </div>
                            </div>
                            @if($kat->deskripsi)
                            <div class="card-body">
                                <p class="text-muted mb-0">{{ Str::limit($kat->deskripsi, 100) }}</p>
                            </div>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Galeri Terbaru Section -->
@if($galeriTerbaru->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title fw-bold">Galeri Terbaru</h2>
                    <p class="text-muted">Foto dan video terbaru dari kegiatan sekolah</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($galeriTerbaru as $item)
            <div class="col-lg-4 col-md-6">
                <div class="gallery-item-card">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            @if($item->tipe == 'foto' && $item->file_path)
                                <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                <a href="{{ url('/galeri/detail/' . $item->id) }}" class="stretched-link"></a>
                            @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                <img src="{{ $item->youtube_thumbnail }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <i class="ph ph-play-circle text-white" style="font-size: 3rem; text-shadow: 0 0 10px rgba(0,0,0,0.5);"></i>
                                </div>
                                <a href="{{ url('/galeri/detail/' . $item->id) }}" class="stretched-link"></a>
                            @endif
                            <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-20"></div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">{{ $item->judul }}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">{{ $item->kategori->nama_kategori }}</span>
                                <small class="text-muted">
                                    @if($item->tipe == 'foto')
                                        <i class="ph ph-image"></i> Foto
                                    @else
                                        <i class="ph ph-video"></i> Video
                                    @endif
                                </small>
                            </div>
                            @if($item->tanggal_foto)
                            <small class="text-muted d-block mt-2">
                                <i class="ph ph-calendar"></i> {{ $item->tanggal_foto->format('d M Y') }}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-primary btn-lg">
                <i class="ph ph-arrow-down"></i> Lihat Semua Galeri
            </a>
        </div>
    </div>
</section>
@endif

<style>
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="25" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
}

.gallery-item:hover .overlay {
    background-color: rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease;
}

.category-card:hover .card {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.gallery-item-card:hover .card {
    transform: translateY(-3px);
    transition: all 0.3s ease;
}

.section-title {
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 50px 0;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        justify-content: center;
    }
}
</style>

@endsection
