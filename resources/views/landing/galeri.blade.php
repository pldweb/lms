@extends('layouts.landing')
@section('title', $title)
@section('description', 'Galeri foto dan video kegiatan SMP Negeri 20 Jakarta, menampilkan berbagai aktivitas sekolah, prestasi siswa, dan fasilitas sekolah.')
@section('keywords', 'Galeri, Foto, Video, Kegiatan Sekolah, Prestasi Siswa, SMP Negeri 20 Jakarta')
@section('og_image', asset('img/' . ($informasiSekolah->logo ?? 'Logo-SMPN20.png')))
@section('content')

<!-- Kategori Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title fw-bold">Galeri Dokumentasi</h2>
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
