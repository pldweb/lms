@extends('layouts.admin')
@section('title', 'Kategori Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data Kategori Galeri</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/galeri/kategori-create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Kategori
                        </a>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kategori->isEmpty())
                    {!! alert("Belum ada kategori", 'warning') !!}
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-0 overflow-x-auto">
                                    <table id="kategoriTable" class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th class="h6 text-gray-300">Nama Kategori</th>
                                            <th class="h6 text-gray-300">Cover</th>
                                            <th class="h6 text-gray-300">Status</th>
                                            <th class="h6 text-gray-300">Jumlah Item</th>
                                            <th class="h6 text-gray-300">Urutan</th>
                                            <th class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($kategori as $item)
                                            <tr>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama_kategori }}</span>
                                                    @if($item->deskripsi)
                                                        <p class="text-sm text-gray-500 mb-0">{{ Str::limit($item->deskripsi, 50) }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->gambar_cover)
                                                        <img src="{{ asset('img/galeri/kategori/' . $item->gambar_cover) }}" alt="Cover" class="w-40 h-40 rounded object-fit-cover">
                                                    @else
                                                        <span class="text-muted">-</span>
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
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->galeri_count }}</span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span>
                                                </td>
                                                <td>
                                                    <button onclick="showModal('/admin/kategori-galeri/detail/{{ $item->id }}', 'Data Detail')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm">
                                                        <i class="ph ph-eye btn-icon"></i>
                                                    </button>
                                                    <button onclick="confirmDelete('{{ $item->id }}')" class="btn btn-danger btn-add btn-sm">
                                                        <i class="ph ph-trash btn-icon"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus data ini?', function() {
            ajxProcess('/admin/kategori-galeri/delete/' + id, '', '#message-modal');
        });
    }

    $(document).ready(function() {
        initDataTable('#kategoriTable')
    })
</script>

@endsection
