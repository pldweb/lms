@extends('admin.layouts.app')

@section('title', 'Tambah Nilai Siswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Nilai Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/nilai-siswa/">Nilai Siswa</a></li>
        <li class="breadcrumb-item active">Tambah Nilai</li>
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
                    <i class="fas fa-chart-line me-1"></i>
                    Form Tambah Nilai Siswa
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/nilai-siswa/" id="nilaiForm">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="kelas_id" class="col-sm-3 col-form-label">Kelas <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="kelas_id" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" 
                                                {{ $selectedKelasId == $k->id ? 'selected' : '' }}
                                                {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->jenjang }} {{ $k->tingkat }} {{ $k->nama }} 
                                            @if($k->tahun_ajaran) ({{ $k->tahun_ajaran }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih kelas siswa</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="siswa_id" class="col-sm-3 col-form-label">Siswa <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="siswa_id" name="siswa_id" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswa as $s)
                                        <option value="{{ $s->id }}" 
                                                {{ $selectedSiswaId == $s->id ? 'selected' : '' }}
                                                {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }} ({{ $s->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih siswa yang akan dinilai</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mata_pelajaran_id" class="col-sm-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mataPelajaran as $mp)
                                        <option value="{{ $mp->id }}" 
                                                {{ $selectedMataPelajaranId == $mp->id ? 'selected' : '' }}
                                                {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama }} ({{ $mp->kode }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih mata pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis_nilai" class="col-sm-3 col-form-label">Jenis Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="jenis_nilai" name="jenis_nilai" required>
                                    <option value="">Pilih Jenis Nilai</option>
                                    <option value="UTS" {{ old('jenis_nilai') == 'UTS' ? 'selected' : '' }}>UTS (Ujian Tengah Semester)</option>
                                    <option value="UAS" {{ old('jenis_nilai') == 'UAS' ? 'selected' : '' }}>UAS (Ujian Akhir Semester)</option>
                                    <option value="Tugas" {{ old('jenis_nilai') == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                    <option value="Kuis" {{ old('jenis_nilai') == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                                    <option value="Praktik" {{ old('jenis_nilai') == 'Praktik' ? 'selected' : '' }}>Praktik/Praktek</option>
                                    <option value="Lainnya" {{ old('jenis_nilai') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <div class="form-text">Pilih jenis penilaian</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="semester" class="col-sm-3 col-form-label">Semester <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                <div class="form-text">Pilih semester akademik</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nilai" class="col-sm-3 col-form-label">Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="nilai" 
                                           name="nilai" value="{{ old('nilai') }}" 
                                           min="0" max="100" step="0.1" required>
                                    <span class="input-group-text">/ 100</span>
                                </div>
                                <div class="form-text">Masukkan nilai dengan skala 0-100</div>
                                <div id="gradePreview" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_nilai" class="col-sm-3 col-form-label">Tanggal Nilai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tanggal_nilai" 
                                       name="tanggal_nilai" value="{{ old('tanggal_nilai', date('Y-m-d')) }}" required>
                                <div class="form-text">Tanggal penilaian dilakukan</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                          placeholder="Keterangan tambahan tentang nilai...">{{ old('keterangan') }}</textarea>
                                <div class="form-text">Catatan tambahan tentang penilaian (opsional)</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-save"></i> Simpan Nilai
                                </button>
                                <a href="/admin/nilai-siswa/" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
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

            <!-- Student Info -->
            <div class="card mb-3" id="studentInfo" style="display: none;">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Informasi Siswa
                </div>
                <div class="card-body" id="studentInfoContent">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>

            <!-- Existing Grades -->
            <div class="card mb-3" id="existingGrades" style="display: none;">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Nilai yang Sudah Ada
                </div>
                <div class="card-body" id="existingGradesContent">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>

            <!-- Tips -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-1"></i>
                    Tips Penilaian
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan siswa terdaftar di kelas yang dipilih
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Nilai harus berada dalam rentang 0-100
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Sistem akan mengecek duplikasi nilai otomatis
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            KKM standar adalah 75, sesuaikan dengan kebijakan sekolah
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Gunakan keterangan untuk memberikan feedback tambahan
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
}

.kkm-info {
    background-color: #fff3cd;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 4px solid #ffc107;
}

.existing-grade-item {
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 0.375rem;
    background-color: #e7f1ff;
    border-left: 3px solid #0d6efd;
}

.student-info-card {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 4px solid #28a745;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

#gradePreview {
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelasSelect = document.getElementById('kelas_id');
    const siswaSelect = document.getElementById('siswa_id');
    const mataPelajaranSelect = document.getElementById('mata_pelajaran_id');
    const nilaiInput = document.getElementById('nilai');
    const gradePreview = document.getElementById('gradePreview');
    
    // Load siswa when kelas changes
    kelasSelect.addEventListener('change', function() {
        const kelasId = this.value;
        
        if (kelasId) {
            loadSiswa(kelasId);
        } else {
            siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
            hideStudentInfo();
        }
    });
    
    // Show student info when siswa changes
    siswaSelect.addEventListener('change', function() {
        if (this.value && mataPelajaranSelect.value) {
            showStudentInfo();
            loadExistingGrades();
        } else {
            hideStudentInfo();
        }
    });
    
    // Load existing grades when mata pelajaran changes
    mataPelajaranSelect.addEventListener('change', function() {
        if (siswaSelect.value && this.value) {
            loadExistingGrades();
        }
    });
    
    // Update grade preview when nilai changes
    nilaiInput.addEventListener('input', function() {
        updateGradePreview(this.value);
    });
    
    // Load initial data if pre-selected
    if (kelasSelect.value) {
        loadSiswa(kelasSelect.value);
        if (siswaSelect.value && mataPelajaranSelect.value) {
            showStudentInfo();
            loadExistingGrades();
        }
    }
    
    if (nilaiInput.value) {
        updateGradePreview(nilaiInput.value);
    }
    
    function loadSiswa(kelasId) {
        siswaSelect.innerHTML = '<option value="">Loading...</option>';
        
        fetch(`/admin/nilai-siswa/siswa-by-kelas/${kelasId}`)
            .then(response => response.json())
            .then(siswa => {
                let options = '<option value="">Pilih Siswa</option>';
                siswa.forEach(s => {
                    const selected = s.id == {{ $selectedSiswaId ?? 'null' }} ? 'selected' : '';
                    options += `<option value="${s.id}" ${selected}>${s.name} (${s.email})</option>`;
                });
                siswaSelect.innerHTML = options;
                
                if (siswa.length === 0) {
                    siswaSelect.innerHTML = '<option value="">Tidak ada siswa di kelas ini</option>';
                }
            })
            .catch(error => {
                siswaSelect.innerHTML = '<option value="">Error loading siswa</option>';
                console.error('Error:', error);
            });
    }
    
    function showStudentInfo() {
        const selectedSiswa = siswaSelect.options[siswaSelect.selectedIndex];
        const selectedKelas = kelasSelect.options[kelasSelect.selectedIndex];
        
        if (selectedSiswa.value && selectedKelas.value) {
            const content = `
                <div class="student-info-card">
                    <h6 class="mb-2">${selectedSiswa.text}</h6>
                    <p class="mb-1"><strong>Kelas:</strong> ${selectedKelas.text}</p>
                    <p class="mb-0"><small class="text-muted">Pastikan data siswa dan kelas sudah benar</small></p>
                </div>
            `;
            
            document.getElementById('studentInfoContent').innerHTML = content;
            document.getElementById('studentInfo').style.display = 'block';
        }
    }
    
    function hideStudentInfo() {
        document.getElementById('studentInfo').style.display = 'none';
        document.getElementById('existingGrades').style.display = 'none';
    }
    
    function loadExistingGrades() {
        const siswaId = siswaSelect.value;
        const mataPelajaranId = mataPelajaranSelect.value;
        const kelasId = kelasSelect.value;
        
        if (!siswaId || !mataPelajaranId || !kelasId) return;
        
        const url = `/admin/nilai-siswa/laporan-siswa/${siswaId}?kelas_id=${kelasId}&mata_pelajaran_id=${mataPelajaranId}`;
        
        fetch(url)
            .then(response => response.json())
            .then(nilai => {
                if (nilai.length > 0) {
                    let content = '';
                    nilai.forEach(n => {
                        const gradeClass = getGradeClass(n.nilai);
                        const grade = getGrade(n.nilai);
                        
                        content += `
                            <div class="existing-grade-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-primary">${n.jenis_nilai}</span>
                                        <span class="badge bg-secondary">${n.semester}</span>
                                    </div>
                                    <div>
                                        <strong class="${gradeClass}">${n.nilai}</strong>
                                        <span class="badge bg-${getGradeColor(n.nilai)} ms-1">${grade}</span>
                                    </div>
                                </div>
                                <small class="text-muted">${formatDate(n.tanggal_nilai)}</small>
                            </div>
                        `;
                    });
                    
                    document.getElementById('existingGradesContent').innerHTML = content;
                    document.getElementById('existingGrades').style.display = 'block';
                } else {
                    document.getElementById('existingGrades').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading existing grades:', error);
            });
    }
    
    function updateGradePreview(nilai) {
        if (!nilai || nilai === '') {
            gradePreview.innerHTML = '';
            return;
        }
        
        const numNilai = parseFloat(nilai);
        const grade = getGrade(numNilai);
        const gradeColor = getGradeColor(numNilai);
        const gradeClass = getGradeClass(numNilai);
        
        let status = '';
        if (numNilai >= 75) {
            status = '<span class="badge bg-success ms-2">Tuntas</span>';
        } else {
            status = '<span class="badge bg-danger ms-2">Belum Tuntas</span>';
        }
        
        gradePreview.innerHTML = `
            <div class="grade-preview bg-${gradeColor === 'dark' ? 'secondary' : gradeColor} text-white">
                <h4 class="mb-1">Grade: ${grade}</h4>
                <p class="mb-0">Nilai: ${numNilai} ${status}</p>
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
    
    function getGradeClass(nilai) {
        if (nilai >= 85) return 'text-success';
        if (nilai >= 75) return 'text-warning';
        if (nilai >= 60) return 'text-info';
        return 'text-danger';
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }
});
</script>
@endpush
