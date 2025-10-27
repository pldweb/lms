@extends('layouts.landing')

@section('title', 'Prestasi Sekolah')
@section('description', 'Prestasi dan Penghargaan SMPN 20 Jakarta')
@section('keywords', 'prestasi sekolah, penghargaan, smpn 20, jakarta')

@section('content')
<!-- Prestasi Sekolah Content -->
<section class="prestasi-sekolah section-padding mt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="section-title text-center">
                    <h2>Prestasi Sekolah</h2>
                    <p class="text-muted">Prestasi dan penghargaan yang telah diraih oleh SMPN 20 Jakarta</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            @if($prestasis->count() > 0)
                @foreach($prestasis as $prestasi)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card prestasi-card h-100 shadow-sm">
                        @if($prestasi->gambar)
                        <img src="{{ asset('img/prestasi/' . $prestasi->gambar) }}" class="card-img-top" alt="{{ $prestasi->judul }}" style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('img/Logo-SMPN20.png') }}" class="card-img-top" alt="{{ $prestasi->judul }}" style="height: 200px; object-fit: contain; padding: 20px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $prestasi->judul }}</h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($prestasi->tanggal_publish)->format('d F Y') }}
                                <span class="ms-2"><i class="fas fa-eye me-1"></i> {{ number_format($prestasi->views) }}</span>
                            </p>
                            <p class="card-text">{{ Str::limit(strip_tags($prestasi->isi), 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ url('/prestasi-sekolah/' . $prestasi->slug) }}" class="btn btn-success btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Belum ada prestasi sekolah yang dipublikasikan.
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                {{ $prestasis->links() }}
            </div>
        </div>
    </div>
</section>

<style>
.section-padding {
    padding: 60px 0;
}

.section-title {
    margin-bottom: 40px;
}

.section-title h2 {
    position: relative;
    display: inline-block;
    padding-bottom: 15px;
    margin-bottom: 15px;
    font-weight: 700;
}

.section-title h2:before {
    content: '';
    position: absolute;
    width: 100px;
    height: 2px;
    background-color: #198754;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}

.prestasi-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.prestasi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.prestasi-card .card-title {
    font-weight: 600;
    font-size: 1.25rem;
}

.prestasi-card .card-footer {
    padding-top: 0;
}
</style>
@endsection