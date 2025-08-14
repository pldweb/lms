@extends('admin.layouts.app')

@section('title', 'Tambah Siswa ke Kelas')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Siswa ke Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/keanggotaan-kelas/">Keanggotaan Kelas</a></li>
        <li class="breadcrumb-item active">Tambah Siswa</li>
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
                    <i class="fas fa-user-plus me-1"></i>
                    Form Tambah Siswa ke Kelas
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/keanggotaan-kelas/" id="addStudentForm">
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
                                <div class="form-text">Pilih kelas untuk menambahkan siswa</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_bergabung" class="col-sm-3 col-form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tanggal_bergabung" 
                                       name="tanggal_bergabung" value="{{ old('tanggal_bergabung', date('Y-m-d')) }}" required>
                                <div class="form-text">Tanggal siswa bergabung ke kelas</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label">Siswa <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div id="studentSelection">
                                    @if($selectedKelasId)
                                        <!-- Student list akan dimuat via JavaScript -->
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            Pilih kelas terlebih dahulu untuk melihat daftar siswa yang tersedia
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary me-2" id="submitBtn" disabled>
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="/admin/keanggotaan-kelas/" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Kelas
                </div>
                <div class="card-body" id="kelasInfo">
                    <div class="text-muted text-center py-4">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                        <p>Pilih kelas untuk melihat informasi detail</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-1"></i>
                    Tips
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Anda dapat memilih beberapa siswa sekaligus
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Sistem akan mengecek kapasitas kelas secara otomatis
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Siswa yang sudah terdaftar tidak akan muncul dalam daftar
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Gunakan checkbox "Pilih Semua" untuk memilih semua siswa
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
.student-checkbox {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.student-checkbox:hover {
    border-color: #86b7fe;
    background-color: #f8f9fa;
}

.student-checkbox input[type="checkbox"]:checked + label .student-card {
    background-color: #e7f1ff;
    border-color: #0d6efd;
}

.student-card {
    border: 1px solid transparent;
    border-radius: 0.375rem;
    padding: 0.5rem;
    cursor: pointer;
}

.capacity-info {
    background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    color: white;
    border-radius: 0.375rem;
    padding: 1rem;
}

.capacity-warning {
    background: linear-gradient(90deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.capacity-danger {
    background: linear-gradient(90deg, #dc3545 0%, #e74c3c 100%);
    color: white;
}

.select-all-container {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-bottom: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelasSelect = document.getElementById('kelas_id');
    const studentSelection = document.getElementById('studentSelection');
    const kelasInfo = document.getElementById('kelasInfo');
    const submitBtn = document.getElementById('submitBtn');
    
    // Load initial data if kelas already selected
    if (kelasSelect.value) {
        loadStudents(kelasSelect.value);
        loadKelasInfo(kelasSelect.value);
    }
    
    kelasSelect.addEventListener('change', function() {
        const kelasId = this.value;
        if (kelasId) {
            loadStudents(kelasId);
            loadKelasInfo(kelasId);
        } else {
            studentSelection.innerHTML = `
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Pilih kelas terlebih dahulu untuk melihat daftar siswa yang tersedia
                </div>
            `;
            kelasInfo.innerHTML = `
                <div class="text-muted text-center py-4">
                    <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                    <p>Pilih kelas untuk melihat informasi detail</p>
                </div>
            `;
            submitBtn.disabled = true;
        }
    });
    
    function loadStudents(kelasId) {
        studentSelection.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div></div>';
        
        // Reload page with kelas_id parameter to get filtered students
        const url = new URL(window.location);
        url.searchParams.set('kelas_id', kelasId);
        
        fetch(`/admin/keanggotaan-kelas/create?kelas_id=${kelasId}`)
            .then(response => response.text())
            .then(html => {
                // Extract students data from the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const siswaData = doc.querySelector('script[data-siswa]');
                
                if (siswaData) {
                    const students = JSON.parse(siswaData.textContent);
                    renderStudents(students);
                } else {
                    // Fallback: reload page
                    window.location.href = url.toString();
                }
            })
            .catch(error => {
                studentSelection.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Gagal memuat data siswa. Silakan refresh halaman.
                    </div>
                `;
            });
    }
    
    function renderStudents(students) {
        if (students.length === 0) {
            studentSelection.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tidak ada siswa yang tersedia untuk kelas ini. Semua siswa mungkin sudah terdaftar.
                </div>
            `;
            submitBtn.disabled = true;
            return;
        }
        
        let html = `
            <div class="select-all-container">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label fw-bold" for="selectAll">
                        Pilih Semua Siswa (${students.length} tersedia)
                    </label>
                </div>
            </div>
            
            <div class="student-list" style="max-height: 400px; overflow-y: auto;">
        `;
        
        students.forEach(student => {
            html += `
                <div class="student-checkbox">
                    <div class="form-check">
                        <input class="form-check-input student-check" type="checkbox" 
                               value="${student.id}" name="siswa_ids[]" id="siswa_${student.id}">
                        <label class="form-check-label w-100" for="siswa_${student.id}">
                            <div class="student-card">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar-initial rounded-circle bg-primary">
                                            ${student.name.charAt(0)}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">${student.name}</h6>
                                        <small class="text-muted">${student.email}</small>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        studentSelection.innerHTML = html;
        
        // Setup event listeners
        setupStudentSelection();
    }
    
    function setupStudentSelection() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const studentCheckboxes = document.querySelectorAll('.student-check');
        
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSubmitButton();
        });
        
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectAllState();
                updateSubmitButton();
            });
        });
        
        updateSubmitButton();
    }
    
    function updateSelectAllState() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const studentCheckboxes = document.querySelectorAll('.student-check');
        const checkedCount = document.querySelectorAll('.student-check:checked').length;
        
        if (checkedCount === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCount === studentCheckboxes.length) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        }
    }
    
    function updateSubmitButton() {
        const checkedStudents = document.querySelectorAll('.student-check:checked');
        const kelasSelected = kelasSelect.value;
        
        submitBtn.disabled = !kelasSelected || checkedStudents.length === 0;
        
        if (checkedStudents.length > 0) {
            submitBtn.innerHTML = `
                <i class="fas fa-save"></i> 
                Tambahkan ${checkedStudents.length} Siswa ke Kelas
            `;
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan';
        }
    }
    
    function loadKelasInfo(kelasId) {
        // This would typically fetch from an API endpoint
        // For now, we'll use the data available in the select option
        const selectedOption = kelasSelect.options[kelasSelect.selectedIndex];
        const kelasText = selectedOption.text;
        
        kelasInfo.innerHTML = `
            <div class="capacity-info">
                <h6 class="mb-2"><i class="fas fa-chalkboard-teacher me-2"></i>Kelas Terpilih</h6>
                <p class="mb-0">${kelasText}</p>
            </div>
            
            <div class="mt-3">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h5 class="text-primary mb-1" id="currentCapacity">-</h5>
                            <small class="text-muted">Siswa Saat Ini</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success mb-1" id="maxCapacity">-</h5>
                        <small class="text-muted">Kapasitas Maksimal</small>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" id="capacityProgress" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Kapasitas Terisi</small>
            </div>
        `;
    }
});
</script>

<!-- Include students data for JavaScript -->
<script data-siswa type="application/json">
@json($siswa)
</script>
@endpush
