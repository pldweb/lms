@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal Pelajaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Jadwal Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/jadwal-pelajaran/">Jadwal Pelajaran</a></li>
        <li class="breadcrumb-item active">Tambah Jadwal</li>
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
                    <i class="fas fa-calendar-plus me-1"></i>
                    Form Tambah Jadwal Pelajaran
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/jadwal-pelajaran/" id="jadwalForm">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="kelas_id" class="col-sm-3 col-form-label">Kelas <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="kelas_id" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->jenjang }} {{ $k->tingkat }} {{ $k->nama }} 
                                            @if($k->tahun_ajaran) ({{ $k->tahun_ajaran }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih kelas untuk jadwal pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mata_pelajaran_id" class="col-sm-3 col-form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($mataPelajaran as $mp)
                                        <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama }} ({{ $mp->kode }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih mata pelajaran yang akan dijadwalkan</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="guru_id" class="col-sm-3 col-form-label">Guru <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="guru_id" name="guru_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->name }} ({{ $g->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih guru pengampu mata pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hari" class="col-sm-3 col-form-label">Hari <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                <div class="form-text">Pilih hari untuk jadwal pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jam_mulai" class="col-sm-3 col-form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="jam_mulai" 
                                       name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                                <div class="form-text">Waktu mulai pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jam_selesai" class="col-sm-3 col-form-label">Jam Selesai <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="jam_selesai" 
                                       name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                                <div class="form-text">Waktu selesai pelajaran</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ruangan" class="col-sm-3 col-form-label">Ruangan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ruangan" 
                                       name="ruangan" value="{{ old('ruangan') }}" 
                                       placeholder="Contoh: R.1A, Lab Komputer, Aula">
                                <div class="form-text">Lokasi/ruangan tempat pembelajaran (opsional)</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                          placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                                <div class="form-text">Catatan tambahan untuk jadwal ini</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-save"></i> Simpan Jadwal
                                </button>
                                <a href="/admin/jadwal-pelajaran/" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Conflict Check -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Cek Bentrok Jadwal
                </div>
                <div class="card-body" id="conflictCheck">
                    <div class="text-muted text-center py-4">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <p>Pilih kelas, guru, hari, dan waktu untuk mengecek bentrok jadwal</p>
                    </div>
                </div>
            </div>

            <!-- Quick Schedule View -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-calendar me-1"></i>
                    Jadwal Hari Ini
                </div>
                <div class="card-body" id="todaySchedule">
                    <div class="text-muted text-center py-4">
                        <i class="fas fa-calendar-day fa-3x mb-3"></i>
                        <p>Pilih hari untuk melihat jadwal yang sudah ada</p>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-1"></i>
                    Tips Penjadwalan
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan tidak ada bentrok waktu untuk kelas dan guru yang sama
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Berikan jeda waktu antar mata pelajaran (istirahat)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pertimbangkan kapasitas ruangan jika menggunakan ruang khusus
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Sesuaikan dengan jam operasional sekolah
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
.conflict-item {
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 0.375rem;
    border-left: 4px solid #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

.schedule-item {
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 0.375rem;
    background-color: #e7f1ff;
    border-left: 3px solid #0d6efd;
}

.schedule-time {
    font-weight: 600;
    color: #0d6efd;
}

.no-conflict {
    padding: 0.75rem;
    border-radius: 0.375rem;
    background-color: #d1e7dd;
    border-left: 4px solid #198754;
    color: #0f5132;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jadwalForm');
    const kelasSelect = document.getElementById('kelas_id');
    const guruSelect = document.getElementById('guru_id');
    const hariSelect = document.getElementById('hari');
    const jamMulaiInput = document.getElementById('jam_mulai');
    const jamSelesaiInput = document.getElementById('jam_selesai');
    
    // Auto-check conflict ketika field berubah
    [kelasSelect, guruSelect, hariSelect, jamMulaiInput, jamSelesaiInput].forEach(element => {
        element.addEventListener('change', checkConflicts);
    });
    
    // Update today schedule when hari changes
    hariSelect.addEventListener('change', loadTodaySchedule);
    
    // Validasi jam selesai > jam mulai
    jamSelesaiInput.addEventListener('change', function() {
        const jamMulai = jamMulaiInput.value;
        const jamSelesai = this.value;
        
        if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
            this.setCustomValidity('Jam selesai harus lebih besar dari jam mulai');
            this.reportValidity();
        } else {
            this.setCustomValidity('');
        }
    });
    
    function checkConflicts() {
        const kelasId = kelasSelect.value;
        const guruId = guruSelect.value;
        const hari = hariSelect.value;
        const jamMulai = jamMulaiInput.value;
        const jamSelesai = jamSelesaiInput.value;
        
        if (!kelasId && !guruId && !hari && !jamMulai && !jamSelesai) {
            document.getElementById('conflictCheck').innerHTML = `
                <div class="text-muted text-center py-4">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <p>Pilih kelas, guru, hari, dan waktu untuk mengecek bentrok jadwal</p>
                </div>
            `;
            return;
        }
        
        if (!jamMulai || !jamSelesai) {
            return;
        }
        
        const formData = new FormData();
        if (kelasId) formData.append('kelas_id', kelasId);
        if (guruId) formData.append('guru_id', guruId);
        if (hari) formData.append('hari', hari);
        if (jamMulai) formData.append('jam_mulai', jamMulai);
        if (jamSelesai) formData.append('jam_selesai', jamSelesai);
        
        document.getElementById('conflictCheck').innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Mengecek bentrok...</span>
                </div>
                <p class="mt-2 mb-0">Mengecek bentrok jadwal...</p>
            </div>
        `;
        
        fetch('/admin/jadwal-pelajaran/check-conflict', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            displayConflictResult(data);
        })
        .catch(error => {
            document.getElementById('conflictCheck').innerHTML = `
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gagal mengecek bentrok jadwal
                </div>
            `;
        });
    }
    
    function displayConflictResult(data) {
        let html = '';
        
        if (data.conflicts && data.conflicts.length > 0) {
            html = '<div class="mb-3"><h6 class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terdeteksi Bentrok!</h6></div>';
            
            data.conflicts.forEach(conflict => {
                html += `
                    <div class="conflict-item">
                        <strong>${conflict.type}</strong><br>
                        <small>${conflict.details}</small>
                    </div>
                `;
            });
        } else {
            html = `
                <div class="no-conflict">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Tidak ada bentrok!</strong><br>
                    <small>Jadwal dapat dibuat dengan aman</small>
                </div>
            `;
        }
        
        document.getElementById('conflictCheck').innerHTML = html;
    }
    
    function loadTodaySchedule() {
        const hari = hariSelect.value;
        
        if (!hari) {
            document.getElementById('todaySchedule').innerHTML = `
                <div class="text-muted text-center py-4">
                    <i class="fas fa-calendar-day fa-3x mb-3"></i>
                    <p>Pilih hari untuk melihat jadwal yang sudah ada</p>
                </div>
            `;
            return;
        }
        
        document.getElementById('todaySchedule').innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 mb-0">Memuat jadwal...</p>
            </div>
        `;
        
        fetch(`/admin/jadwal-pelajaran/by-hari/${hari}`)
        .then(response => response.json())
        .then(schedules => {
            displayTodaySchedule(schedules, hari);
        })
        .catch(error => {
            document.getElementById('todaySchedule').innerHTML = `
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gagal memuat jadwal hari ini
                </div>
            `;
        });
    }
    
    function displayTodaySchedule(schedules, hari) {
        let html = `<div class="mb-3"><h6><i class="fas fa-calendar-day me-2"></i>Jadwal ${hari}</h6></div>`;
        
        if (schedules.length === 0) {
            html += `
                <div class="text-muted text-center py-3">
                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                    <p class="mb-0">Belum ada jadwal untuk hari ${hari}</p>
                </div>
            `;
        } else {
            schedules.forEach(schedule => {
                html += `
                    <div class="schedule-item">
                        <div class="schedule-time">${schedule.jam_mulai} - ${schedule.jam_selesai}</div>
                        <div class="fw-bold">${schedule.mata_pelajaran_nama}</div>
                        <small class="text-muted">${schedule.kelas_nama} • ${schedule.guru_nama}</small>
                    </div>
                `;
            });
        }
        
        document.getElementById('todaySchedule').innerHTML = html;
    }
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const jamMulai = jamMulaiInput.value;
        const jamSelesai = jamSelesaiInput.value;
        
        if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
            e.preventDefault();
            jamSelesaiInput.focus();
            alert('Jam selesai harus lebih besar dari jam mulai!');
        }
    });
});
</script>
@endpush
