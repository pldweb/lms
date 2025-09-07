@extends('layouts.landing')
@section('title', $title)
@section('description', 'Berita dan informasi terbaru dari SMP Negeri 20 Jakarta. Temukan artikel tentang kegiatan sekolah, prestasi siswa, dan pengumuman penting.')
@section('keywords', 'Berita Sekolah, Artikel, Pengumuman, Kegiatan Sekolah, SMP Negeri 20 Jakarta')
@section('og_image', asset('img/' . ($informasiSekolah->logo ?? 'Logo-SMPN20.png')))
@section('content')

<!-- Berita Content -->
<section class="blog-area section-padding mt-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Semua Berita</h3>
                    <div class="text-muted">
                        Menampilkan {{ $berita->count() }} dari {{ $berita->total() }} berita
                    </div>
                </div>
                <hr>
            </div>
        </div>

        @if($berita->count() > 0)
        <div class="row">
            @foreach($berita as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                    <div class="blog-card">
                        @if($item->gambar)
                        <div class="blog-img">
                            <img src="{{ asset('img/artikel/' . $item->gambar) }}" alt="{{ $item->judul }}">
                            <div class="blog-date">
                                <span class="day">{{ $item->tanggal_publish->format('d') }}</span>
                                <span class="month">{{ $item->tanggal_publish->format('M') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> {{ $item->penulis->nama }}</span>
                                <span><i class="fas fa-eye"></i> {{ number_format($item->views) }}</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ url('/artikel/' . $item->slug) }}">
                                    {{ Str::limit($item->judul, 55) }}
                                </a>
                            </h3>
                            @if($item->ringkasan)
                            <p class="blog-text">
                                {{ Str::limit($item->ringkasan, 90) }}
                            </p>
                            @endif
                            <a href="{{ url('/artikel/' . $item->slug) }}" class="read-more-btn">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    {{ $berita->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Belum Ada Berita</h3>
                    <p class="text-muted">Saat ini belum ada berita yang tersedia. Silakan cek kembali nanti.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
