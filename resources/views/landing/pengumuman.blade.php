@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Page Header -->
<section class="page-header bg-info text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-4 mb-3">{{ $title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Pengumuman</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Pengumuman Content -->
<section class="blog-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-bullhorn me-2 text-info"></i>Semua Pengumuman</h3>
                    <div class="text-muted">
                        Menampilkan {{ $pengumuman->count() }} dari {{ $pengumuman->total() }} pengumuman
                    </div>
                </div>
                <hr>
            </div>
        </div>

        @if($pengumuman->count() > 0)
        <div class="row">
            @foreach($pengumuman as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card blog-card h-100 border-0 shadow-sm">
                    @if($item->gambar)
                    <div class="blog-img">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="blog-meta mb-3">
                            <span class="badge bg-info mb-2">Pengumuman</span>
                            <div class="text-muted small">
                                <i class="fas fa-user me-1"></i>{{ $item->penulis->nama }}
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-calendar me-1"></i>{{ $item->tanggal_publish->format('d F Y') }}
                                <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ number_format($item->views) }} views</span>
                            </div>
                        </div>
                        <h5 class="card-title">
                            <a href="{{ url('/artikel/' . $item->id) }}" class="text-decoration-none text-dark">
                                {{ $item->judul }}
                            </a>
                        </h5>
                        @if($item->ringkasan)
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($item->ringkasan, 120) }}
                        </p>
                        @else
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($item->isi), 120) }}
                        </p>
                        @endif
                        <div class="mt-auto">
                            <a href="{{ url('/artikel/' . $item->id) }}" class="btn btn-info btn-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    {{ $pengumuman->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Belum Ada Pengumuman</h3>
                    <p class="text-muted">Saat ini belum ada pengumuman yang tersedia. Silakan cek kembali nanti.</p>
                    <a href="{{ url('/') }}" class="btn btn-info">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<style>
.page-header {
    background: linear-gradient(135deg, var(--bs-info) 0%, #0aa4b3 100%);
}

.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.blog-card .card-title a:hover {
    color: var(--bs-info) !important;
}

.blog-meta .badge {
    font-size: 0.75em;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.7);
}
</style>

@endsection
