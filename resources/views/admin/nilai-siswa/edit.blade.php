@extends('admin.layouts.app')

@section('title', 'Edit Nilai Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Nilai Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/nilai-siswa/">Nilai Siswa</a></li>
        <li class="breadcrumb-item active">Edit Nilai</li>
    </ol>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Form Edit Nilai Siswa
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/nilai-siswa/{{ $nilai->id }}" id="nilaiForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Read-only Information -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Siswa</label>
                            <div class="col-sm-9">
                                <div class="form-control-plaintext">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-initial rounded-circle bg-primary">
                                                {{ substr($nilai->siswa_nama, 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <strong>{{ $nilai->siswa_nama }}</strong>
                                            <br><small class="text-muted">Tidak dapat diubah</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kelas</label>
                            <div class="col-sm-9">
                                <div class="form-control-plaintext">
                                    <span class="badge bg-info fs-6">
                                        {{ $nilai->jenjang }} {{ $nilai->tingkat }} {{ $nilai->kelas_nama }}
                                    </span>
                                    @if($nilai->tahun_ajaran_nama)
                                        <span class="badge bg-secondary">{{ $nilai->tahun_ajaran_nama }}</span>
                                    @endif
                                    <br><small class="text-muted">Tidak dapat diubah</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Mata Pelajaran</label>
                            <div class="col-sm-9">
                                <div class="form-control-plaintext">
                                    <strong>{{ $nilai->mata_pelajaran_nama }}</strong>
                                    <span class="badge bg-secondary">{{ $nilai->mata_pelajaran_kode }}</span>
                                    <br><small class="text-muted">Tidak dapat diubah</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Editable Fields -->
                        <div class="row mb-3">
                            <label for="jenis_nilai" class="col-sm-3 col-form-label">Jenis Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="jenis_nilai" name="jenis_nilai" required>
                                    <option value="">Pilih Jenis Nilai</option>
                                    <option value="UTS" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'UTS' ? 'selected' : '' }}>UTS (Ujian Tengah Semester)</option>
                                    <option value="UAS" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'UAS' ? 'selected' : '' }}>UAS (Ujian Akhir Semester)</option>
                                    <option value="Tugas" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                    <option value="Kuis" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                                    <option value="Praktik" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'Praktik' ? 'selected' : '' }}>Praktik/Praktek</option>
                                    <option value="Lainnya" {{ old('jenis_nilai', $nilai->jenis_nilai) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <div class="form-text">Ubah jenis penilaian jika diperlukan</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="semester" class="col-sm-3 col-form-label">Semester <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester', $nilai->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $nilai->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                <div class="form-text">Pilih semester akademik</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nilai" class="col-sm-3 col-form-label">Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="nilai" 
                                           name="nilai" value="{{ old('nilai', $nilai->nilai) }}" 
                                           min="0" max="100" step="0.1" required>
                                    <span class="input-group-text">/ 100</span>
                                </div>
                                <div class="form-text">Masukkan nilai dengan skala 0-100</div>
                                <div id="gradePreview" class="mt-2"></div>
                                <div id="nilaiComparison" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_nilai" class="col-sm-3 col-form-label">Tanggal Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tanggal_nilai" 
                                       name="tanggal_nilai" value="{{ old('tanggal_nilai', $nilai->tanggal_nilai) }}" required>
                                <div class="form-text">Tanggal penilaian dilakukan</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                          placeholder="Keterangan tambahan tentang nilai...">{{ old('keterangan', $nilai->keterangan) }}</textarea>
                                <div class="form-text">Catatan tambahan tentang penilaian (opsional)</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-warning me-2">
                                    <i class="fas fa-save"></i> Update Nilai
                                </button>
                                <a href="/admin/nilai-siswa/" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="/admin/nilai-siswa/{{ $nilai->id }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Value Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Nilai Saat Ini
                </div>
                <div class="card-body">
                    <div class="current-value-info">
                        <div class="text-center mb-3">
                            @php
                                $currentGrade = '';
                                $currentGradeColor = '';
                                if ($nilai->nilai >= 90) {
                                    $currentGrade = 'A';
                                    $currentGradeColor = 'success';
                                } elseif ($nilai->nilai >= 80) {
                                    $currentGrade = 'B';
                                    $currentGradeColor = 'info';
                                } elseif ($nilai->nilai >= 70) {
                                    $currentGrade = 'C';
                                    $currentGradeColor = 'warning';
                                } elseif ($nilai->nilai >= 60) {
                                    $currentGrade = 'D';
                                    $currentGradeColor = 'danger';
                                } else {
                                    $currentGrade = 'E';
                                    $currentGradeColor = 'dark';
                                }
                            @endphp
                            <h2 class="text-{{ $currentGradeColor }} mb-1">{{ $currentGrade }}</h2>
                            <h4 class="text-{{ $currentGradeColor }} mb-2">{{ $nilai->nilai }}</h4>
                            @if($nilai->nilai >= 75)
                                <span class="badge bg-success">Tuntas</span>
                            @else
                                <span class="badge bg-danger">Belum Tuntas</span>
                            @endif
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <strong>{{ $nilai->jenis_nilai }}</strong>
                                    <br><small class="text-muted">Jenis</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <strong>{{ $nilai->semester }}</strong>
                                <br><small class="text-muted">Semester</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Scale Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-1"></i>
                    Skala Penilaian
                </div>
                <div class="card-body">
                    <div class="grade-scale">
                        <div class="grade-item">
                            <span class="badge bg-success me-2">A</span>
                            <span>90 - 100</span>
                            <small class="text-muted d-block">Sangat Baik</small>
                        </div>
                        <div class="grade-item">
                            <span class="badge bg-info me-2">B</span>
                            <span>80 - 89</span>
                            <small class="text-muted d-block">Baik</small>
                        </div>
                        <div class="grade-item">
                            <span class="badge bg-warning me-2">C</span>
                            <span>70 - 79</span>
                            <small class="text-muted d-block">Cukup</small>
                        </div>
                        <div class="grade-item">
                            <span class="badge bg-danger me-2">D</span>
                            <span>60 - 69</span>
                            <small class="text-muted d-block">Kurang</small>
                        </div>
                        <div class="grade-item">
                            <span class="badge bg-dark me-2">E</span>
                            <span>0 - 59</span>
                            <small class="text-muted d-block">Sangat Kurang</small>
                        </div>
                    </div>
                    <hr>
                    <div class="kkm-info">
                        <strong class="text-warning">KKM (Kriteria Ketuntasan Minimal):</strong>
                        <div class="mt-2">
                            <span class="badge bg-warning">75</span>
                            <small class="text-muted">Nilai minimum untuk dinyatakan tuntas</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Riwayat Perubahan
                </div>
                <div class="card-body">
                    <div class="history-item">
                        <div class="row mb-2">
                            <div class="col-4"><strong>Dibuat:</strong></div>
                            <div class="col-8">{{ \Carbon\Carbon::parse($nilai->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Diubah:</strong></div>
                            <div class="col-8">{{ \Carbon\Carbon::parse($nilai->updated_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        @if($nilai->created_at != $nilai->updated_at)
                            <div class="alert alert-info mt-2">
                                <small><i class="fas fa-info-circle"></i> Nilai ini pernah diubah sebelumnya</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-1"></i>
                    Tips Edit Nilai
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan perubahan nilai sudah sesuai dengan hasil penilaian
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Jenis nilai dan semester bisa diubah jika tidak bentrok
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Sistem akan mengecek duplikasi otomatis
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Gunakan keterangan untuk mencatat alasan perubahan
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Informasikan perubahan kepada siswa jika diperlukan
                        </li>
                    </ul>
                </div>
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

.grade-scale {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.grade-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
}

.grade-preview {
    padding: 1rem;
    border-radius: 0.375rem;
    text-align: center;
    font-weight: bold;
    margin-top: 0.5rem;
    transition: all 0.3s ease;
}

.nilai-comparison {
    padding: 0.75rem;
    border-radius: 0.375rem;
    border-left: 4px solid #0d6efd;
    background-color: #e7f1ff;
    margin-top: 0.5rem;
}

.kkm-info {
    background-color: #fff3cd;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 4px solid #ffc107;
}

.current-value-info {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.375rem;
    border-left: 4px solid #0d6efd;
}

.history-item {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-control-plaintext {
    padding: 0.375rem 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nilaiInput = document.getElementById('nilai');
    const gradePreview = document.getElementById('gradePreview');
    const nilaiComparison = document.getElementById('nilaiComparison');
    const originalNilai = {{ $nilai->nilai }};
    
    // Update grade preview when nilai changes
    nilaiInput.addEventListener('input', function() {
        updateGradePreview(this.value);
        updateNilaiComparison(this.value);
    });
    
    // Initialize with current value
    if (nilaiInput.value) {
        updateGradePreview(nilaiInput.value);
        updateNilaiComparison(nilaiInput.value);
    }
    
    function updateGradePreview(nilai) {
        if (!nilai || nilai === '') {
            gradePreview.innerHTML = '';
            return;
        }
        
        const numNilai = parseFloat(nilai);
        const grade = getGrade(numNilai);
        const gradeColor = getGradeColor(numNilai);
        
        let status = '';
        if (numNilai >= 75) {
            status = '<span class="badge bg-success ms-2">Tuntas</span>';
        } else {
            status = '<span class="badge bg-danger ms-2">Belum Tuntas</span>';
        }
        
        gradePreview.innerHTML = `
            <div class="grade-preview bg-${gradeColor === 'dark' ? 'secondary' : gradeColor} text-white">
                <h5 class="mb-1">Grade Baru: ${grade}</h5>
                <p class="mb-0">Nilai: ${numNilai} ${status}</p>
            </div>
        `;
    }
    
    function updateNilaiComparison(nilai) {
        if (!nilai || nilai === '' || parseFloat(nilai) === originalNilai) {
            nilaiComparison.innerHTML = '';
            return;
        }
        
        const numNilai = parseFloat(nilai);
        const difference = numNilai - originalNilai;
        const isIncrease = difference > 0;
        const arrow = isIncrease ? '↗' : '↘';
        const color = isIncrease ? 'success' : 'danger';
        const text = isIncrease ? 'Naik' : 'Turun';
        
        nilaiComparison.innerHTML = `
            <div class="nilai-comparison">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Perbandingan:</strong>
                        <br><small class="text-muted">Nilai lama: ${originalNilai}</small>
                    </div>
                    <div class="text-${color}">
                        <span class="fs-4">${arrow}</span>
                        <div><strong>${text} ${Math.abs(difference).toFixed(1)} poin</strong></div>
                    </div>
                </div>
            </div>
        `;
    }
    
    function getGrade(nilai) {
        if (nilai >= 90) return 'A';
        if (nilai >= 80) return 'B';
        if (nilai >= 70) return 'C';
        if (nilai >= 60) return 'D';
        return 'E';
    }
    
    function getGradeColor(nilai) {
        if (nilai >= 90) return 'success';
        if (nilai >= 80) return 'info';
        if (nilai >= 70) return 'warning';
        if (nilai >= 60) return 'danger';
        return 'dark';
    }
});
</script>
@endpush
