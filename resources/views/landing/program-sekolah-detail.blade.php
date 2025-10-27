@extends('layouts.landing')

@section('title', $program->judul)
@section('description', strip_tags(Str::limit($program->isi, 160)))
@section('keywords', $program->judul)
@section('og_image', $program->gambar ? asset('img/program/' . $program->gambar) : asset('img/Logo-SMPN20.png'))

@section('content')
<!-- Program Detail Content -->
<section class="program-detail section-padding mt-4">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="program-content">
                    <!-- Program Meta -->
                    <div class="program-meta mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center justify-content-md-start">
                                    <span class="me-3 italic"><strong>Penulis:</strong> {{ $program->penulis->nama ?? 'Admin' }}</span>
                                    @if($program->tanggal_publish)
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    <span class="me-3">{{ \Carbon\Carbon::parse($program->tanggal_publish)->format('d F Y, H:i') }}</span>
                                    @endif
                                    <i class="fas fa-eye me-2 text-muted"></i>
                                    <span>{{ number_format($program->views) }} views</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Program -->
                    @if($program->gambar)
                    <div class="program-image mb-4">
                        <img src="{{ asset('img/program/' . $program->gambar) }}" alt="{{ $program->judul }}" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                    </div>
                    @endif

                    <!-- Isi Program -->
                    <div class="program-body">
                        <h2 class="mb-3">{{ $program->judul }}</h2>
                        <div class="program-content">
                            {!! $program->isi !!}
                        </div>
                    </div>
                </article>
            </div>
        
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Program Terkait -->
                <div class="sidebar-widget">
                    <div class="widget-title">
                        <h5><i class="fas fa-list-alt me-2"></i>Program Lainnya</h5>
                    </div>
                    <div class="widget-content">
                        @php
                            $relatedPrograms = \App\Models\ProgramSekolah::published()
                                ->where('id', '!=', $program->id)
                                ->orderBy('tanggal_publish', 'desc')
                                ->limit(3)
                                ->get();
                        @endphp
                        
                        @if($relatedPrograms->count() > 0)
                            @foreach($relatedPrograms as $relatedProgram)
                            <div class="related-program mb-3 p-3 border rounded">
                                <div class="related-image mb-2">
                                    @if($relatedProgram->gambar)
                                    <img src="{{ asset('img/program/' . $relatedProgram->gambar) }}" alt="{{ $relatedProgram->judul }}" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                                    @else
                                    <img src="{{ asset('img/Logo-SMPN20.png') }}" alt="{{ $relatedProgram->judul }}" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: contain; padding: 10px;">
                                    @endif
                                </div>
                                <h6>
                                    <a href="{{ url('/program-sekolah/' . $relatedProgram->slug) }}" class="text-decoration-none text-dark">
                                        {{ $relatedProgram->judul }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($relatedProgram->tanggal_publish)->format('d M Y') }}
                                    <span class="ms-2"><i class="fas fa-eye me-1"></i>{{ number_format($relatedProgram->views) }}</span>
                                </small>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Belum ada program sekolah lainnya.
                            </div>
                        @endif
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
                            <a href="{{ url('/program-sekolah') }}" class="list-group-item list-group-item-action active">
                                <i class="fas fa-list-alt me-2"></i>Program Sekolah
                            </a>
                            <a href="{{ url('/prestasi-sekolah') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-trophy me-2"></i>Prestasi Sekolah
                            </a>
                            <a href="{{ url('/sejarah-sekolah') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-history me-2"></i>Sejarah Sekolah
                            </a>
                            <a href="{{ url('/berita') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-newspaper me-2"></i>Berita
                            </a>
                            <a href="{{ url('/galeri') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Program Detail Styling */
.section-padding {
    padding: 60px 0;
}

.program-meta {
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

.related-program {
    transition: all 0.3s ease;
}

.related-program:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.related-image img {
    transition: all 0.3s ease;
}

.related-program:hover .related-image img {
    transform: scale(1.05);
}

/* Program Content Styling */
.program-content h2 {
    font-size: 1.75rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #0d6efd;
}

.program-content h3 {
    font-size: 1.5rem;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    color: #212529;
}

.program-content p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.program-content ul, .program-content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.program-content li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
}

.program-content blockquote {
    border-left: 4px solid #0d6efd;
    padding: 0.5rem 1rem;
    margin: 1.5rem 0;
    background-color: #f8f9fa;
    font-style: italic;
}

.program-content img {
    max-width: 100%;
    height: auto;
    margin: 1.5rem 0;
    border-radius: 0.25rem;
}

.program-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.program-content table th, .program-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.program-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection