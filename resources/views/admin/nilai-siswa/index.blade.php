@extends('admin.layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Nilai Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item active">Nilai Siswa</li>
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

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-line me-1"></i>
            Data Nilai Siswa
            <div class="float-end">
                <a href="/admin/nilai-siswa/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Nilai
                </a>
                <button type="button" class="btn btn-success btn-sm" onclick="exportData()">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Nama siswa/mata pelajaran..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->jenjang }} {{ $k->tingkat }} {{ $k->nama }} 
                                        @if($k->tahun_ajaran) ({{ $k->tahun_ajaran }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" class="form-select">
                                <option value="">Semua Mapel</option>
                                @foreach($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}" {{ request('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                        {{ $mp->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jenis Nilai</label>
                            <select name="jenis_nilai" class="form-select">
                                <option value="">Semua Jenis</option>
                                <option value="UTS" {{ request('jenis_nilai') == 'UTS' ? 'selected' : '' }}>UTS</option>
                                <option value="UAS" {{ request('jenis_nilai') == 'UAS' ? 'selected' : '' }}>UAS</option>
                                <option value="Tugas" {{ request('jenis_nilai') == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                <option value="Kuis" {{ request('jenis_nilai') == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                                <option value="Praktik" {{ request('jenis_nilai') == 'Praktik' ? 'selected' : '' }}>Praktik</option>
                                <option value="Lainnya" {{ request('jenis_nilai') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="">Semua Semester</option>
                                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(request()->hasAny(['search', 'kelas_id', 'mata_pelajaran_id', 'jenis_nilai', 'semester']))
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a href="/admin/nilai-siswa/" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times"></i> Reset Filter
                        </a>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Jenis Nilai</th>
                            <th>Nilai</th>
                            <th>Grade</th>
                            <th>Semester</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilaiSiswa as $index => $item)
                        <tr>
                            <td>{{ ($nilaiSiswa->currentPage() - 1) * $nilaiSiswa->perPage() + $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-initial rounded-circle bg-primary">
                                            {{ substr($item->siswa_nama, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $item->siswa_nama }}</h6>
                                        <small class="text-muted">{{ $item->siswa_email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $item->jenjang }} {{ $item->tingkat }} {{ $item->kelas_nama }}
                                </span>
                                @if($item->tahun_ajaran_nama)
                                    <br><small class="text-muted">{{ $item->tahun_ajaran_nama }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->mata_pelajaran_nama }}</strong>
                                <br><small class="text-muted">{{ $item->mata_pelajaran_kode }}</small>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($item->jenis_nilai == 'UTS') bg-warning
                                    @elseif($item->jenis_nilai == 'UAS') bg-danger
                                    @elseif($item->jenis_nilai == 'Tugas') bg-info
                                    @elseif($item->jenis_nilai == 'Kuis') bg-secondary
                                    @elseif($item->jenis_nilai == 'Praktik') bg-success
                                    @else bg-primary
                                    @endif">
                                    {{ $item->jenis_nilai }}
                                </span>
                            </td>
                            <td>
                                <strong class="fs-5 
                                    @if($item->nilai >= 85) text-success
                                    @elseif($item->nilai >= 75) text-warning
                                    @elseif($item->nilai >= 60) text-info
                                    @else text-danger
                                    @endif">
                                    {{ $item->nilai }}
                                </strong>
                            </td>
                            <td>
                                @php
                                    $grade = '';
                                    $gradeColor = '';
                                    if ($item->nilai >= 90) {
                                        $grade = 'A';
                                        $gradeColor = 'success';
                                    } elseif ($item->nilai >= 80) {
                                        $grade = 'B';
                                        $gradeColor = 'info';
                                    } elseif ($item->nilai >= 70) {
                                        $grade = 'C';
                                        $gradeColor = 'warning';
                                    } elseif ($item->nilai >= 60) {
                                        $grade = 'D';
                                        $gradeColor = 'danger';
                                    } else {
                                        $grade = 'E';
                                        $gradeColor = 'dark';
                                    }
                                @endphp
                                <span class="badge bg-{{ $gradeColor }} fs-6">{{ $grade }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->semester }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_nilai)->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/admin/nilai-siswa/{{ $item->id }}" 
                                       class="btn btn-outline-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/nilai-siswa/{{ $item->id }}/edit" 
                                       class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->siswa_nama }}', '{{ $item->mata_pelajaran_nama }}', '{{ $item->jenis_nilai }}')" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <h5>Tidak ada data nilai siswa</h5>
                                    <p>Silakan tambah nilai siswa terlebih dahulu</p>
                                    <a href="/admin/nilai-siswa/create" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Nilai
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($nilaiSiswa->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $nilaiSiswa->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Statistik Nilai -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Nilai</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $nilaiSiswa->total() }}</div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata Nilai</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $nilaiSiswa->count() > 0 ? number_format($nilaiSiswa->avg('nilai'), 1) : 0 }}
                            </div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-calculator"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Di Atas KKM (75)</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $nilaiSiswa->where('nilai', '>=', 75)->count() }}
                            </div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Di Bawah KKM (75)</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $nilaiSiswa->where('nilai', '<', 75)->count() }}
                            </div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>
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
}

.table-responsive {
    border-radius: 0.375rem;
    overflow: hidden;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.grade-A { color: #198754; }
.grade-B { color: #0dcaf0; }
.grade-C { color: #ffc107; }
.grade-D { color: #fd7e14; }
.grade-E { color: #dc3545; }
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

function exportData() {
    // Get current filter parameters
    const params = new URLSearchParams(window.location.search);
    const exportUrl = `/admin/nilai-siswa/export?${params.toString()}`;
    
    // Create temporary link and download
    const link = document.createElement('a');
    link.href = exportUrl;
    link.download = 'nilai-siswa.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Auto-submit form ketika filter berubah
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = document.querySelectorAll('select[name="kelas_id"], select[name="mata_pelajaran_id"], select[name="jenis_nilai"], select[name="semester"]');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
