@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')

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
                        <a href="{{ url('/admin/galeri/create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Item
                        </a>                   
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
                <div class="card overflow-hidden">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="galeriTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Preview</th>
                                            <th class="h6 text-gray-300">Judul</th>
                                            <th class="h6 text-gray-300">Kategori</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galeri as $item)
                                            <tr data-kategori="{{ $item->kategori_galeri_id }}">
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
                                                    <span class="badge bg-info">{{$item->kategori->nama_kategori}}</span>
                                                </td>
                                                {{-- <td>
                                                    @if($item->tipe == 'foto')
                                                        <span class="badge bg-primary"><i class="ph ph-image"></i> Foto</span>
                                                    @else
                                                        <span class="badge bg-danger"><i class="ph ph-video"></i> Video</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @if($item->status == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-warning">Non-Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{$item->urutan}}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/admin/galeri/edit/' . $item->id) }}" class="btn btn-sm btn-edit btn-add btn-primary">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-add btn-{{ $item->status == 'aktif' ? 'warning' : 'success' }}" onclick="toggleStatus({{ $item->id }})">
                                                        <i class="ph ph-{{ $item->status == 'aktif' ? 'eye-slash' : 'eye' }}"></i> 
                                                    </button>
                                                    <button onclick="deleteGaleri('{{ $item->id }}')" class="btn btn-sm btn-delete btn-add btn-danger">
                                                        <i class="ph ph-trash"></i>
                                                    </button>
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
       initDataTable("#galeriTable")
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
