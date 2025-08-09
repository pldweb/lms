@extends('layouts.admin')
@section('title', 'Detail ' . ucfirst($artikel->jenis))
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail {{ ucfirst($artikel->jenis) }}</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/admin/artikel/edit/' . $artikel->id) }}" class="btn btn-primary btn-sm btn-add">
                            <i class="ph ph-pencil"></i> Edit
                        </a>
                        <a href="{{ url('/admin/artikel/' . $artikel->jenis) }}" class="btn btn-secondary btn-sm btn-add">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Gambar Artikel -->
                        @if($artikel->gambar)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <!-- Judul -->
                        <h2 class="mb-3">{{ $artikel->judul }}</h2>

                        <!-- Isi Artikel -->
                        <div class="artikel-content">
                            {!! $artikel->isi !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Info Artikel -->
                        <div class="card border-1">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Informasi Artikel</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Jenis:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $artikel->jenis == 'berita' ? 'primary' : 'info' }}">
                                                {{ ucfirst($artikel->jenis) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $artikel->status == 'publish' ? 'success' : 'warning' }}">
                                                {{ ucfirst($artikel->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penulis:</strong></td>
                                        <td>{{ $artikel->penulis->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $artikel->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diupdate:</strong></td>
                                        <td>{{ $artikel->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @if($artikel->tanggal_publish)
                                    <tr>
                                        <td><strong>Dipublish:</strong></td>
                                        <td>{{ $artikel->tanggal_publish->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong>Views:</strong></td>
                                        <td>{{ number_format($artikel->views) }}</td>
                                    </tr>
                                </table>
                                <div class="card-body" style="min-height: 80px;">
                                    <div class="d-grid gap-2">
                                        <a href="{{ url('/admin/artikel/edit/' . $artikel->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ph ph-pencil"></i> Edit Artikel
                                        </a>
                                        <button type="button" class="btn btn-{{ $artikel->status == 'publish' ? 'warning' : 'success' }} btn-sm" onclick="toggleStatus()">
                                            <i class="ph ph-{{ $artikel->status == 'publish' ? 'eye-slash' : 'eye' }}"></i> 
                                            {{ $artikel->status == 'publish' ? 'Jadikan Draft' : 'Publish' }}
                                        </button>
                                        @if($artikel->status == 'publish')
                                        <a href="{{url('/artikel/' . $artikel->id)}}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="ph ph-copy"></i>Akses Artikel
                                        </a>
                                        @endif
                                        <hr>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteArtikel()">
                                            <i class="ph ph-trash"></i> Hapus Artikel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStatus() {
        const currentStatus = '{{ $artikel->status }}';
        const action = currentStatus === 'publish' ? 'menjadikan draft' : 'mempublish';

        confirmModal(`Apakah Anda yakin ingin ${action} artikel ini?`, function(){
            ajxProcess("{{ url('/admin/artikel/toggle-status/' . $artikel->id) }}", {
                _token: '{{ csrf_token() }}'
            }, "#message-modal");
        });
    }

    function deleteArtikel() {
        confirmModal(`Apakah Anda yakin ingin menghapus artikel ini?`, function(){
            ajxProcess("{{ url('/admin/artikel/delete/' . $artikel->id) }}", {
                _token: '{{ csrf_token() }}'
            }, "#message-modal");
        });
    }

</script>

<style>
.artikel-content {
    font-size: 16px;
    line-height: 1.6;
    text-align: justify;
}

.artikel-content p {
    margin-bottom: 1rem;
}

.artikel-content h1, .artikel-content h2, .artikel-content h3, 
.artikel-content h4, .artikel-content h5, .artikel-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.artikel-content h1 { font-size: 2rem; }
.artikel-content h2 { font-size: 1.75rem; }
.artikel-content h3 { font-size: 1.5rem; }
.artikel-content h4 { font-size: 1.25rem; }
.artikel-content h5 { font-size: 1.1rem; }
.artikel-content h6 { font-size: 1rem; }

.artikel-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.artikel-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}

.artikel-content table th,
.artikel-content table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.artikel-content table th {
    background-color: #f8f9fa;
}

.artikel-content blockquote {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    margin: 1.5rem 0;
    padding: 1rem;
    font-style: italic;
}

.artikel-content ul, .artikel-content ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.artikel-content strong {
    font-weight: 600;
}

.artikel-content a {
    color: #007bff;
    text-decoration: none;
}

.artikel-content a:hover {
    text-decoration: underline;
}
</style>
@endsection
