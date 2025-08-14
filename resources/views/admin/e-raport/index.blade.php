@extends('admin.layouts.app')

@section('title', 'E-Raport - Laporan Nilai Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">E-Raport - Laporan Nilai Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item active">E-Raport</li>
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

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter E-Raport
        </div>
        <div class="card-body">
            <form method="GET" action="/admin/e-raport/" id="filterForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required onchange="handleKelasChange()">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $kelas_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->jenjang }} {{ $k->tingkat }} {{ $k->nama }} ({{ $k->tahun_ajaran_nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-select" id="semester" name="semester" onchange="handleSemesterChange()">
                                <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                @if($kelas_id && $siswa->count() > 0)
                                    <button type="button" class="btn btn-success" onclick="downloadClassPDF()">
                                        <i class="fas fa-download"></i> PDF Kelas
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-success" disabled>
                                        <i class="fas fa-download"></i> PDF Kelas
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($kelas_id)
        <!-- Statistik Kelas -->
        <div class="row mb-4" id="kelasStatsSection">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-chart-bar me-1"></i>
                            Statistik Kelas - Semester {{ $semester }}
                        </div>
                        <button class="btn btn-outline-primary btn-sm" onclick="refreshStats()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body" id="statsContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Memuat statistik kelas...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Siswa -->
        @if($siswa->count() > 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-1"></i>
                        Daftar Siswa ({{ $siswa->count() }} siswa)
                    </div>
                    <div>
                        <span class="badge bg-info">Semester {{ $semester }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="siswaTable">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Email</th>
                                    <th>Total Nilai</th>
                                    <th>Rata-rata</th>
                                    <th>Tuntas</th>
                                    <th>Belum Tuntas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswa as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-initial rounded-circle bg-primary">
                                                    {{ substr($s->siswa_nama, 0, 2) }}
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $s->siswa_nama }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $s->siswa_email }}</td>
                                    <td>
                                        @if($s->statistik->total_nilai > 0)
                                            <span class="badge bg-info">{{ $s->statistik->total_nilai }}</span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->statistik->total_nilai > 0)
                                            @php
                                                $rataRata = $s->statistik->rata_rata;
                                                $badgeClass = '';
                                                if ($rataRata >= 85) $badgeClass = 'bg-success';
                                                elseif ($rataRata >= 75) $badgeClass = 'bg-warning';
                                                elseif ($rataRata >= 60) $badgeClass = 'bg-info';
                                                else $badgeClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ number_format($rataRata, 1) }}</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->statistik->tuntas > 0)
                                            <span class="badge bg-success">{{ $s->statistik->tuntas }}</span>
                                        @else
                                            <span class="badge bg-light text-dark">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->statistik->belum_tuntas > 0)
                                            <span class="badge bg-danger">{{ $s->statistik->belum_tuntas }}</span>
                                        @else
                                            <span class="badge bg-light text-dark">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($s->statistik->total_nilai > 0)
                                                <a href="/admin/e-raport/preview/{{ $s->siswa_id }}?kelas_id={{ $kelas_id }}&semester={{ $semester }}" 
                                                   class="btn btn-outline-info btn-sm" title="Preview Raport">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/e-raport/download/{{ $s->siswa_id }}?kelas_id={{ $kelas_id }}&semester={{ $semester }}" 
                                                   class="btn btn-outline-success btn-sm" title="Download PDF">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-outline-secondary btn-sm" disabled title="Tidak ada nilai">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary btn-sm" disabled title="Tidak ada nilai">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            @endif
                                            <a href="/admin/nilai-siswa/create?siswa_id={{ $s->siswa_id }}&kelas_id={{ $kelas_id }}" 
                                               class="btn btn-outline-primary btn-sm" title="Tambah Nilai">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Siswa</h5>
                    <p class="text-muted">Belum ada siswa yang terdaftar di kelas ini.</p>
                    <a href="/admin/keanggotaan-kelas/create?kelas_id={{ $kelas_id }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Anggota Kelas
                    </a>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-filter fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Pilih Kelas</h5>
                <p class="text-muted">Silakan pilih kelas terlebih dahulu untuk melihat data E-Raport siswa.</p>
            </div>
        </div>
    @endif
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mb-0">Sedang memproses...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 0.875rem;
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

