@extends('admin.layouts.app')

@section('title', 'Detail Keanggotaan Kelas')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Keanggotaan Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/keanggotaan-kelas/">Keanggotaan Kelas</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Info Siswa dan Kelas -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Informasi Keanggotaan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Siswa</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-lg me-3">
                                    <div class="avatar-initial rounded-circle bg-primary">
                                        {{ substr($keanggotaan->siswa_nama, 0, 2) }}
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-1">{{ $keanggotaan->siswa_nama }}</h4>
                                    <p class="text-muted mb-0">{{ $keanggotaan->siswa_email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Kelas</h5>
                            <div class="mb-3">
                                <span class="badge bg-info fs-6 mb-2">
                                    {{ $keanggotaan->jenjang }} {{ $keanggotaan->tingkat }} {{ $keanggotaan->kelas_nama }}
                                </span>
                                @if($keanggotaan->tahun_ajaran_nama)
                                    <br><small class="text-muted">{{ $keanggotaan->tahun_ajaran_nama }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted">Tanggal Bergabung</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($keanggotaan->tanggal_bergabung)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted">Lama Bergabung</label>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($keanggotaan->tanggal_bergabung)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Siswa -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-chart-line me-1"></i>
                        Riwayat Nilai
                    </div>
                    <div>
                        <span class="badge bg-primary">{{ $nilaiSiswa->count() }} Nilai</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($nilaiSiswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis Nilai</th>
                                        <th>Nilai</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiSiswa as $nilai)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $nilai->mata_pelajaran_nama }}</strong>
                                                <br><small class="text-muted">{{ $nilai->mata_pelajaran_kode }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($nilai->jenis_nilai == 'UTS') bg-warning
                                                @elseif($nilai->jenis_nilai == 'UAS') bg-danger
                                                @elseif($nilai->jenis_nilai == 'Tugas') bg-info
                                                @elseif($nilai->jenis_nilai == 'Kuis') bg-secondary
                                                @else bg-primary
                                                @endif">
                                                {{ $nilai->jenis_nilai }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="
                                                @if($nilai->nilai >= 85) text-success
                                                @elseif($nilai->nilai >= 70) text-warning
                                                @else text-danger
                                                @endif">
                                                {{ $nilai->nilai }}
                                            </strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($nilai->tanggal_nilai)->format('d/m/Y') }}</td>
                                        <td>{{ $nilai->keterangan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Statistik Nilai -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-success mb-1">{{ number_format($nilaiSiswa->avg('nilai'), 1) }}</h5>
                                    <small class="text-muted">Rata-rata</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-primary mb-1">{{ $nilaiSiswa->max('nilai') }}</h5>
                                    <small class="text-muted">Nilai Tertinggi</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-warning mb-1">{{ $nilaiSiswa->min('nilai') }}</h5>
                                    <small class="text-muted">Nilai Terendah</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-info mb-1">{{ $nilaiSiswa->groupBy('mata_pelajaran_id')->count() }}</h5>
                                    <small class="text-muted">Mata Pelajaran</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Nilai</h5>
                            <p class="text-muted">Siswa ini belum memiliki nilai untuk kelas ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tools me-1"></i>
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/admin/keanggotaan-kelas/" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="/admin/nilai-siswa/create?siswa_id={{ $keanggotaan->siswa_id }}&kelas_id={{ $keanggotaan->kelas_id }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Tambah Nilai
                        </a>
                        <a href="/admin/kelas/{{ $keanggotaan->kelas_id }}" class="btn btn-outline-info">
                            <i class="fas fa-eye"></i> Lihat Detail Kelas
                        </a>
                        <hr>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="confirmRemove({{ $keanggotaan->siswa_id }}, '{{ $keanggotaan->siswa_nama }}')">
                            <i class="fas fa-user-times"></i> Keluarkan dari Kelas
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Kelas -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Kelas
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-primary mb-1">{{ DB::table('keanggotaan_kelas')->where('kelas_id', $keanggotaan->kelas_id)->count() }}</h5>
                                <small class="text-muted">Total Siswa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-1">{{ $keanggotaan->kapasitas }}</h5>
                            <small class="text-muted">Kapasitas</small>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        @php
                            $totalSiswa = DB::table('keanggotaan_kelas')->where('kelas_id', $keanggotaan->kelas_id)->count();
                            $persentase = ($totalSiswa / $keanggotaan->kapasitas) * 100;
                        @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar 
                                @if($persentase >= 90) bg-danger
                                @elseif($persentase >= 75) bg-warning
                                @else bg-success
                                @endif" 
                                role="progressbar" style="width: {{ $persentase }}%"></div>
                        </div>
                        <small class="text-muted">{{ number_format($persentase, 1) }}% kapasitas terisi</small>
                    </div>
                </div>
            </div>

            <!-- Progress Akademik -->
            @if($nilaiSiswa->count() > 0)
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-1"></i>
                    Progress Akademik
                </div>
                <div class="card-body">
                    @php
                        $rataRata = $nilaiSiswa->avg('nilai');
                        $grade = '';
                        $gradeColor = '';
                        
                        if ($rataRata >= 90) {
                            $grade = 'A';
                            $gradeColor = 'success';
                        } elseif ($rataRata >= 80) {
                            $grade = 'B';
                            $gradeColor = 'info';
                        } elseif ($rataRata >= 70) {
                            $grade = 'C';
                            $gradeColor = 'warning';
                        } elseif ($rataRata >= 60) {
                            $grade = 'D';
                            $gradeColor = 'danger';
                        } else {
                            $grade = 'E';
                            $gradeColor = 'dark';
                        }
                    @endphp
                    
                    <div class="text-center mb-3">
                        <h2 class="text-{{ $gradeColor }} mb-1">{{ $grade }}</h2>
                        <p class="text-muted mb-0">Grade Saat Ini</p>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h6 class="text-muted mb-1">Rata-rata</h6>
                                <h5 class="text-{{ $gradeColor }} mb-0">{{ number_format($rataRata, 1) }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted mb-1">Total Nilai</h6>
                            <h5 class="text-primary mb-0">{{ $nilaiSiswa->count() }}</h5>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-{{ $gradeColor }}" 
                                 role="progressbar" style="width: {{ ($rataRata / 100) * 100 }}%"></div>
                        </div>
                        <small class="text-muted">Progress: {{ number_format(($rataRata / 100) * 100, 1) }}%</small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Remove -->
<div class="modal fade" id="removeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Keluarkan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengeluarkan siswa <strong id="studentNameModal"></strong> dari kelas ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Siswa yang sudah memiliki nilai tidak dapat dikeluarkan dari kelas!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="removeForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="kelas_id" value="{{ $keanggotaan->kelas_id }}">
                    <button type="submit" class="btn btn-danger">Ya, Keluarkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-lg {
    width: 60px;
    height: 60px;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 1.2rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.info-item p {
    font-size: 1rem;
    font-weight: 500;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.progress {
    background-color: #e9ecef;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@push('scripts')
<script>
function confirmRemove(siswaId, studentName) {
    document.getElementById('studentNameModal').textContent = studentName;
    document.getElementById('removeForm').action = '/admin/keanggotaan-kelas/remove/' + siswaId;
    
    var removeModal = new bootstrap.Modal(document.getElementById('removeModal'));
    removeModal.show();
}

// Handle remove form submission
document.getElementById('removeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = this.action;
    
    fetch(url, {
        method: 'DELETE',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/admin/keanggotaan-kelas/';
        } else {
            alert(data.message || 'Terjadi kesalahan!');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat mengeluarkan siswa!');
    });
});
</script>
@endpush
