@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data Galeri</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/galeri/kategori') }}" class="btn btn-secondary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-folder"></i> Kelola Kategori
                        </a>
                        <a href="{{ url('/admin/galeri/create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Item
                        </a>                   
                        <select id="filterKategori" class="form-select w-auto mb-3 mr-2">
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
            <div class="card-body" style="padding-top: 0;">
                @if($galeri->isEmpty())
                    {!! alert("Belum ada galeri", 'warning') !!}
                @else
                <div class="card overflow-hidden">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="galeriTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Preview</th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            <th class="h6 text-gray-300">Kategori</th>
                                            <th class="h6 text-gray-300">Tipe</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galeri as $item)
                                            <tr data-kategori="{{ $item->kategori_galeri_id }}">
                                                <td class="fixed-width">
                                                    <div class="form-check">
                                                        <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->tipe == 'foto' && $item->file_path)
                                                        <img src="{{ asset('img/galeri/' . $item->file_path) }}" alt="Preview" class="w-60 h-40 rounded object-fit-cover">
                                                    @elseif($item->tipe == 'video' && $item->youtube_thumbnail)
                                                        <div class="position-relative">
                                                            <img src="{{ $item->youtube_thumbnail }}" alt="Video Thumbnail" class="w-60 h-40 rounded object-fit-cover">
                                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                                <i class="ph ph-play-circle text-white" style="font-size: 24px; text-shadow: 0 0 5px rgba(0,0,0,0.5);"></i>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->judul }}</span>
                                                        @if($item->deskripsi)
                                                            <p class="text-sm text-gray-500 mb-0">{{ Str::limit($item->deskripsi, 50) }}</p>
                                                        @endif
                                                        @if($item->fotografer)
                                                            <small class="text-muted">Fotografer: {{ $item->fotografer }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $item->kategori->nama_kategori }}</span>
                                                </td>
                                                <td>
                                                    @if($item->tipe == 'foto')
                                                        <span class="badge bg-primary"><i class="ph ph-image"></i> Foto</span>
                                                    @else
                                                        <span class="badge bg-danger"><i class="ph ph-video"></i> Video</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->status == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-warning">Non-Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-add btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if($item->tipe == 'video' && $item->youtube_url)
                                                                <li><a class="dropdown-item" href="{{ $item->youtube_url }}" target="_blank">
                                                                    <i class="ph ph-play"></i> Lihat Video
                                                                </a></li>
                                                            @elseif($item->tipe == 'foto' && $item->file_path)
                                                                <li><a class="dropdown-item" href="{{ asset('img/galeri/' . $item->file_path) }}" target="_blank">
                                                                    <i class="ph ph-eye"></i> Lihat Foto
                                                                </a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" href="{{ url('/admin/galeri-edit/' . $item->id) }}">
                                                                <i class="ph ph-pencil"></i> Edit
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><button class="dropdown-item text-danger" onclick="deleteGaleri({{ $item->id }})">
                                                                <i class="ph ph-trash"></i> Hapus
                                                            </button></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        
    $(document).ready(function() {

        $('#galeriTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: true,
            responsive: true,
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            filterTable();
        });

        // Filter by kategori
        $('#filterKategori').on('change', function() {
            filterTable();
        });

        function filterTable() {
            var searchValue = $('#searchInput').val().toLowerCase();
            var kategoriValue = $('#filterKategori').val();
            
            $('#galeriTable tbody tr').filter(function() {
                var textMatch = $(this).text().toLowerCase().indexOf(searchValue) > -1;
                var kategoriMatch = kategoriValue === '' || $(this).data('kategori') == kategoriValue;
                $(this).toggle(textMatch && kategoriMatch);
            });
        }
    });
</script>

@endsection
