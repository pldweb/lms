@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Header Section -->
<section class="detail-header py-4 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/galeri') }}">Galeri</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/galeri/' . $galeri->kategori->slug) }}">{{ $galeri->kategori->nama_kategori }}</a></li>
                <li class="breadcrumb-item active">{{ $galeri->judul }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Media Content -->
                <div class="media-content mb-4">
                    @if($galeri->tipe == 'foto' && $galeri->file_path)
                        <div class="photo-container position-relative">
                            <img src="{{ asset('img/galeri/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}" class="img-fluid rounded shadow-sm w-100" id="mainPhoto">
                            <button class="btn btn-primary position-absolute top-50 start-50 translate-middle" id="zoomButton" style="opacity: 0;">
                                <i class="ph ph-magnifying-glass-plus"></i> Zoom
                            </button>
                        </div>
                    @elseif($galeri->tipe == 'video' && $galeri->youtube_url)
                        <div class="video-container">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $galeri->youtube_id }}" title="{{ $galeri->judul }}" allowfullscreen class="rounded shadow-sm"></iframe>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Info -->
                <div class="content-info">
                    <h1 class="fw-bold mb-3">{{ $galeri->judul }}</h1>
                    
                    <div class="meta-info mb-4">
                        <div class="row g-3">
                            <div class="col-auto">
                                <span class="badge bg-{{ $galeri->tipe == 'foto' ? 'primary' : 'danger' }} px-3 py-2">
                                    <i class="ph ph-{{ $galeri->tipe == 'foto' ? 'image' : 'video' }}"></i> 
                                    {{ ucfirst($galeri->tipe) }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info px-3 py-2">
                                    <i class="ph ph-folder"></i> {{ $galeri->kategori->nama_kategori }}
                                </span>
                            </div>
                            @if($galeri->tanggal_foto)
                            <div class="col-auto">
                                <span class="text-muted">
                                    <i class="ph ph-calendar"></i> {{ $galeri->tanggal_foto->format('d F Y') }}
                                </span>
                            </div>
                            @endif
                            @if($galeri->fotografer)
                            <div class="col-auto">
                                <span class="text-muted">
                                    <i class="ph ph-camera"></i> {{ $galeri->fotografer }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($galeri->deskripsi)
                    <div class="description mb-4">
                        <h5>Deskripsi</h5>
                        <p class="text-muted">{{ $galeri->deskripsi }}</p>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="share-section">
                        <h6 class="mb-3">Bagikan:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="ph ph-facebook-logo"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($galeri->judul) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="ph ph-twitter-logo"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($galeri->judul . ' - ' . request()->fullUrl()) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="ph ph-whatsapp-logo"></i> WhatsApp
                            </a>
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ request()->fullUrl() }}')">
                                <i class="ph ph-copy"></i> Salin Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Related Gallery -->
                @if($galeriTerkait->count() > 0)
                <div class="related-gallery">
                    <h5 class="fw-bold mb-3">Galeri Terkait</h5>
                    <div class="row g-3">
                        @foreach($galeriTerkait as $item)
                        <div class="col-6">
                            <div class="related-item">
                                <a href="{{ url('/galeri/detail/' . $item->id) }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm">
                                        <div class="position-relative overflow-hidden" style="height: 120px;">
                                            @if($item->tipe == 'foto' && $item->file_path)
                                                <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                            @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                                <img src="{{ $item->youtube_thumbnail }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <i class="ph ph-play-circle text-white" style="font-size: 1.5rem; text-shadow: 0 0 5px rgba(0,0,0,0.8);"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title small fw-bold mb-1">{{ Str::limit($item->judul, 30) }}</h6>
                                            <small class="text-muted">
                                                <i class="ph ph-{{ $item->tipe == 'foto' ? 'image' : 'video' }}"></i> 
                                                {{ ucfirst($item->tipe) }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ url('/galeri/' . $galeri->kategori->slug) }}" class="btn btn-outline-primary btn-sm">
                            <i class="ph ph-arrow-right"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                @endif

                <!-- Category Info -->
                <div class="category-info mt-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Kategori: {{ $galeri->kategori->nama_kategori }}</h6>
                            @if($galeri->kategori->deskripsi)
                            <p class="text-muted small">{{ $galeri->kategori->deskripsi }}</p>
                            @endif
                            <a href="{{ url('/galeri/' . $galeri->kategori->slug) }}" class="btn btn-primary btn-sm w-100">
                                <i class="ph ph-folder-open"></i> Lihat Kategori
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Back to Gallery -->
                <div class="mt-4">
                    <a href="{{ url('/galeri') }}" class="btn btn-outline-secondary w-100">
                        <i class="ph ph-arrow-left"></i> Kembali ke Galeri
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white">{{ $galeri->judul }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <img src="{{ $galeri->tipe == 'foto' && $galeri->file_path ? asset('img/galeri/' . $galeri->file_path) : '' }}" alt="{{ $galeri->judul }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
.photo-container:hover #zoomButton {
    opacity: 1 !important;
    transition: opacity 0.3s ease;
}

.related-item:hover .card {
    transform: translateY(-3px);
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .meta-info .row {
        flex-direction: column;
    }
    
    .share-section .d-flex {
        flex-wrap: wrap;
    }
}
</style>

<script>
$(document).ready(function() {
    // Image zoom functionality
    $('#zoomButton, #mainPhoto').click(function() {
        $('#imageZoomModal').modal('show');
    });
    
    // Copy to clipboard function
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            if (typeof successAlert === 'function') {
                $('body').append(successAlert('Link berhasil disalin!'));
            } else {
                alert('Link berhasil disalin!');
            }
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            if (typeof successAlert === 'function') {
                $('body').append(successAlert('Link berhasil disalin!'));
            } else {
                alert('Link berhasil disalin!');
            }
        });
    };
});
</script>

@endsection
