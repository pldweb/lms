@extends('admin.layouts.app')

@section('title', 'Detail Nilai Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Nilai Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/nilai-siswa/">Nilai Siswa</a></li>
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
            <!-- Info Nilai Utama -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Informasi Nilai Siswa
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section mb-4">
                                <h5 class="mb-3 text-primary">
                                    <i class="fas fa-user me-2"></i>Data Siswa
                                </h5>
                                <div class="student-info">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-lg me-3">
                                            <div class="avatar-initial rounded-circle bg-primary">
                                                {{ substr($nilai->siswa_nama, 0, 2) }}
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="mb-1">{{ $nilai->siswa_nama }}</h4>
                                            <p class="text-muted mb-0">{{ $nilai->siswa_email }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <label class="text-muted">Kelas</label>
                                        <p class="mb-0">
                                            <span class="badge bg-info fs-6">
                                                {{ $nilai->jenjang }} {{ $nilai->tingkat }} {{ $nilai->kelas_nama }}
                                            </span>
                                            @if($nilai->tahun_ajaran_nama)
                                                <br><small class="text-muted">{{ $nilai->tahun_ajaran_nama }}</small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-section mb-4">
                                <h5 class="mb-3 text-success">
                                    <i class="fas fa-book me-2"></i>Mata Pelajaran
                                </h5>
                                <div class="info-item">
                                    <label class="text-muted">Mata Pelajaran</label>
                                    <p class="mb-2">
                                        <strong>{{ $nilai->mata_pelajaran_nama }}</strong>
                                        <br><small class="text-muted">Kode: {{ $nilai->mata_pelajaran_kode }}</small>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-item">
                                            <label class="text-muted">Jenis Nilai</label>
                                            <p class="mb-0">
                                                <span class="badge 
                                                    @if($nilai->jenis_nilai == 'UTS') bg-warning
                                                    @elseif($nilai->jenis_nilai == 'UAS') bg-danger
                                                    @elseif($nilai->jenis_nilai == 'Tugas') bg-info
                                                    @elseif($nilai->jenis_nilai == 'Kuis') bg-secondary
                                                    @elseif($nilai->jenis_nilai == 'Praktik') bg-success
                                                    @else bg-primary
                                                    @endif">
                                                    {{ $nilai->jenis_nilai }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-item">
                                            <label class="text-muted">Semester</label>
                                            <p class="mb-0">
                                                <span class="badge bg-secondary">{{ $nilai->semester }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Nilai dan Grade -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="nilai-display text-center">
                                @php
                                    $grade = '';
                                    $gradeColor = '';
                                    if ($nilai->nilai >= 90) {
                                        $grade = 'A';
                                        $gradeColor = 'success';
                                    } elseif ($nilai->nilai >= 80) {
                                        $grade = 'B';
                                        $gradeColor = 'info';
                                    } elseif ($nilai->nilai >= 70) {
                                        $grade = 'C';
                                        $gradeColor = 'warning';
                                    } elseif ($nilai->nilai >= 60) {
                                        $grade = 'D';
                                        $gradeColor = 'danger';
                                    } else {
                                        $grade = 'E';
                                        $gradeColor = 'dark';
                                    }
                                @endphp
                                <div class="nilai-card bg-{{ $gradeColor }} text-white p-4 rounded">
                                    <h1 class="display-1 mb-2">{{ $nilai->nilai }}</h1>
                                    <h3 class="mb-2">Grade: {{ $grade }}</h3>
                                    @if($nilai->nilai >= 75)
                                        <span class="badge bg-light text-dark fs-6">✓ Tuntas</span>
                                    @else
                                        <span class="badge bg-light text-dark fs-6">✗ Belum Tuntas</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="nilai-info">
                                <div class="info-item">
                                    <label class="text-muted">Tanggal Penilaian</label>
                                    <p class="mb-2">{{ \Carbon\Carbon::parse($nilai->tanggal_nilai)->format('d F Y') }}</p>
                                </div>
                                @if($nilai->keterangan)
                                <div class="info-item">
                                    <label class="text-muted">Keterangan</label>
                                    <p class="mb-2">{{ $nilai->keterangan }}</p>
                                </div>
                                @endif
                                <div class="info-item">
                                    <label class="text-muted">Status KKM</label>
                                    <p class="mb-0">
                                        @if($nilai->nilai >= 75)
                                            <span class="badge bg-success">Tuntas (≥ 75)</span>
                                        @else
                                            <span class="badge bg-danger">Belum Tuntas (< 75)</span>
                                            <br><small class="text-muted">Kurang {{ 75 - $nilai->nilai }} poin dari KKM</small>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Lainnya -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-chart-bar me-1"></i>
                        Nilai Lainnya untuk {{ $nilai->mata_pelajaran_nama }}
                    </div>
                    <div>
                        <span class="badge bg-primary">{{ $nilaiLainnya->count() }} Nilai</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($nilaiLainnya->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jenis Nilai</th>
                                        <th>Nilai</th>
                                        <th>Grade</th>
                                        <th>Semester</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiLainnya as $nl)
                                    <tr>
                                        <td>
                                            <span class="badge 
                                                @if($nl->jenis_nilai == 'UTS') bg-warning
                                                @elseif($nl->jenis_nilai == 'UAS') bg-danger
                                                @elseif($nl->jenis_nilai == 'Tugas') bg-info
                                                @elseif($nl->jenis_nilai == 'Kuis') bg-secondary
                                                @elseif($nl->jenis_nilai == 'Praktik') bg-success
                                                @else bg-primary
                                                @endif">
                                                {{ $nl->jenis_nilai }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="
                                                @if($nl->nilai >= 85) text-success
                                                @elseif($nl->nilai >= 75) text-warning
                                                @elseif($nl->nilai >= 60) text-info
                                                @else text-danger
                                                @endif">
                                                {{ $nl->nilai }}
                                            </strong>
                                        </td>
                                        <td>
                                            @php
                                                $nlGrade = '';
                                                $nlGradeColor = '';
                                                if ($nl->nilai >= 90) {
                                                    $nlGrade = 'A';
                                                    $nlGradeColor = 'success';
                                                } elseif ($nl->nilai >= 80) {
                                                    $nlGrade = 'B';
                                                    $nlGradeColor = 'info';
                                                } elseif ($nl->nilai >= 70) {
                                                    $nlGrade = 'C';
                                                    $nlGradeColor = 'warning';
                                                } elseif ($nl->nilai >= 60) {
                                                    $nlGrade = 'D';
                                                    $nlGradeColor = 'danger';
                                                } else {
                                                    $nlGrade = 'E';
                                                    $nlGradeColor = 'dark';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $nlGradeColor }}">{{ $nlGrade }}</span>
                                        </td>
                                        <td>{{ $nl->semester }}</td>
                                        <td>{{ \Carbon\Carbon::parse($nl->tanggal_nilai)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="/admin/nilai-siswa/{{ $nl->id }}" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Statistik Nilai -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-success mb-1">{{ number_format($statistik->rata_rata, 1) }}</h5>
                                    <small class="text-muted">Rata-rata</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-primary mb-1">{{ $statistik->nilai_tertinggi }}</h5>
                                    <small class="text-muted">Tertinggi</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-warning mb-1">{{ $statistik->nilai_terendah }}</h5>
                                    <small class="text-muted">Terendah</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <h5 class="text-info mb-1">{{ $statistik->total_nilai }}</h5>
                                    <small class="text-muted">Total Nilai</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Nilai Lainnya</h5>
                            <p class="text-muted">Ini adalah satu-satunya nilai untuk mata pelajaran {{ $nilai->mata_pelajaran_nama }}.</p>
                            <a href="/admin/nilai-siswa/create?siswa_id={{ $nilai->siswa_id }}&kelas_id={{ $nilai->kelas_id }}&mata_pelajaran_id={{ $nilai->mata_pelajaran_id }}" 
                               class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Nilai Lainnya
                            </a>
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
                        <a href="/admin/nilai-siswa/" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="/admin/nilai-siswa/{{ $nilai->id }}/edit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Nilai
                        </a>
                        <a href="/admin/nilai-siswa/create?siswa_id={{ $nilai->siswa_id }}&kelas_id={{ $nilai->kelas_id }}&mata_pelajaran_id={{ $nilai->mata_pelajaran_id }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Tambah Nilai Lainnya
                        </a>
                        <a href="/admin/keanggotaan-kelas/?siswa_id={{ $nilai->siswa_id }}" class="btn btn-outline-info">
                            <i class="fas fa-user"></i> Lihat Keanggotaan Siswa
                        </a>
                        <hr>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="confirmDelete({{ $nilai->id }}, '{{ $nilai->siswa_nama }}', '{{ $nilai->mata_pelajaran_nama }}', '{{ $nilai->jenis_nilai }}')">
                            <i class="fas fa-trash"></i> Hapus Nilai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Grade Analysis -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-analytics me-1"></i>
                    Analisis Grade
                </div>
                <div class="card-body">
                    <div class="grade-analysis">
                        @php
                            $progressPercentage = ($nilai->nilai / 100) * 100;
                            $kkm_percentage = 75;
                        @endphp
                        
                        <div class="mb-3">
                            <label class="form-label">Progress Nilai</label>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $gradeColor }}" 
                                     role="progressbar" 
                                     style="width: {{ $progressPercentage }}%"
                                     aria-valuenow="{{ $nilai->nilai }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $nilai->nilai }}%
                                </div>
                            </div>
                            <small class="text-muted">Dari maksimal 100 poin</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status KKM</label>
                            <div class="progress" style="height: 15px;">
                                <div class="progress-bar bg-warning" 
                                     role="progressbar" 
                                     style="width: 75%">
                                    KKM (75)
                                </div>
                                @if($nilai->nilai >= 75)
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $progressPercentage - 75 }}%">
                                        +{{ $nilai->nilai - 75 }}
                                    </div>
                                @endif
                            </div>
                            @if($nilai->nilai >= 75)
                                <small class="text-success">✓ Melampaui KKM sebesar {{ $nilai->nilai - 75 }} poin</small>
                            @else
                                <small class="text-danger">✗ Kurang {{ 75 - $nilai->nilai }} poin dari KKM</small>
                            @endif
                        </div>
                        
                        @if($statistik->total_nilai > 1)
                        <div class="mb-3">
                            <label class="form-label">Posisi dalam Mata Pelajaran</label>
                            @if($nilai->nilai >= $statistik->rata_rata)
                                <div class="alert alert-success">
                                    <i class="fas fa-arrow-up"></i> 
                                    <strong>Di Atas Rata-rata</strong>
                                    <br><small>+{{ number_format($nilai->nilai - $statistik->rata_rata, 1) }} dari rata-rata</small>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-arrow-down"></i> 
                                    <strong>Di Bawah Rata-rata</strong>
                                    <br><small>-{{ number_format($statistik->rata_rata - $nilai->nilai, 1) }} dari rata-rata</small>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Tambahan
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label class="text-muted">Dibuat</label>
                        <p class="mb-2">{{ \Carbon\Carbon::parse($nilai->created_at)->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <label class="text-muted">Terakhir Diubah</label>
                        <p class="mb-2">{{ \Carbon\Carbon::parse($nilai->updated_at)->format('d F Y, H:i') }}</p>
                    </div>
                    @if($nilai->created_at != $nilai->updated_at)
                        <div class="alert alert-info">
                            <small><i class="fas fa-history"></i> Nilai ini pernah diubah</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus nilai ini?</p>
                <div class="alert alert-info">
                    <strong>Detail Nilai:</strong>
                    <br><span id="nilaiDetails"></span>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Nilai</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-section {
    padding: 1.5rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    border-left: 4px solid #0d6efd;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
    display: block;
    font-weight: 600;
}

.info-item p {
    font-size: 1rem;
    margin-bottom: 0;
}

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

.nilai-card {
    background: linear-gradient(135deg, var(--bs-success) 0%, var(--bs-info) 100%);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.nilai-display {
    position: relative;
}

.grade-analysis .progress {
    background-color: #e9ecef;
}

.student-info {
    background-color: white;
    padding: 1.5rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
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

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id, siswa, mataPelajaran, jenisNilai) {
    document.getElementById('nilaiDetails').innerHTML = 
        `<strong>Siswa:</strong> ${siswa}<br>
         <strong>Mata Pelajaran:</strong> ${mataPelajaran}<br>
         <strong>Jenis Nilai:</strong> ${jenisNilai}`;
    document.getElementById('deleteForm').action = '/admin/nilai-siswa/' + id;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
