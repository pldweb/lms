@extends('admin.layouts.app')

@section('title', 'Detail Jadwal Pelajaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Jadwal Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/jadwal-pelajaran/">Jadwal Pelajaran</a></li>
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
            <!-- Info Jadwal Utama -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Informasi Jadwal Pelajaran
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section mb-4">
                                <h5 class="mb-3 text-primary">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Kelas & Mata Pelajaran
                                </h5>
                                <div class="info-item">
                                    <label class="text-muted">Kelas</label>
                                    <p class="mb-2">
                                        <span class="badge bg-info fs-6">
                                            {{ $jadwal->kelas_jenjang }} {{ $jadwal->kelas_tingkat }} {{ $jadwal->kelas_nama }}
                                        </span>
                                        @if($jadwal->tahun_ajaran_nama)
                                            <br><small class="text-muted">{{ $jadwal->tahun_ajaran_nama }}</small>
                                        @endif
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label class="text-muted">Mata Pelajaran</label>
                                    <p class="mb-2">
                                        <strong>{{ $jadwal->mata_pelajaran_nama }}</strong>
                                        <br><small class="text-muted">Kode: {{ $jadwal->mata_pelajaran_kode }}</small>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label class="text-muted">Guru Pengampu</label>
                                    <p class="mb-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-initial rounded-circle bg-success">
                                                    {{ substr($jadwal->guru_nama, 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $jadwal->guru_nama }}</strong>
                                                <br><small class="text-muted">{{ $jadwal->guru_email }}</small>
                                            </div>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-section mb-4">
                                <h5 class="mb-3 text-success">
                                    <i class="fas fa-clock me-2"></i>Waktu & Tempat
                                </h5>
                                <div class="info-item">
                                    <label class="text-muted">Hari</label>
                                    <p class="mb-2">
                                        <span class="badge bg-primary">{{ $jadwal->hari }}</span>
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label class="text-muted">Waktu</label>
                                    <p class="mb-2">
                                        <strong class="text-success">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</strong>
                                        @php
                                            $duration = \Carbon\Carbon::parse($jadwal->jam_selesai)->diffInMinutes(\Carbon\Carbon::parse($jadwal->jam_mulai));
                                        @endphp
                                        <br><small class="text-muted">Durasi: {{ $duration }} menit</small>
                                    </p>
                                </div>
                                @if($jadwal->ruangan)
                                <div class="info-item">
                                    <label class="text-muted">Ruangan</label>
                                    <p class="mb-2">
                                        <i class="fas fa-door-open text-warning me-2"></i>
                                        <strong>{{ $jadwal->ruangan }}</strong>
                                    </p>
                                </div>
                                @endif
                                @if($jadwal->keterangan)
                                <div class="info-item">
                                    <label class="text-muted">Keterangan</label>
                                    <p class="mb-0">{{ $jadwal->keterangan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Siswa Kelas -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-1"></i>
                        Daftar Siswa Kelas
                    </div>
                    <div>
                        <span class="badge bg-primary">{{ $siswaKelas->count() }} Siswa</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($siswaKelas->count() > 0)
                        <div class="row">
                            @foreach($siswaKelas->chunk(ceil($siswaKelas->count() / 2)) as $chunk)
                                <div class="col-md-6">
                                    @foreach($chunk as $index => $siswa)
                                        <div class="student-item d-flex align-items-center mb-2">
                                            <div class="student-number me-3">
                                                <span class="badge bg-light text-dark">{{ $loop->parent->first ? $index + 1 : $index + 1 + ceil($siswaKelas->count() / 2) }}</span>
                                            </div>
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-initial rounded-circle bg-primary">
                                                    {{ substr($siswa->siswa_nama, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $siswa->siswa_nama }}</h6>
                                                <small class="text-muted">{{ $siswa->siswa_email }}</small>
                                            </div>
                                            <div>
                                                <a href="/admin/keanggotaan-kelas/{{ $siswa->keanggotaan_id }}" 
                                                   class="btn btn-outline-info btn-sm" title="Detail Keanggotaan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Siswa</h5>
                            <p class="text-muted">Kelas ini belum memiliki siswa yang terdaftar.</p>
                            <a href="/admin/keanggotaan-kelas/create?kelas_id={{ $jadwal->kelas_id }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Tambah Siswa ke Kelas
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Jadwal Lain di Hari yang Sama -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-day me-1"></i>
                    Jadwal Lain Hari {{ $jadwal->hari }}
                </div>
                <div class="card-body">
                    @if($jadwalHariSama->count() > 0)
                        <div class="timeline">
                            @foreach($jadwalHariSama as $j)
                                <div class="timeline-item {{ $j->id == $jadwal->id ? 'current' : '' }}">
                                    <div class="timeline-time">
                                        {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                        @if($j->id == $jadwal->id)
                                            <span class="badge bg-warning ms-2">Saat ini</span>
                                        @endif
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $j->mata_pelajaran_nama }}</h6>
                                        <div class="text-muted">
                                            <small>{{ $j->kelas_jenjang }} {{ $j->kelas_tingkat }} {{ $j->kelas_nama }} • {{ $j->guru_nama }}</small>
                                            @if($j->ruangan)
                                                <br><small><i class="fas fa-door-open me-1"></i>{{ $j->ruangan }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($j->id != $jadwal->id)
                                        <div class="timeline-action">
                                            <a href="/admin/jadwal-pelajaran/{{ $j->id }}" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Jadwal Lain</h5>
                            <p class="text-muted">Belum ada jadwal pelajaran lain untuk hari {{ $jadwal->hari }}.</p>
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
                        <a href="/admin/jadwal-pelajaran/" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="/admin/jadwal-pelajaran/{{ $jadwal->id }}/edit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Jadwal
                        </a>
                        <a href="/admin/kelas/{{ $jadwal->kelas_id }}" class="btn btn-outline-info">
                            <i class="fas fa-chalkboard-teacher"></i> Lihat Detail Kelas
                        </a>
                        <a href="/admin/jadwal-pelajaran/create?kelas_id={{ $jadwal->kelas_id }}" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Tambah Jadwal untuk Kelas Ini
                        </a>
                        <hr>
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="confirmDelete({{ $jadwal->id }}, '{{ $jadwal->mata_pelajaran_nama }}', '{{ $jadwal->hari }}', '{{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}')">
                            <i class="fas fa-trash"></i> Hapus Jadwal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistik Kelas -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Statistik Kelas
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-primary mb-1">{{ $siswaKelas->count() }}</h5>
                                <small class="text-muted">Jumlah Siswa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-1">{{ $jadwalKelas->count() }}</h5>
                            <small class="text-muted">Total Jadwal</small>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        @php
                            $kapasitas = $jadwalKelas->first()->kelas_kapasitas ?? 0;
                            $persentase = $kapasitas > 0 ? ($siswaKelas->count() / $kapasitas) * 100 : 0;
                        @endphp
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar 
                                @if($persentase >= 90) bg-danger
                                @elseif($persentase >= 75) bg-warning
                                @else bg-success
                                @endif" 
                                role="progressbar" style="width: {{ $persentase }}%"></div>
                        </div>
                        <small class="text-muted">{{ number_format($persentase, 1) }}% kapasitas kelas terisi</small>
                    </div>
                </div>
            </div>

            <!-- Jadwal Guru -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tie me-1"></i>
                    Jadwal Guru ({{ $jadwal->hari }})
                </div>
                <div class="card-body">
                    @if($jadwalGuru->count() > 0)
                        <div class="guru-schedule">
                            @foreach($jadwalGuru as $jg)
                                <div class="schedule-item {{ $jg->id == $jadwal->id ? 'current-schedule' : '' }}">
                                    <div class="schedule-time">
                                        {{ $jg->jam_mulai }} - {{ $jg->jam_selesai }}
                                        @if($jg->id == $jadwal->id)
                                            <span class="badge bg-warning ms-1">Saat ini</span>
                                        @endif
                                    </div>
                                    <div class="schedule-subject">{{ $jg->mata_pelajaran_nama }}</div>
                                    <small class="text-muted">{{ $jg->kelas_nama }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada jadwal lain untuk guru ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Tambahan
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label class="text-muted">Dibuat</label>
                        <p class="mb-2">{{ \Carbon\Carbon::parse($jadwal->created_at)->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <label class="text-muted">Terakhir Diubah</label>
                        <p class="mb-2">{{ \Carbon\Carbon::parse($jadwal->updated_at)->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <label class="text-muted">Durasi Pelajaran</label>
                        <p class="mb-0">
                            @php
                                $duration = \Carbon\Carbon::parse($jadwal->jam_selesai)->diffInMinutes(\Carbon\Carbon::parse($jadwal->jam_mulai));
                                $hours = floor($duration / 60);
                                $minutes = $duration % 60;
                            @endphp
                            {{ $hours > 0 ? $hours . ' jam ' : '' }}{{ $minutes }} menit
                        </p>
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
                <h5 class="modal-title">Konfirmasi Hapus Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jadwal pelajaran ini?</p>
                <div class="alert alert-info">
                    <strong>Detail Jadwal:</strong>
                    <br><span id="scheduleDetails"></span>
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
                    <button type="submit" class="btn btn-danger">Ya, Hapus Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-section {
    padding: 1rem;
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

.student-item {
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: background-color 0.15s ease-in-out;
}

.student-item:hover {
    background-color: #f8f9fa;
}

.timeline {
    position: relative;
    padding-left: 1.5rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
    display: flex;
    align-items-start;
    gap: 1rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #0d6efd;
}

.timeline-item.current::before {
    background-color: #ffc107;
    box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
}

.timeline-time {
    min-width: 120px;
    font-weight: 600;
    color: #0d6efd;
    font-size: 0.875rem;
}

.timeline-content {
    flex-grow: 1;
}

.timeline-action {
    margin-left: auto;
}

.schedule-item {
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 0.375rem;
    background-color: #e7f1ff;
    border-left: 3px solid #0d6efd;
}

.current-schedule {
    background-color: #fff3cd;
    border-left-color: #ffc107;
}

.schedule-time {
    font-weight: 600;
    color: #0d6efd;
    font-size: 0.875rem;
}

.schedule-subject {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.progress {
    background-color: #e9ecef;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id, mataPelajaran, hari, waktu) {
    document.getElementById('scheduleDetails').innerHTML = 
        `<strong>${mataPelajaran}</strong><br>
         ${hari}, ${waktu}`;
    document.getElementById('deleteForm').action = '/admin/jadwal-pelajaran/' + id;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