.btn-group .btn {
    margin-right: 2px;
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    background: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-item h3 {
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
    font-weight: bold;
}

.stat-item p {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
let kelasId = {{ $kelas_id ?: 'null' }};
let semester = {{ $semester }};

function handleKelasChange() {
    const form = document.getElementById('filterForm');
    form.submit();
}

function handleSemesterChange() {
    const form = document.getElementById('filterForm');
    form.submit();
}

function downloadClassPDF() {
    if (!kelasId) {
        alert('Silakan pilih kelas terlebih dahulu!');
        return;
    }
    
    showLoadingModal();
    
    const url = `/admin/e-raport/download-class?kelas_id=${kelasId}&semester=${semester}`;
    const link = document.createElement('a');
    link.href = url;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    setTimeout(() => {
        hideLoadingModal();
    }, 2000);
}

function showLoadingModal() {
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
}

function hideLoadingModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
    if (modal) {
        modal.hide();
    }
}

function refreshStats() {
    if (!kelasId) return;
    
    const statsContent = document.getElementById('statsContent');
    statsContent.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat statistik kelas...</p>
        </div>
    `;
    
    loadKelasStats();
}

function loadKelasStats() {
    if (!kelasId) return;
    
    fetch(`/admin/e-raport/kelas-stats?kelas_id=${kelasId}&semester=${semester}`)
        .then(response => response.json())
        .then(data => {
            displayStats(data);
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            document.getElementById('statsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gagal memuat statistik kelas. Silakan refresh halaman.
                </div>
            `;
        });
}

function displayStats(data) {
    const stats = data.statistik_umum;
    const grades = data.distribusi_grade;
    const mapelStats = data.mata_pelajaran_stats;
    
    const tuntas = stats.total_tuntas || 0;
    const belumTuntas = stats.total_belum_tuntas || 0;
    const persentaseTuntas = stats.total_nilai > 0 ? ((tuntas / stats.total_nilai) * 100).toFixed(1) : 0;
    
    let statsHtml = `
        <div class="stats-grid">
            <div class="stat-item">
                <h3 class="text-primary">${stats.total_siswa || 0}</h3>
                <p>Total Siswa</p>
            </div>
            <div class="stat-item">
                <h3 class="text-info">${stats.total_nilai || 0}</h3>
                <p>Total Nilai</p>
            </div>
            <div class="stat-item">
                <h3 class="text-success">${stats.rata_rata_kelas ? parseFloat(stats.rata_rata_kelas).toFixed(1) : 0}</h3>
                <p>Rata-rata Kelas</p>
            </div>
            <div class="stat-item">
                <h3 class="text-warning">${stats.nilai_tertinggi || 0}</h3>
                <p>Nilai Tertinggi</p>
            </div>
            <div class="stat-item">
                <h3 class="text-danger">${stats.nilai_terendah || 0}</h3>
                <p>Nilai Terendah</p>
            </div>
            <div class="stat-item">
                <h3 class="text-success">${persentaseTuntas}%</h3>
                <p>Persentase Tuntas</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-3">Distribusi Grade</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <td><span class="badge bg-success">A (90-100)</span></td>
                            <td><strong>${grades.grade_a || 0}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">B (80-89)</span></td>
                            <td><strong>${grades.grade_b || 0}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning">C (70-79)</span></td>
                            <td><strong>${grades.grade_c || 0}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">D (60-69)</span></td>
                            <td><strong>${grades.grade_d || 0}</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-dark">E (<60)</span></td>
                            <td><strong>${grades.grade_e || 0}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="mb-3">Top 5 Mata Pelajaran</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Rata-rata</th>
                                <th>Tuntas</th>
                            </tr>
                        </thead>
                        <tbody>
    `;
    
    if (mapelStats && mapelStats.length > 0) {
        mapelStats.slice(0, 5).forEach(mapel => {
            const persentaseTuntasMapel = mapel.total_nilai > 0 ? ((mapel.tuntas / mapel.total_nilai) * 100).toFixed(0) : 0;
            statsHtml += `
                <tr>
                    <td>
                        <strong>${mapel.mata_pelajaran}</strong>
                        <br><small class="text-muted">${mapel.kode}</small>
                    </td>
                    <td>
                        <span class="badge ${mapel.rata_rata >= 75 ? 'bg-success' : 'bg-warning'}">
                            ${parseFloat(mapel.rata_rata).toFixed(1)}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">${persentaseTuntasMapel}%</span>
                    </td>
                </tr>
            `;
        });
    } else {
        statsHtml += `
            <tr>
                <td colspan="3" class="text-center text-muted">Belum ada data nilai</td>
            </tr>
        `;
    }
    
    statsHtml += `
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('statsContent').innerHTML = statsHtml;
}

// Load stats saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    if (kelasId) {
        loadKelasStats();
    }
});
</script>
@endpush
