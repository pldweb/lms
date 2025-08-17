@extends('layouts.admin')
@section('title', 'Detail Mata Pelajaran')
@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail Mata Pelajaran</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="/admin/mata-pelajaran/edit/{{ $mataPelajaran->id }}" class="btn btn-warning btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-pencil"></i> Edit
                        </a>
                        <a href="/admin/mata-pelajaran/" class="btn btn-secondary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Mata Pelajaran</h6>
                                    <div>
                                        @if($mataPelajaran->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </div>
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
                                                    @else
                                                        <span class="text-muted">Semua Jenjang</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Semester</strong></td>
                                                <td>: 
                                                    @if($mataPelajaran->semester)
                                                        <span class="badge badge-primary">Semester {{ $mataPelajaran->semester }}</span>
                                                    @else
                                                        <span class="text-muted">Semua Semester</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>SKS</strong></td>
                                                <td>: {{ $mataPelajaran->sks }} SKS</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Urutan</strong></td>
                                                <td>: {{ $mataPelajaran->urutan }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Status</strong></td>
                                                <td>: 
                                                    @if($mataPelajaran->aktif)
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-secondary">Non-Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dibuat</strong></td>
                                                <td>: {{ $mataPelajaran->created_at}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Diperbarui</strong></td>
                                                <td>: {{ $mataPelajaran->updated_at }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Penggunaan</strong></td>
                                                <td>: {{ $jumlahKelas }} Kelas</td>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKelas }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">SKS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mataPelajaran->sks }}</div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Semester</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        @if($mataPelajaran->semester)
                                            Semester {{ $mataPelajaran->semester }}
                                        @else
                                            Semua Semester
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                 @if($jumlahKelas > 0)
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
                                         <button type="submit" class="btn btn-{{ $mataPelajaran->aktif ? 'secondary' : 'success' }}">
                                             <i class="fas fa-{{ $mataPelajaran->aktif ? 'pause' : 'play' }}"></i> 
                                             {{ $mataPelajaran->aktif ? 'Non-aktifkan' : 'Aktifkan' }}
                                         </button>
                                     </form>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <h6 class="font-weight-bold text-danger mb-3">Zona Berbahaya</h6>
                                 <form action="/admin/mata-pelajaran/destroy/{{ $mataPelajaran->id }}" method="POST" style="display: inline;" onsubmit="return confirm('PERINGATAN: Menghapus mata pelajaran akan mempengaruhi {{ $jumlahKelas }} kelas. Yakin ingin menghapus?')">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="btn btn-danger" {{ $jumlahKelas > 0 ? 'disabled title="Tidak dapat dihapus karena sedang digunakan"' : '' }}>
                                         <i class="fas fa-trash"></i> Hapus Mata Pelajaran
                                     </button>
                                 </form>
                                 @if($jumlahKelas > 0)
                                     <small class="text-muted d-block mt-1">Tidak dapat dihapus karena sedang digunakan pada {{ $jumlahKelas }} kelas</small>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
