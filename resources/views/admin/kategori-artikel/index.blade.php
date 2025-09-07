@extends('layouts.admin')
@section('title', 'Admin')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Data Kategori Artikel</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        @if(Auth::user()->hasRole('Admin'))
                        <a onclick="showModal('{{ url('/admin/kategori-artikel/create') }}', 'Tambah Kategori Artikel')" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Kategori Artikel
                        </a>
                        @endif
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                            <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kategori->count() == 0)
                    {!! alert('Data Kategori Artikel Tidak Ada', 'warning') !!}
                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0 overflow-x-auto">
                                <table id="kategoriTable" class="table table-striped table-hover">
                                    <thead>
                                            <tr>
                                                <th style="width: 10%" class="h6 text-gray-300" style="width: 5px;">No</th>
                                                <th class="h6 text-gray-300">Nama</th>
                                                <th class="h6 text-gray-300">Slug</th>
                                                @if(Auth::user()->hasRole('Admin'))
                                                <th class="h6 text-gray-300">Aksi</th>
                                                @endif
                                            </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($kategori as $data)
                                                <tr>
                                                    <td>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="flex-align gap-8">
                                                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $data->nama }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="h6 mb-0 fw-medium text-gray-300">{{ $data->slug }}</span>
                                                    </td>
                                                    @if(Auth::user()->hasRole('Admin'))
                                                        <td>
                                                            <button onclick="showModal('/admin/kategori-artikel/detail/{{ $data->id }}', 'Data Detail Kategori Artikel')" style="margin-right: 5px;" class="btn btn-primary btn-add btn-sm"><i class="ph ph-pencil"></i></button>
                                                            <button onclick="deleteKategori('{{ $data->id }}')" class="btn btn-danger btn-add btn-sm"><i class="ph ph-trash btn-icon"></i></button>
                                                        </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    function deleteKategori(id) {
            confirmModal('Apakah kamu yakin ingin hapus kategori ini?', function (){
                ajxProcess('/admin/kategori-artikel/delete/' + id, {
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                }, '#message-modal')
            });
        }

    $(document).ready(function () {
        initDataTable('#kategoriTable');
    });
</script>
@endsection
