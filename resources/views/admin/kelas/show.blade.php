@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kelas</h1>
        <div>
            <a href="/admin/kelas/edit/{{ $kelas->id }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="/admin/kelas/" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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
            <h6 class="m-0 font-weight-bold text-primary">Informasi Kelas</h6>
            <div>
                @if($kelas->is_active)
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
                            <td width="150"><strong>Nama Kelas</strong></td>
                            <td>: {{ $kelas->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kode</strong></td>
                            <td>: <code>{{ $kelas->kode }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Jenjang</strong></td>
                            <td>: <span class="badge badge-info">{{ $kelas->jenjang }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Tingkat</strong></td>
                            <td>: <span class="badge badge-secondary">Kelas {{ $kelas->tingkat }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Kapasitas</strong></td>
                            <td>: {{ $kelas->kapasitas }} siswa</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Tahun Ajaran</strong></td>
                            <td>: {{ $kelas->tahun_ajaran_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mata Pelajaran</strong></td>
                            <td>: 
                                @if($kelas->mata_pelajaran_nama)
                                    {{ $kelas->mata_pelajaran_kode }} - {{ $kelas->mata_pelajaran_nama }}
                                @else
                                    <span class="text-muted">Kelas Umum</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($kelas->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($kelas->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($kelas->updated_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($kelas->deskripsi)
            <hr>
            <div class="row">
                <div class="col-12">
                    <strong>Deskripsi:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        {{ $kelas->deskripsi }}
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahSiswa }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kapasitas</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $kelas->kapasitas }}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $kelas->kapasitas > 0 ? ($jumlahSiswa / $kelas->kapasitas) * 100 : 0 }}%" 
                                             aria-valuenow="{{ $jumlahSiswa }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{ $kelas->kapasitas }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jadwal Pelajaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahJadwal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sisa Kapasitas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kelas->kapasitas - $jumlahSiswa }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Kelas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Anggota Kelas ({{ $jumlahSiswa }} siswa)</h6>
            <a href="/admin/keanggotaan-kelas/create?kelas_id={{ $kelas->id }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Siswa
            </a>
        </div>
        <div class="card-body">
            @if($anggotaKelas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Tanggal Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggotaKelas as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $siswa->name }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($siswa->tanggal_bergabung)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/user/siswa/{{ $siswa->id }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeSiswa({{ $siswa->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada siswa di kelas ini</p>
                    <a href="/admin/keanggotaan-kelas/create?kelas_id={{ $kelas->id }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Siswa Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-primary mb-3">Aksi Cepat</h6>
                    <div class="btn-group" role="group">
                        <a href="/admin/kelas/edit/{{ $kelas->id }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="/admin/jadwal-pelajaran/create?kelas_id={{ $kelas->id }}" class="btn btn-info">
                            <i class="fas fa-calendar-plus"></i> Tambah Jadwal
                        </a>
                        <form action="/admin/kelas/toggle-status/{{ $kelas->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengubah status kelas ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $kelas->is_active ? 'secondary' : 'success' }}">
                                <i class="fas fa-{{ $kelas->is_active ? 'pause' : 'play' }}"></i> 
                                {{ $kelas->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-danger mb-3">Zona Berbahaya</h6>
                    <form action="/admin/kelas/destroy/{{ $kelas->id }}" method="POST" style="display: inline;" onsubmit="return confirm('PERINGATAN: Menghapus kelas akan mempengaruhi {{ $jumlahSiswa }} siswa dan {{ $jumlahJadwal }} jadwal. Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ ($jumlahSiswa > 0 || $jumlahJadwal > 0) ? 'disabled title="Tidak dapat dihapus karena masih memiliki anggota atau jadwal"' : '' }}>
                            <i class="fas fa-trash"></i> Hapus Kelas
                        </button>
                    </form>
                    @if($jumlahSiswa > 0 || $jumlahJadwal > 0)
                        <small class="text-muted d-block mt-1">
                            Tidak dapat dihapus karena masih memiliki {{ $jumlahSiswa }} siswa dan {{ $jumlahJadwal }} jadwal
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function removeSiswa(siswaId) {
    if (confirm('Yakin ingin mengeluarkan siswa dari kelas ini?')) {
        // Ajax call untuk remove siswa
        fetch(`/admin/keanggotaan-kelas/remove/${siswaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengeluarkan siswa: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error.message);
        });
    }
}
</script>
@endsection
