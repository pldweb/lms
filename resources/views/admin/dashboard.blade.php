@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dashboard Admin</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    @php
                        $tahunAjaranAktif = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
                        $tahunAjaranNama = $tahunAjaranAktif ? $tahunAjaranAktif->nama : 'Tidak ada';
                    @endphp
                    <p class="mb-0">Tahun Ajaran Aktif: <strong>{{ $tahunAjaranAktif ? $tahunAjaranAktif->nama : 'Tidak ada' }}</strong></p>
                </div>

                <!-- Statistik Utama -->
                <div class="row mb-4">
                    <!-- Total Guru -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-user-list text-primary" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    @php
                                        $totalGuru = DB::table('users')
                                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                            ->where('roles.name', 'Guru')
                                            ->count();
                                    @endphp
                                    <h2 class="mb-0">{{ $totalGuru }}</h2>
                                    <p class="text-muted mb-0">Total Guru</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Siswa -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-student text-success" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    @php
                                        $totalSiswa = DB::table('users')
                                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                            ->where('roles.name', 'Siswa')
                                            ->count();
                                    @endphp
                                    <h2 class="mb-0">{{ $totalSiswa }}</h2>
                                    <p class="text-muted mb-0">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Kelas -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-chalkboard-teacher text-primary" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    @php
                                        $totalKelas = DB::table('kelas')->count();
                                    @endphp
                                    <h2 class="mb-0">{{ $totalKelas }}</h2>
                                    <p class="text-muted mb-0">Total Kelas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-danger rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-book-open text-danger" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    @php
                                        $totalMapel = DB::table('mata_pelajaran')->where('aktif', true)->count();
                                    @endphp
                                    <h2 class="mb-0">{{ $totalMapel }}</h2>
                                    <p class="text-muted mb-0">Mata Pelajaran</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat dan Informasi Tahun Ajaran -->
                <div class="row">
                    <!-- Aksi Cepat -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-lightning text-primary me-2"></i> Aksi Cepat
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <a href="{{ url('/admin/user/guru/create') }}" class="btn btn-light btn-block text-start py-2 px-3 border">
                                            <i class="ph ph-user-plus text-primary me-2"></i> Tambah Guru Baru
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/admin/user/siswa/create') }}" class="btn btn-light btn-block text-start py-2 px-3 border">
                                            <i class="ph ph-user-plus text-success me-2"></i> Tambah Siswa Baru
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/admin/kelas/create') }}" class="btn btn-light btn-block text-start py-2 px-3 border">
                                            <i class="ph ph-plus-circle text-primary me-2"></i> Buat Kelas Baru
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/admin/tugas/create') }}" class="btn btn-light btn-block text-start py-2 px-3 border">
                                            <i class="ph ph-note-pencil text-warning me-2"></i> Atur Penugasan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tahun Ajaran -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-calendar-check text-primary me-2"></i> Informasi Tahun Ajaran
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($tahunAjaranAktif)
                                    <div class="mb-3">
                                        <p class="mb-1">Tahun Ajaran:</p>
                                        <h5>{{ $tahunAjaranAktif->nama }}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <p class="mb-1">Mulai:</p>
                                            <h6>{{ \Carbon\Carbon::parse($tahunAjaranAktif->tanggal_mulai)->format('d/m/Y') }}</h6>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <p class="mb-1">Berakhir:</p>
                                            <h6>{{ \Carbon\Carbon::parse($tahunAjaranAktif->tanggal_selesai)->format('d/m/Y') }}</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2">Aktif</span>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="ph ph-warning"></i> Belum ada tahun ajaran yang aktif.
                                    </div>
                                    <a href="{{ url('/admin/tahun-ajaran/create') }}" class="btn btn-primary">
                                        <i class="ph ph-plus"></i> Buat Tahun Ajaran
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-activity text-primary me-2"></i> Aktivitas Terbaru
                                </h5>
                            </div>
                            <div class="card-body">
                                @if(count($aktivitas) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($aktivitas as $item)
                                            <li class="list-group-item px-0 py-3 d-flex">
                                                <div class="me-3">
                                                    <span class="avatar avatar-md bg-light-{{ $item['color'] }} rounded-circle">
                                                        <i class="ph {{ $item['icon'] }} text-{{ $item['color'] }}"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-1">{{ $item['pesan'] }}</p>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item['waktu'])->diffForHumans() }}</small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center py-4">
                                        <i class="ph ph-info text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p>Belum ada aktivitas terbaru</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection