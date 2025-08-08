@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Page Header -->
<section class="page-header bg-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }} text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="badge bg-light text-dark mb-3 fs-6">{{ ucfirst($artikel->jenis) }}</span>
                <h1 class="display-5 mb-3">{{ $artikel->judul }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/' . $artikel->jenis) }}" class="text-white">{{ ucfirst($artikel->jenis) }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Artikel Content -->
<section class="artikel-detail section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="artikel-content">
                    <!-- Artikel Meta -->
                    <div class="artikel-meta mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    <span class="me-3"><strong>Penulis:</strong> {{ $artikel->penulis->nama }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    <span class="me-3">{{ $artikel->tanggal_publish->format('d F Y, H:i') }}</span>
                                    <i class="fas fa-eye me-2 text-muted"></i>
                                    <span>{{ number_format($artikel->views) }} views</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Artikel -->
                    @if($artikel->gambar)
                    <div class="artikel-image mb-4">
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                    </div>
                    @endif

                    <!-- Ringkasan -->
                    @if($artikel->ringkasan)
                    <div class="artikel-ringkasan mb-4">
                        <div class="alert alert-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }} alert-dismissible" role="alert">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Ringkasan</h6>
                            <p class="mb-0">{{ $artikel->ringkasan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Isi Artikel -->
                    <div class="artikel-body">
                        <div class="content-text">
                            {!! nl2br(e($artikel->isi)) !!}
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="artikel-share mt-5 p-3 bg-light rounded">
                        <h6 class="mb-3"><i class="fas fa-share-alt me-2"></i>Bagikan Artikel</h6>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-primary btn-sm me-2">
                                <i class="fab fa-facebook-f me-1"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($artikel->judul) }}" target="_blank" class="btn btn-info btn-sm me-2">
                                <i class="fab fa-twitter me-1"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . request()->fullUrl()) }}" target="_blank" class="btn btn-success btn-sm me-2">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                            </a>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="copyUrl()">
                                <i class="fas fa-copy me-1"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Artikel Terkait -->
                @if($artikelTerkait->count() > 0)
                <div class="sidebar-widget">
                    <div class="widget-title">
                        <h5><i class="fas fa-{{ $artikel->jenis == 'berita' ? 'newspaper' : 'bullhorn' }} me-2"></i>{{ ucfirst($artikel->jenis) }} Terkait</h5>
                    </div>
                    <div class="widget-content">
                        @foreach($artikelTerkait as $terkait)
                        <div class="related-article mb-3 p-3 border rounded">
                            @if($terkait->gambar)
                            <div class="related-image mb-2">
                                <img src="{{ asset('storage/' . $terkait->gambar) }}" alt="{{ $terkait->judul }}" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                            </div>
                            @endif
                            <h6>
                                <a href="{{ url('/artikel/' . $terkait->id) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($terkait->judul, 60) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $terkait->tanggal_publish->format('d M Y') }}
                                <span class="ms-2"><i class="fas fa-eye me-1"></i>{{ number_format($terkait->views) }}</span>
                            </small>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

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
                                <i class="fas fa-newspaper me-2"></i>Semua Berita
                            </a>
                            <a href="{{ url('/pengumuman') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-bullhorn me-2"></i>Semua Pengumuman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.page-header {
    background: linear-gradient(135deg, var(--bs-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }}) 0%, {{ $artikel->jenis == 'berita' ? '#0056b3' : '#0aa4b3' }} 100%);
}

.content-text {
    font-size: 16px;
    line-height: 1.8;
    text-align: justify;
}

.content-text p {
    margin-bottom: 1.2rem;
}

.sidebar-widget {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
    border: 1px solid #e9ecef;
}

.widget-title h5 {
    color: #495057;
    border-bottom: 2px solid var(--bs-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }});
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.related-article:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.share-buttons .btn {
    border-radius: 20px;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.7);
}

.artikel-meta {
    border-left: 4px solid var(--bs-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }});
}
</style>

<script>
function copyUrl() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link berhasil disalin ke clipboard!');
    }).catch(function() {
        // Fallback untuk browser yang tidak support clipboard API
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Link berhasil disalin ke clipboard!');
    });
}
</script>

@endsection
