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
                        <a href="{{ url('/admin/artikel/edit/' . $artikel->id) }}" class="btn btn-primary btn-sm">
                            <i class="ph ph-pencil"></i> Edit
                        </a>
                        <a href="{{ url('/admin/artikel/' . $artikel->jenis) }}" class="btn btn-secondary btn-sm">
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
                        <h1 class="mb-3">{{ $artikel->judul }}</h1>

                        <!-- Ringkasan -->
                        @if($artikel->ringkasan)
                            <div class="alert alert-light mb-4">
                                <h6 class="alert-heading">Ringkasan</h6>
                                <p class="mb-0">{{ $artikel->ringkasan }}</p>
                            </div>
                        @endif

                        <!-- Isi Artikel -->
                        <div class="artikel-content">
                            {!! nl2br(e($artikel->isi)) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Info Artikel -->
                        <div class="card">
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
                            </div>
                        </div>

                        <!-- Aksi -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Aksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ url('/admin/artikel/edit/' . $artikel->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ph ph-pencil"></i> Edit Artikel
                                    </a>
                                    
                                    <button type="button" class="btn btn-{{ $artikel->status == 'publish' ? 'warning' : 'success' }} btn-sm" onclick="toggleStatus()">
                                        <i class="ph ph-{{ $artikel->status == 'publish' ? 'eye-slash' : 'eye' }}"></i> 
                                        {{ $artikel->status == 'publish' ? 'Jadikan Draft' : 'Publish' }}
                                    </button>

                                    @if($artikel->status == 'publish')
                                    <a href="#" class="btn btn-info btn-sm" onclick="copyUrl()">
                                        <i class="ph ph-copy"></i> Copy URL
                                    </a>
                                    @endif

                                    <hr>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteArtikel()">
                                        <i class="ph ph-trash"></i> Hapus Artikel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik -->
                        @if($artikel->status == 'publish')
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Statistik</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <h3 class="text-primary">{{ number_format($artikel->views) }}</h3>
                                    <p class="text-muted mb-0">Total Views</p>
                                </div>
                            </div>
                        </div>
                        @endif
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
        
        if (confirm(`Apakah Anda yakin ingin ${action} artikel ini?`)) {
            $.ajax({
                url: '{{ url("/admin/artikel/toggle-status/" . $artikel->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengubah status artikel');
                }
            });
        }
    }

    function deleteArtikel() {
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini? Data yang dihapus tidak dapat dikembalikan.')) {
            $.ajax({
                url: '{{ url("/admin/artikel/destroy/" . $artikel->id) }}',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href = '{{ url("/admin/artikel/" . $artikel->jenis) }}';
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus artikel');
                }
            });
        }
    }

    function copyUrl() {
        // You can implement URL copying logic here
        // For now, just show the URL that would be used in frontend
        const url = window.location.origin + '/artikel/{{ $artikel->id }}';
        navigator.clipboard.writeText(url).then(function() {
            alert('URL berhasil disalin: ' + url);
        }).catch(function() {
            prompt('Copy URL ini:', url);
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
</style>

@endsection
