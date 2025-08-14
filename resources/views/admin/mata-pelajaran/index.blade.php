@extends('layouts.admin')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Mata Pelajaran</h1>
        <a href="/admin/mata-pelajaran/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Mata Pelajaran
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

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="/admin/mata-pelajaran/">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama/kode/deskripsi...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="jenjang">Jenjang</label>
                            <select class="form-control" id="jenjang" name="jenjang">
                                <option value="">Semua Jenjang</option>
                                <option value="SD" {{ request('jenjang') === 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('jenjang') === 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ request('jenjang') === 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ request('jenjang') === 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                <option value="wajib" {{ request('kategori') === 'wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="pilihan" {{ request('kategori') === 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                                <option value="muatan_lokal" {{ request('kategori') === 'muatan_lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="non-aktif" {{ request('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="/admin/mata-pelajaran/" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jenjang</th>
                            <th>Kategori</th>
                            <th>Bobot SKS</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataPelajaran as $index => $mp)
                        <tr>
                            <td>{{ ($mataPelajaran->currentPage() - 1) * $mataPelajaran->perPage() + $index + 1 }}</td>
                            <td><code>{{ $mp->kode }}</code></td>
                            <td>{{ $mp->nama }}</td>
                            <td>
                                @if($mp->jenjang)
                                    <span class="badge badge-info">{{ $mp->jenjang }}</span>
                                    @if($mp->tingkat)
                                        <small class="text-muted">Kelas {{ $mp->tingkat }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">Semua</span>
                                @endif
                            </td>
                            <td>
                                @if($mp->kategori === 'wajib')
                                    <span class="badge badge-success">Wajib</span>
                                @elseif($mp->kategori === 'pilihan')
                                    <span class="badge badge-warning">Pilihan</span>
                                @else
                                    <span class="badge badge-secondary">Muatan Lokal</span>
                                @endif
                            </td>
                            <td>{{ $mp->bobot_sks }} SKS</td>
                            <td>
                                @if($mp->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Aksi">
                                    <a href="/admin/mata-pelajaran/show/{{ $mp->id }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/mata-pelajaran/edit/{{ $mp->id }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/mata-pelajaran/toggle-status/{{ $mp->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengubah status mata pelajaran ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $mp->is_active ? 'secondary' : 'success' }} btn-sm" title="{{ $mp->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $mp->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="/admin/mata-pelajaran/destroy/{{ $mp->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
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
                            <td colspan="8" class="text-center">Tidak ada data mata pelajaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($mataPelajaran->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $mataPelajaran->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
