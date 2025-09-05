@extends('layouts.admin')
@section('title', 'Kontak')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Kontak</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/kontak/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Tambah Kontak
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($kontak->isEmpty())
                    {!! alert('Belum ada kontak', 'warning') !!}
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-kontak" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="h6 text-gray-300">No</th>
                                <th class="h6 text-gray-300">Nama</th>
                                <th class="h6 text-gray-300">Jabatan</th>
                                <th class="h6 text-gray-300">Email</th>
                                <th class="h6 text-gray-300">Telepon</th>
                                <th class="h6 text-gray-300">Alamat</th>
                                <th class="h6 text-gray-300">Icon</th>
                                <th class="h6 text-gray-300">Urutan</th>
                                <th class="h6 text-gray-300">Status</th>
                                <th class="h6 text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kontak as $index => $item)
                            <tr>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $index + 1 }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->nama }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->jabatan }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->email }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->telepon }}</span></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ Str::limit($item->alamat, 30) }}</span></td>
                                <td><i class="{{ $item->icon }}"></i></td>
                                <td><span class="h6 mb-0 fw-medium text-gray-300">{{ $item->urutan }}</span></td>
                                <td>
                                    @if ($item->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/kontak/edit/' . $item->id) }}" class="btn btn-sm btn-primary btn-add">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-add" onclick="confirmDelete({{ $item->id }})">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-gray-300">Tidak ada data kontak</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus kontak ini?', function() {
            ajxProcess('/admin/kontak/delete-action/' + id, '', '#message-modal');
        });
    }
</script>
@endsection