@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Page Header -->
{{-- <section class="page-header bg-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }} text-white py-5">
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
</section> --}}

<!-- Artikel Content -->
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
                                    <span class="me-3 italic"><strong>Penulis:</strong> {{ $artikel->penulis->nama }}</span>
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

                    <!-- Isi Artikel -->
                    <div class="artikel-body">
                        <div class="content-text">
                            {!! $artikel->isi !!}
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="artikel-share mt-5 mb-5 p-3 pl-0 rounded">
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

.content-text h1, .content-text h2, .content-text h3, 
.content-text h4, .content-text h5, .content-text h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.content-text h1 { font-size: 2rem; }
.content-text h2 { font-size: 1.75rem; }
.content-text h3 { font-size: 1.5rem; }
.content-text h4 { font-size: 1.25rem; }
.content-text h5 { font-size: 1.1rem; }
.content-text h6 { font-size: 1rem; }

.content-text img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.content-text table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.content-text table th,
.content-text table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

.content-text table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.content-text blockquote {
    background: #f8f9fa;
    border-left: 4px solid var(--bs-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }});
    margin: 1.5rem 0;
    padding: 1rem;
    font-style: italic;
}

.content-text ul, .content-text ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.content-text li {
    margin-bottom: 0.5rem;
}

.content-text strong {
    font-weight: 600;
}

.content-text em {
    font-style: italic;
}

.content-text a {
    color: var(--bs-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }});
    text-decoration: none;
}

.content-text a:hover {
    text-decoration: underline;
}

.content-text hr {
    border: none;
    height: 2px;
    background: linear-gradient(to right, transparent, #ddd, transparent);
    margin: 2rem 0;
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
