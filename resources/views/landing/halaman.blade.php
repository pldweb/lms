@extends('layouts.landing')

@section('title', $halaman->judul)
@section('description', strip_tags(Str::limit($halaman->isi, 160)))
@section('keywords', $halaman->judul)
@section('og_image', $halaman->gambar ? asset('img/halaman/' . $halaman->gambar) : asset('img/Logo-SMPN20.png'))

@section('content')
<!-- Halaman Content -->
<section class="artikel-detail section-padding mt-4">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="artikel-content">
                    <!-- Artikel Meta -->
                    <div class="artikel-meta mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center justify-content-md-start">
                                    <span class="me-3 italic"><strong>Penulis:</strong> {{ $halaman->penulis->nama ?? 'Admin' }}</span>
                                    @if($halaman->tanggal_publish)
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    <span class="me-3">{{ \Carbon\Carbon::parse($halaman->tanggal_publish)->format('d F Y, H:i') }}</span>
                                    @endif
                                    <i class="fas fa-eye me-2 text-muted"></i>
                                    <span>{{ number_format($halaman->views) }} views</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Halaman -->
                    @if($halaman->gambar)
                    <div class="artikel-image mb-4">
                        <img src="{{ asset('img/halaman/' . $halaman->gambar) }}" alt="{{ $halaman->judul }}" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                    </div>
                    @endif

                    <!-- Isi Halaman -->
                    <div class="artikel-body">
                        <h2 class="mb-3">{{ $halaman->judul }}</h2>
                        <div class="halaman-content">
                            {!! $halaman->isi !!}
                        </div>
                    </div>
                </article>
            </div>
        
        <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Berita Terkait -->
                <div class="sidebar-widget">
                    <div class="widget-title">
                        <h5><i class="fas fa-newspaper me-2"></i>Berita Terkait</h5>
                    </div>
                    <div class="widget-content">
                        <div class="related-article mb-3 p-3 border rounded">
                            <div class="related-image mb-2">
                                <img src="{{ asset('img/artikel/default.jpg') }}" alt="Kunjungan Edukatif" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            <h6>
                                <a href="#" class="text-decoration-none text-dark">
                                    Kunjungan Edukatif ke Museum Nasional Indonesia
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>29 Aug 2025
                                <span class="ms-2"><i class="fas fa-eye me-1"></i>187</span>
                            </small>
                        </div>
                        <div class="related-article mb-3 p-3 border rounded">
                            <div class="related-image mb-2">
                                <img src="{{ asset('img/artikel/default.jpg') }}" alt="Workshop Literasi" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            <h6>
                                <a href="#" class="text-decoration-none text-dark">
                                    Workshop Literasi Digital untuk Guru SMP 20
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>27 Aug 2025
                                <span class="ms-2"><i class="fas fa-eye me-1"></i>159</span>
                            </small>
                        </div>
                        <div class="related-article mb-3 p-3 border rounded">
                            <div class="related-image mb-2">
                                <img src="{{ asset('img/artikel/default.jpg') }}" alt="Tim Basket" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            <h6>
                                <a href="#" class="text-decoration-none text-dark">
                                    Tim Basket SMP 20 Lolos ke Final Kompetisi Antar Sekolah
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>28 Aug 2025
                                <span class="ms-2"><i class="fas fa-eye me-1"></i>203</span>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="sidebar-widget">
                    <div class="widget-title">
                        <h5><i class="fas fa-compass me-2"></i>Navigasi</h5>
                    </div>
                    <div class="widget-content">
                        <div class="list-group">
                            <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-home me-2"></i>Beranda
                            </a>
                            <a href="{{ url('/berita') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-newspaper me-2"></i>Berita
                            </a>
                            <a href="{{ url('/pengumuman') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-bullhorn me-2"></i>Pengumuman
                            </a>
                            <a href="{{ url('/galeri') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>
                            <a href="{{ url('/kontak') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-phone-alt me-2"></i>Kontak
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Artikel Detail Styling */
.section-padding {
    padding: 60px 0;
}

.artikel-meta {
    background-color: #f8f9fa;
    border-radius: 5px;
}

.widget-title {
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.widget-title h5 {
    font-weight: 600;
    margin-bottom: 0;
}

.sidebar-widget {
    margin-bottom: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.related-article {
    transition: all 0.3s ease;
}

.related-article:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.related-image img {
    transition: all 0.3s ease;
}

.related-article:hover .related-image img {
    transform: scale(1.05);
}

/* Halaman Content Styling */
.halaman-content h2 {
    font-size: 1.75rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #0d6efd;
}

.halaman-content h3 {
    font-size: 1.5rem;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    color: #212529;
}

.halaman-content p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.halaman-content ul, .halaman-content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.halaman-content li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
}

.halaman-content blockquote {
    border-left: 4px solid #0d6efd;
    padding: 0.5rem 1rem;
    margin: 1.5rem 0;
    background-color: #f8f9fa;
    font-style: italic;
}

.halaman-content img {
    max-width: 100%;
    height: auto;
    margin: 1.5rem 0;
    border-radius: 0.25rem;
}

.halaman-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.halaman-content table th, .halaman-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.halaman-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection