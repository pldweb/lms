@extends('layouts.admin')
@section('title', 'Daftar Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Daftar Tugas</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ url('/siswa/tugas') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari tugas..." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ph ph-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }} ({{ $k->tahun_ajaran }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Mengumpulkan</option>
                                    <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Mengumpulkan</option>
                                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <a href="{{ url('/siswa/tugas') }}" class="btn btn-secondary">
                                        <i class="ph ph-arrow-counter-clockwise"></i>
                                    </a>
                                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ph ph-export"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ url('/siswa/tugas/export/csv' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')) }}">Export CSV</a></li>
                                        <li><a class="dropdown-item" href="{{ url('/siswa/tugas/export/json' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')) }}">Export JSON</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kelas</th>
                                <th>Tenggat Waktu</th>
                                <th>Status</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($tugas) > 0)
                                @foreach($tugas as $index => $t)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $t->judul }}</td>
                                        <td>{{ $t->kelas->nama }} ({{ $t->kelas->tahun_ajaran }})</td>
                                        <td>{{ $t->tenggat_waktu ? date('d M Y H:i', strtotime($t->tenggat_waktu)) : 'Tidak ada tenggat' }}</td>
                                        <td>
                                            @if(isset($t->pengumpulan))
                                                @if($t->pengumpulan->status == 'submitted')
                                                    <span class="badge bg-success">Sudah Mengumpulkan</span>
                                                @elseif($t->pengumpulan->status == 'late')
                                                    <span class="badge bg-warning">Terlambat</span>
                                                @endif
                                            @else
                                                <span class="badge bg-danger">Belum Mengumpulkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($t->pengumpulan) && isset($t->pengumpulan->nilai))
                                                <span class="badge bg-primary">{{ $t->pengumpulan->nilai->skor }}</span>
                                            @else
                                                <span class="badge bg-secondary">Belum dinilai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('/siswa/tugas/show/' . $t->id) }}" class="btn btn-info btn-sm">
                                                <i class="ph ph-eye"></i> Detail
                                            </a>
                                            @if(!isset($t->pengumpulan) && (!$t->tenggat_waktu || strtotime($t->tenggat_waktu) > time()))
                                                <a href="{{ url('/siswa/tugas/submit/' . $t->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="ph ph-upload"></i> Kumpulkan
                                                </a>
                                            @elseif(!isset($t->pengumpulan) && $t->tenggat_waktu && strtotime($t->tenggat_waktu) <= time())
                                                <a href="{{ url('/siswa/tugas/submit/' . $t->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="ph ph-upload"></i> Kumpulkan (Terlambat)
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada tugas yang tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $tugas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection