@extends('layouts.admin')

@section('title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Tahun Ajaran</h1>
        <a href="/admin/tahun-ajaran/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tahun Ajaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tahun Ajaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tahun Ajaran</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahunAjaran as $index => $ta)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $ta->nama }}</td>
                            <td>{{ date('d/m/Y', strtotime($ta->tanggal_mulai)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($ta->tanggal_selesai)) }}</td>
                            <td>
                                @if($ta->status === 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $ta->keterangan }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Aksi">
                                    <a href="/admin/tahun-ajaran/show/{{ $ta->id }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/tahun-ajaran/edit/{{ $ta->id }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($ta->status !== 'aktif')
                                        <form action="/admin/tahun-ajaran/activate/{{ $ta->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengaktifkan tahun ajaran ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Aktifkan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="/admin/tahun-ajaran/destroy/{{ $ta->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data tahun ajaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "order": [[ 2, "desc" ]], // Order by tanggal mulai desc
        "columnDefs": [
            { "orderable": false, "targets": 6 } // Disable ordering on action column
        ]
    });
});
</script>
@endpush
