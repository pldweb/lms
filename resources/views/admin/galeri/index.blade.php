@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')

<!-- Modal Pilih Kategori -->
<div class="modal fade" id="pilihKategoriModal" tabindex="-1" aria-labelledby="pilihKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihKategoriModalLabel">Pilih Kategori Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kategoriSelect" class="form-label">Kategori</label>
                    <select id="kategoriSelect" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnLanjutUpload" disabled>Lanjut Upload</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data Galeri</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/galeri/kategori') }}" class="btn btn-secondary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-folder"></i> Kelola Kategori
                        </a>
                        <button type="button" class="btn btn-primary mb-3 btn-add" data-bs-toggle="modal" data-bs-target="#pilihKategoriModal" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Item
                        </button>                   
                        <select id="filterKategori" class="form-select w-auto mb-3 mr-2 select2">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($galeri->isEmpty())
                    {!! alert("Belum ada galeri", 'warning') !!}
                @else
                    @foreach($kategori as $kat)
                        @php
                            $galeriKategori = $galeri->where('kategori_galeri_id', $kat->id);
                        @endphp
                        
                        @if($galeriKategori->count() > 0)
                            <div class="card mb-4 category-card" data-kategori="{{ $kat->id }}">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="ph ph-folder-open"></i> {{ $kat->nama_kategori }}
                                            <span class="badge bg-primary ms-2">{{ $galeriKategori->count() }} item</span>
                                        </h5>
                                        <small class="text-muted">{{ $kat->deskripsi }}</small>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="80">Preview</th>
                                                    <th>Judul</th>
                                                    <th width="100">Status</th>
                                                    <th width="80">Urutan</th>
                                                    <th width="150">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($galeriKategori as $item)
                                                    <tr>
                                                        <td>
                                                            @if($item->tipe == 'foto' && $item->file_path)
                                                                <img src="{{ asset('img/uploads/' . $item->file_path) }}" alt="Preview" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                    <i class="ph ph-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <h6 class="mb-1">{{ $item->judul }}</h6>
                                                                @if($item->deskripsi)
                                                                    <small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                                                @endif
                                                                @if($item->tanggal_foto)
                                                                    <br><small class="text-info">📅 {{ \Carbon\Carbon::parse($item->tanggal_foto)->format('d M Y') }}</small>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($item->status == 'aktif')
                                                                <span class="badge bg-success">Aktif</span>
                                                            @else
                                                                <span class="badge bg-warning">Non-Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="fw-medium">{{ $item->urutan ?? 0 }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ url('/admin/galeri/edit/' . $item->id) }}" class="btn btn-sm btn-add" title="Edit">
                                                                    <i class="ph ph-pencil"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-outline-{{ $item->status == 'aktif' ? 'warning' : 'success' }}" onclick="toggleStatus({{ $item->id }})" title="{{ $item->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                                    <i class="ph ph-{{ $item->status == 'aktif' ? 'eye-slash' : 'eye' }}"></i>
                                                                </button>
                                                                <button onclick="deleteGaleri('{{ $item->id }}')" class="btn btn-sm btn-add" title="Hapus">
                                                                    <i class="ph ph-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    {{-- Kategori yang tidak memiliki galeri --}}
                    @php
                        $kategoriKosong = $kategori->filter(function($kat) use ($galeri) {
                            return $galeri->where('kategori_galeri_id', $kat->id)->count() == 0;
                        });
                    @endphp
                    
                    @if($kategoriKosong->count() > 0)
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="ph ph-folder"></i> Kategori Kosong
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($kategoriKosong as $kat)
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 border-dashed">
                                                <div class="card-body text-center">
                                                    <i class="ph ph-folder-open text-muted" style="font-size: 2rem;"></i>
                                                    <h6 class="mt-2">{{ $kat->nama_kategori }}</h6>
                                                    <p class="text-muted small">{{ $kat->deskripsi ?: 'Belum ada galeri' }}</p>
                                                    <a href="{{ url('/admin/galeri/create') }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ph ph-plus"></i> Tambah Galeri
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-dashed {
    border: 2px dashed #dee2e6 !important;
}

.border-dashed:hover {
    border-color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.05);
}

.table th {
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
}

.btn-group .btn {
    margin-right: 2px;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
}

/* Filter dan Search Functionality */
.category-card {
    transition: all 0.3s ease;
}

.category-card.filtered-out {
    display: none;
}

.search-highlight {
    background-color: #fff3cd;
}
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2 untuk filter
        initSelect2("#filterKategori");
        
        // Filter berdasarkan kategori
        $('#filterKategori').on('change', function() {
            const selectedKategori = $(this).val();
            
            if (selectedKategori === '') {
                // Tampilkan semua kategori
                $('.category-card').show();
            } else {
                // Sembunyikan semua kategori
                $('.category-card').hide();
                
                // Tampilkan kategori yang dipilih
                $(`.category-card[data-kategori="${selectedKategori}"]`).show();
            }
        });
        
        // Search functionality
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            if (searchTerm === '') {
                // Reset highlight dan tampilkan semua
                $('.search-highlight').removeClass('search-highlight');
                $('tr').show();
            } else {
                // Cari di judul galeri
                $('tbody tr').each(function() {
                    const judulText = $(this).find('h6').text().toLowerCase();
                    const deskripsiText = $(this).find('small').text().toLowerCase();
                    
                    if (judulText.includes(searchTerm) || deskripsiText.includes(searchTerm)) {
                        $(this).show();
                        // Highlight text yang cocok
                        highlightText($(this), searchTerm);
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
        
        // Fungsi untuk highlight text
        function highlightText(element, searchTerm) {
            element.find('h6, small').each(function() {
                const text = $(this).html();
                const highlightedText = text.replace(
                    new RegExp(searchTerm, 'gi'),
                    '<span class="search-highlight">$&</span>'
                );
                $(this).html(highlightedText);
            });
        }
        
        // Pilih Kategori Modal
        $('#kategoriSelect').on('change', function() {
            var kategoriId = $(this).val();
            if (kategoriId) {
                $('#btnLanjutUpload').prop('disabled', false);
            } else {
                $('#btnLanjutUpload').prop('disabled', true);
            }
        });

        // Lanjut Upload Button
        $('#btnLanjutUpload').on('click', function() {
            var kategoriId = $('#kategoriSelect').val();
            if (kategoriId) {
                window.location.href = "{{ url('/admin/galeri/create') }}?kategori_id=" + kategoriId;
            }
        });
    });
    
    function toggleStatus(id) {
        confirmModal('Apakah Anda yakin ingin mengubah status galeri ini?', function(){
            ajxProcess('/admin/galeri/toggle-status/' + id, {
                data: {
                    _token: '{{ csrf_token() }}'
                }
            }, '#message-modal')
        })
    }
    
    function deleteGaleri(id) {
        confirmModal('Apakah Anda yakin ingin menghapus item galeri ini? Data yang dihapus tidak dapat dikembalikan.', function(){
            ajxProcess('/admin/galeri/delete/' + id, {
                data: {
                    _token: '{{ csrf_token() }}'
                }
            }, '#message-modal')
        })
    }
</script>

@endsection
