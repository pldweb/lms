@extends('layouts.admin')

@section('title', 'Detail Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Mata Pelajaran</h1>
        <div>
            <a href="/admin/mata-pelajaran/edit/{{ $mataPelajaran->id }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="/admin/mata-pelajaran/" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Mata Pelajaran</h6>
            <div>
                @if($mataPelajaran->is_active)
                    <span class="badge badge-success badge-lg">Aktif</span>
                @else
                    <span class="badge badge-secondary badge-lg">Non-Aktif</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Nama</strong></td>
                            <td>: {{ $mataPelajaran->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kode</strong></td>
                            <td>: <code>{{ $mataPelajaran->kode }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Jenjang</strong></td>
                            <td>: 
                                @if($mataPelajaran->jenjang)
                                    <span class="badge badge-info">{{ $mataPelajaran->jenjang }}</span>
                                    @if($mataPelajaran->tingkat)
                                        <span class="ml-2">Kelas {{ $mataPelajaran->tingkat }}</span>
                                    @else
                                        <span class="ml-2 text-muted">Semua Kelas</span>
                                    @endif
                                @else
                                    <span class="text-muted">Semua Jenjang</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Kategori</strong></td>
                            <td>: 
                                @if($mataPelajaran->kategori === 'wajib')
                                    <span class="badge badge-success">Wajib</span>
                                @elseif($mataPelajaran->kategori === 'pilihan')
                                    <span class="badge badge-warning">Pilihan</span>
                                @else
                                    <span class="badge badge-secondary">Muatan Lokal</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Bobot SKS</strong></td>
                            <td>: {{ $mataPelajaran->bobot_sks }} SKS</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Status</strong></td>
                            <td>: 
                                @if($mataPelajaran->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>: {{ $mataPelajaran->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui</strong></td>
                            <td>: {{ $mataPelajaran->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Penggunaan</strong></td>
                            <td>: {{ $usageCount }} Kelas</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($mataPelajaran->deskripsi)
            <hr>
            <div class="row">
                <div class="col-12">
                    <strong>Deskripsi:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        {{ $mataPelajaran->deskripsi }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kelas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usageCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Bobot SKS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mataPelajaran->bobot_sks }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-weight fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kategori</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        @if($mataPelajaran->kategori === 'wajib')
                                            Wajib
                                        @elseif($mataPelajaran->kategori === 'pilihan')
                                            Pilihan
                                        @else
                                            Muatan Lokal
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jenjang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $mataPelajaran->jenjang ?: 'Semua' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas Usage -->
    @if($usageCount > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kelas yang Menggunakan Mata Pelajaran Ini</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jenjang</th>
                            <th>Tingkat</th>
                            <th>Tahun Ajaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelasUsage as $index => $kelas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kelas->nama }}</td>
                            <td><span class="badge badge-info">{{ $kelas->jenjang }}</span></td>
                            <td>Kelas {{ $kelas->tingkat }}</td>
                            <td>{{ $kelas->tahunAjaran->nama ?? '-' }}</td>
                            <td>
                                @if($kelas->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-primary mb-3">Aksi Cepat</h6>
                    <div class="btn-group" role="group">
                        <a href="/admin/mata-pelajaran/edit/{{ $mataPelajaran->id }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="/admin/mata-pelajaran/toggle-status/{{ $mataPelajaran->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengubah status mata pelajaran ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $mataPelajaran->is_active ? 'secondary' : 'success' }}">
                                <i class="fas fa-{{ $mataPelajaran->is_active ? 'pause' : 'play' }}"></i> 
                                {{ $mataPelajaran->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-danger mb-3">Zona Berbahaya</h6>
                    <form action="/admin/mata-pelajaran/destroy/{{ $mataPelajaran->id }}" method="POST" style="display: inline;" onsubmit="return confirm('PERINGATAN: Menghapus mata pelajaran akan mempengaruhi {{ $usageCount }} kelas. Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ $usageCount > 0 ? 'disabled title="Tidak dapat dihapus karena sedang digunakan"' : '' }}>
                            <i class="fas fa-trash"></i> Hapus Mata Pelajaran
                        </button>
                    </form>
                    @if($usageCount > 0)
                        <small class="text-muted d-block mt-1">Tidak dapat dihapus karena sedang digunakan pada {{ $usageCount }} kelas</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
