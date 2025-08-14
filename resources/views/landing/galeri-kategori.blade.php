@extends('layouts.landing')
@section('title', $title)
@section('content')

<!-- Header Section -->
<section class="category-header bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-white-50">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/galeri') }}" class="text-white-50">Galeri</a></li>
                        <li class="breadcrumb-item active text-white">{{ $kategori->nama_kategori }}</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-3">{{ $kategori->nama_kategori }}</h1>
                @if($kategori->deskripsi)
                <p class="lead">{{ $kategori->deskripsi }}</p>
                @endif
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="ph ph-images"></i> {{ $galeri->total() }} Item
                    </span>
                    @if($galeri->where('tipe', 'foto')->count() > 0)
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="ph ph-image"></i> {{ $galeri->where('tipe', 'foto')->count() }} Foto
                    </span>
                    @endif
                    @if($galeri->where('tipe', 'video')->count() > 0)
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="ph ph-video"></i> {{ $galeri->where('tipe', 'video')->count() }} Video
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 text-end">
                @if($kategori->gambar_cover)
                <img src="{{ asset('img/galeri/kategori/' . $kategori->gambar_cover) }}" alt="{{ $kategori->nama_kategori }}" class="img-fluid rounded shadow" style="max-height: 200px;">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="filter-tabs">
                    <button class="btn btn-outline-primary active" data-filter="all">
                        <i class="ph ph-images"></i> Semua
                    </button>
                    <button class="btn btn-outline-primary" data-filter="foto">
                        <i class="ph ph-image"></i> Foto
                    </button>
                    <button class="btn btn-outline-primary" data-filter="video">
                        <i class="ph ph-video"></i> Video
                    </button>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="view-toggle">
                    <button class="btn btn-outline-secondary active" data-view="grid">
                        <i class="ph ph-grid-four"></i> Grid
                    </button>
                    <button class="btn btn-outline-secondary" data-view="list">
                        <i class="ph ph-list"></i> List
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        @if($galeri->count() > 0)
        <div id="gallery-grid" class="row g-4">
            @foreach($galeri as $item)
            <div class="col-lg-4 col-md-6 gallery-item" data-type="{{ $item->tipe }}">
                <div class="gallery-card h-100">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="position-relative overflow-hidden gallery-image" style="height: 250px;">
                            @if($item->tipe == 'foto' && $item->file_path)
                                <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover" loading="lazy">
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0">
                                    <div class="text-center text-white">
                                        <i class="ph ph-magnifying-glass-plus" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Lihat Detail</p>
                                    </div>
                                </div>
                                <a href="{{ url('/galeri/detail/' . $item->id) }}" class="stretched-link"></a>
                            @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                <img src="{{ $item->youtube_thumbnail }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover" loading="lazy">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <i class="ph ph-play-circle text-white" style="font-size: 4rem; text-shadow: 0 0 10px rgba(0,0,0,0.8);"></i>
                                </div>
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center opacity-0">
                                    <div class="text-center text-white">
                                        <i class="ph ph-play" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Putar Video</p>
                                    </div>
                                </div>
                                <a href="{{ url('/galeri/detail/' . $item->id) }}" class="stretched-link"></a>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">{{ $item->judul }}</h6>
                            @if($item->deskripsi)
                            <p class="card-text text-muted small mb-3">{{ Str::limit($item->deskripsi, 80) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-{{ $item->tipe == 'foto' ? 'primary' : 'danger' }}">
                                    <i class="ph ph-{{ $item->tipe == 'foto' ? 'image' : 'video' }}"></i> 
                                    {{ ucfirst($item->tipe) }}
                                </span>
                                @if($item->tanggal_foto)
                                <small class="text-muted">
                                    <i class="ph ph-calendar"></i> {{ $item->tanggal_foto->format('d M Y') }}
                                </small>
                                @endif
                            </div>
                            @if($item->fotografer)
                            <small class="text-muted d-block mt-2">
                                <i class="ph ph-camera"></i> {{ $item->fotografer }}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- List View (Hidden by default) -->
        <div id="gallery-list" class="d-none">
            @foreach($galeri as $item)
            <div class="gallery-list-item mb-4" data-type="{{ $item->tipe }}">
                <div class="card border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                @if($item->tipe == 'foto' && $item->file_path)
                                    <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                    <img src="{{ $item->youtube_thumbnail }}" alt="{{ $item->judul }}" class="w-100 h-100 object-fit-cover">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="ph ph-play-circle text-white" style="font-size: 3rem; text-shadow: 0 0 10px rgba(0,0,0,0.8);"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body h-100 d-flex flex-column">
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold">{{ $item->judul }}</h5>
                                    @if($item->deskripsi)
                                    <p class="card-text text-muted">{{ $item->deskripsi }}</p>
                                    @endif
                                    <div class="mb-3">
                                        <span class="badge bg-{{ $item->tipe == 'foto' ? 'primary' : 'danger' }} me-2">
                                            <i class="ph ph-{{ $item->tipe == 'foto' ? 'image' : 'video' }}"></i> 
                                            {{ ucfirst($item->tipe) }}
                                        </span>
                                        @if($item->tanggal_foto)
                                        <small class="text-muted">
                                            <i class="ph ph-calendar"></i> {{ $item->tanggal_foto->format('d M Y') }}
                                        </small>
                                        @endif
                                    </div>
                                    @if($item->fotografer)
                                    <small class="text-muted">
                                        <i class="ph ph-camera"></i> {{ $item->fotografer }}
                                    </small>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <a href="{{ url('/galeri/detail/' . $item->id) }}" class="btn btn-primary">
                                        <i class="ph ph-arrow-right"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $galeri->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="ph ph-images text-muted" style="font-size: 5rem;"></i>
            <h4 class="mt-3 text-muted">Belum ada item galeri</h4>
            <p class="text-muted">Item galeri untuk kategori ini belum tersedia.</p>
            <a href="{{ url('/galeri') }}" class="btn btn-primary">
                <i class="ph ph-arrow-left"></i> Kembali ke Galeri
            </a>
        </div>
        @endif
    </div>
</section>

<style>
.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.filter-tabs .btn {
    margin-right: 10px;
    margin-bottom: 10px;
}

.view-toggle .btn {
    margin-left: 5px;
}

.gallery-card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.gallery-image:hover .gallery-overlay {
    opacity: 1 !important;
    transition: all 0.3s ease;
}

.gallery-overlay {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .filter-tabs {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .view-toggle {
        text-align: center;
    }
    
    .category-header .col-lg-4 {
        text-align: center;
        margin-top: 20px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Filter functionality
    $('.filter-tabs .btn').click(function() {
        $('.filter-tabs .btn').removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('filter');
        
        if (filter === 'all') {
            $('.gallery-item, .gallery-list-item').show();
        } else {
            $('.gallery-item, .gallery-list-item').hide();
            $(`.gallery-item[data-type="${filter}"], .gallery-list-item[data-type="${filter}"]`).show();
        }
    });
    
    // View toggle functionality
    $('.view-toggle .btn').click(function() {
        $('.view-toggle .btn').removeClass('active');
        $(this).addClass('active');
        
        const view = $(this).data('view');
        
        if (view === 'grid') {
            $('#gallery-grid').removeClass('d-none');
            $('#gallery-list').addClass('d-none');
        } else {
            $('#gallery-grid').addClass('d-none');
            $('#gallery-list').removeClass('d-none');
        }
    });
});
</script>

@endsection
