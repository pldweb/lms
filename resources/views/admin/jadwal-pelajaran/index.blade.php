@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Jadwal Pelajaran</h1>
        <a href="/admin/jadwal-pelajaran/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="/admin/jadwal-pelajaran/">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <select class="form-control" id="hari" name="hari">
                                <option value="">Semua Hari</option>
                                <option value="senin" {{ request('hari') === 'senin' ? 'selected' : '' }}>Senin</option>
                                <option value="selasa" {{ request('hari') === 'selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="rabu" {{ request('hari') === 'rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="kamis" {{ request('hari') === 'kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="jumat" {{ request('hari') === 'jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="sabtu" {{ request('hari') === 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control" id="kelas_id" name="kelas_id">
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $kls)
                                    <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                                        {{ $kls->jenjang }} {{ $kls->tingkat }} - {{ $kls->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="guru_id">Guru</label>
                            <select class="form-control" id="guru_id" name="guru_id">
                                <option value="">Semua Guru</option>
                                @foreach($guru as $gr)
                                    <option value="{{ $gr->id }}" {{ request('guru_id') == $gr->id ? 'selected' : '' }}>
                                        {{ $gr->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="/admin/jadwal-pelajaran/" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Pelajaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $index => $jdwl)
                        <tr>
                            <td>{{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $index + 1 }}</td>
                            <td>
                                <span class="badge badge-primary">{{ ucfirst($jdwl->hari) }}</span>
                            </td>
                            <td>
                                <small>{{ $jdwl->jam_mulai }} - {{ $jdwl->jam_selesai }}</small>
                            </td>
                            <td>
                                <strong>{{ $jdwl->kelas_nama }}</strong><br>
                                <small class="text-muted">{{ $jdwl->jenjang }} {{ $jdwl->tingkat }}</small>
                            </td>
                            <td>
                                <strong>{{ $jdwl->mata_pelajaran_nama }}</strong><br>
                                <small class="text-muted">{{ $jdwl->mata_pelajaran_kode }}</small>
                            </td>
                            <td>{{ $jdwl->guru_nama }}</td>
                            <td>
                                @if($jdwl->ruangan)
                                    <span class="badge badge-info">{{ $jdwl->ruangan }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($jdwl->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Aksi">
                                    <a href="/admin/jadwal-pelajaran/show/{{ $jdwl->id }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/jadwal-pelajaran/edit/{{ $jdwl->id }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/jadwal-pelajaran/toggle-status/{{ $jdwl->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengubah status jadwal ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $jdwl->is_active ? 'secondary' : 'success' }} btn-sm" title="{{ $jdwl->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $jdwl->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="/admin/jadwal-pelajaran/destroy/{{ $jdwl->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data jadwal pelajaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jadwal->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $jadwal->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Weekly Schedule View -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tampilan Mingguan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered schedule-table">
                    <thead class="thead-dark">
                        <tr>
                            <th width="100">Jam</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                            <th>Sabtu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $timeSlots = [
                                '07:00-07:45', '07:45-08:30', '08:30-09:15', '09:15-10:00',
                                '10:15-11:00', '11:00-11:45', '11:45-12:30',
                                '13:00-13:45', '13:45-14:30', '14:30-15:15', '15:15-16:00'
                            ];
                            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                        @endphp
                        
                        @foreach($timeSlots as $timeSlot)
                        <tr>
                            <td class="font-weight-bold bg-light">{{ $timeSlot }}</td>
                            @foreach($days as $day)
                                <td class="schedule-cell">
                                    @php
                                        $scheduleForSlot = $jadwal->where('hari', $day)
                                            ->where('jam_mulai', '<=', substr($timeSlot, 0, 5))
                                            ->where('jam_selesai', '>', substr($timeSlot, 0, 5))
                                            ->first();
                                    @endphp
                                    
                                    @if($scheduleForSlot)
                                        <div class="schedule-item bg-primary text-white p-1 rounded">
                                            <small>
                                                <strong>{{ $scheduleForSlot->mata_pelajaran_kode }}</strong><br>
                                                {{ $scheduleForSlot->kelas_nama }}<br>
                                                {{ $scheduleForSlot->guru_nama }}
                                                @if($scheduleForSlot->ruangan)
                                                    <br>{{ $scheduleForSlot->ruangan }}
                                                @endif
                                            </small>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.schedule-table .schedule-cell {
    height: 60px;
    vertical-align: top;
    padding: 5px;
}

.schedule-item {
    font-size: 0.75rem;
    line-height: 1.2;
}
</style>
@endsection
