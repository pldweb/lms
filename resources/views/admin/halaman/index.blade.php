@extends('layouts.admin')
@section('title', 'Daftar Halaman Lain')
@section('content')
    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title w-content">Daftar Halaman</h3>
                        <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                            <a href="{{ url('/admin/halaman/create') }}" class="btn btn-primary mb-3 btn-add" style="white-space: nowrap">
                                <i class="ph ph-plus"></i> Tambah Halaman
                            </a>
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control w-auto mb-3" placeholder="Cari...">
                                <span class="input-group-text mb-3"><i class="ph ph-magnifying-glass"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body relative overflow-x-auto">
                    <table id="datatable" class="table table-hover table-striped relative">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300 text-center">No</th>
                                <th class="h6 text-gray-300">Judul</th>
                                <th class="h6 text-gray-300 text-center">Status</th>
                                <th class="h6 text-gray-300 text-center">Tanggal Publish</th>
                                <th class="h6 text-gray-300 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($halaman as $index => $item)
                                <tr>
                                    <td class="text-center text-gray-300">{{ $index + 1 }}</td>
                                    <td class="text-gray-300">{{ $item->judul }}</td>
                                    <td class="text-gray-300 text-center">
                                        <span class="badge bg-{{ $item->status == 'publish' ? 'success' : 'warning' }}">
                                            {{ $item->status == 'publish' ? 'Publish' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="text-gray-300 text-center">
                                        @if($item->tanggal_publish)
                                            {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href='{{ url("/halaman/$item->slug") }}' target="_blank" class="btn btn-success btn-add">
                                            <i class="ph ph-eye"></i>
                                        </a>
                                        <a href="{{ url('/admin/halaman/edit/' . $item->id) }}" class="btn btn-primary btn-add">
                                            <i class="ph ph-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-add btn-delete">
                                            <i class="ph ph-trash text-white"></i>
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
    
    <script>
        $(document).ready(function() {

            initDataTable('#datatable')

        });
    </script>
@endsection