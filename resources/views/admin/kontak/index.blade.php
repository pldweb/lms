@extends('layouts.admin')
@section('title', 'Kontak')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <h3 class="card-title">Daftar Kontak</h3>
                <div class="card-tools">
                    <a href="{{ url('/admin/kontak/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kontak
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Icon</th>
                                <th width="5%">Urutan</th>
                                <th width="5%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($kontak) > 0)
                                @foreach($kontak as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td><i class="{{ $item->icon }}"></i> {{ $item->icon }}</td>
                                        <td>{{ $item->urutan }}</td>
                                        <td>
                                            @if($item->aktif)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/kontak/edit/'.$item->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        confirmModal('Apakah kamu yakin ingin menghapus kontak ini?', function(){
            ajxProcess('/admin/kontak/delete/' + id, {}, '#message-modal');
        });
    }
</script>
@endsection