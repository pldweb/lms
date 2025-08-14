@extends('admin.layouts.app')

@section('title', 'Keanggotaan Kelas')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Keanggotaan Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item active">Keanggotaan Kelas</li>
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
            <i class="fas fa-users me-1"></i>
            Data Keanggotaan Kelas
            <div class="float-end">
                <a href="/admin/keanggotaan-kelas/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Siswa ke Kelas
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Nama siswa/email/kelas..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jenjang</label>
                            <select name="jenjang" class="form-select">
                                <option value="">Semua Jenjang</option>
                                <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                        </div>
                        <div class="col-md-3">
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
                            <label class="form-label">Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-select">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }}
                                    </option>
                                @endforeach
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

            @if(request()->hasAny(['search', 'jenjang', 'kelas_id', 'tahun_ajaran_id']))
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a href="/admin/keanggotaan-kelas/" class="btn btn-outline-secondary btn-sm">
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
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Jenjang</th>
                            <th>Tahun Ajaran</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keanggotaan as $index => $item)
                        <tr>
                            <td>{{ ($keanggotaan->currentPage() - 1) * $keanggotaan->perPage() + $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-initial rounded-circle bg-primary">
                                            {{ substr($item->siswa_nama, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $item->siswa_nama }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->siswa_email }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $item->jenjang }} {{ $item->tingkat }} {{ $item->kelas_nama }}
                                </span>
                            </td>
                            <td>{{ $item->jenjang }}</td>
                            <td>{{ $item->tahun_ajaran_nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_bergabung)->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/admin/keanggotaan-kelas/{{ $item->id }}" 
                                       class="btn btn-outline-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->siswa_nama }}')" 
                                            title="Keluarkan dari Kelas">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>Tidak ada data keanggotaan kelas</h5>
                                    <p>Silakan tambah siswa ke kelas terlebih dahulu</p>
                                    <a href="/admin/keanggotaan-kelas/create" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Siswa ke Kelas
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($keanggotaan->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $keanggotaan->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Statistik Singkat -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Keanggotaan</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $keanggotaan->total() }}</div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-users"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kelas Aktif</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $kelas->where('is_active', true)->count() }}</div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-chalkboard-teacher"></i>
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
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-rata per Kelas</div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ $kelas->count() > 0 ? number_format($keanggotaan->total() / $kelas->count(), 1) : 0 }}
                            </div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Tahun Ajaran</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $tahunAjaran->count() }}</div>
                        </div>
                        <div class="fa-2x">
                            <i class="fas fa-calendar-alt"></i>
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
                <h5 class="modal-title">Konfirmasi Keluarkan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengeluarkan siswa <strong id="studentName"></strong> dari kelas?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Siswa yang sudah memiliki nilai tidak dapat dikeluarkan dari kelas!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Keluarkan</button>
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
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id, studentName) {
    document.getElementById('studentName').textContent = studentName;
    document.getElementById('deleteForm').action = '/admin/keanggotaan-kelas/' + id;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto-submit form ketika filter berubah
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = document.querySelectorAll('select[name="jenjang"], select[name="kelas_id"], select[name="tahun_ajaran_id"]');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
