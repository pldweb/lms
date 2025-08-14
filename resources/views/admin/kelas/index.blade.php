@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kelas</h1>
        <a href="/admin/kelas/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kelas
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
            <form method="GET" action="/admin/kelas/">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama/kode kelas...">
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
                            <label for="tingkat">Tingkat</label>
                            <select class="form-control" id="tingkat" name="tingkat">
                                <option value="">Semua Tingkat</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('tingkat') == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tahun_ajaran_id">Tahun Ajaran</label>
                            <select class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }}
                                    </option>
                                @endforeach
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
                                <a href="/admin/kelas/" class="btn btn-secondary">
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Kelas</th>
                            <th>Jenjang</th>
                            <th>Tingkat</th>
                            <th>Tahun Ajaran</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $kls)
                        <tr>
                            <td>{{ ($kelas->currentPage() - 1) * $kelas->perPage() + $index + 1 }}</td>
                            <td><code>{{ $kls->kode }}</code></td>
                            <td>{{ $kls->nama }}</td>
                            <td>
                                <span class="badge badge-info">{{ $kls->jenjang }}</span>
                            </td>
                            <td>
                                <span class="badge badge-secondary">Kelas {{ $kls->tingkat }}</span>
                            </td>
                            <td>
                                <small>{{ $kls->tahun_ajaran_nama ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge badge-light">{{ $kls->kapasitas }} siswa</span>
                            </td>
                            <td>
                                @if($kls->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Aksi">
                                    <a href="/admin/kelas/show/{{ $kls->id }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/kelas/edit/{{ $kls->id }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/kelas/toggle-status/{{ $kls->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengubah status kelas ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $kls->is_active ? 'secondary' : 'success' }} btn-sm" title="{{ $kls->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $kls->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="/admin/kelas/destroy/{{ $kls->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
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
                            <td colspan="9" class="text-center">Tidak ada data kelas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kelas->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $kelas->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
