@extends('layouts.admin')
@section('title', isset($jenis) ? ucfirst($jenis) : 'Artikel')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data {{ ucfirst($jenis) }}</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/artikel/create-' . $jenis) }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                                <i class="ph ph-plus"></i> Tambah Artikel
                        </a>                   
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($artikel->isEmpty())
                    {!! alert("Belum ada $jenis", 'warning') !!}
                @else
                <div id="table-responsive" class="overflow-x-auto">
                    <table id="artikelTable" class="table table-striped table-hover" width="100%" cellspacing="0">
                        <thead>
                                        <tr>
                                            <th style="width: 8%;" class="h6 text-gray-300">Gambar</th>
                                            <th style="width: 30%;" class="h6 text-gray-300">Judul</th>
                                            <th style="width: 10%;" class="h6 text-gray-300">Status</th>
                                            <th style="width: 15%;" class="h6 text-gray-300">Tanggal Publish</th>
                                            <th style="width: 5%;" class="h6 text-gray-300">Views</th>
                                            <th style="width: 12%;" class="h6 text-gray-300">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($artikel as $item)
                                            <tr>
                                                <td>
                                                    @if($item->gambar)
                                                        <img src="{{ asset('img/artikel/' . $item->gambar) }}" alt="Gambar" class="w-50 h-40 rounded object-fit-cover">
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $item->judul }}</span>
                                                </td>
                                                <td>
                                                    @if($item->status == 'publish')
                                                        <span class="badge bg-success">Publish</span>
                                                    @elseif($item->status == 'scheduled')
                                                        <span class="badge bg-info">Terjadwal</span>
                                                    @else
                                                        <span class="badge bg-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">
                                                        {{ $item->tanggal_publish ? $item->tanggal_publish->format('d/m/Y H:i') : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ number_format($item->views) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/admin/artikel/detail/' . $item->slug) }}" alt="{{ $item->judul }}" class="btn btn-sm btn-add btn-success" target="_blank">
                                                        <i class="ph ph-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-add btn-{{ $item->status == 'publish' ? 'warning' : 'primary' }}" onclick="toggleStatus({{ $item->id }})" alt="{{ $item->judul }}">
                                                        <i class="ph ph-{{ $item->status == 'publish' ? 'eye-slash' : 'eye' }}"></i> 
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-add btn-danger" onclick="deleteArtikel({{ $item->id }})" alt="{{ $item->judul }}">
                                                        <i class="ph ph-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        initDataTable('#artikelTable');
    });

    function toggleStatus(id) {
        confirmModal('Apakah Anda yakin ingin mengubah status artikel ini?', function(){
            ajxProcess('/admin/artikel/toggle-status/' + id, {
                data: {
                    _token: '{{ csrf_token() }}'
                }
            }, '#message-modal')
        })
    }

    function deleteArtikel(id) {
        confirmModal('Apakah Anda yakin ingin menghapus artikel ini? Data yang dihapus tidak dapat dikembalikan.', function(){
            ajxProcess('/admin/artikel/destroy/' + id, {
                data: {
                    _token: '{{ csrf_token() }}'
                }
            }, '#message-modal')
        })
    }
</script>
@endsection
