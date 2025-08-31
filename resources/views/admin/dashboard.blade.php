@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title d-flex justify-content-between align-items-center">
                <h3 class="card-title">Dashboard Admin</h3>
                <div class="mb-3">
                    <p class="mb-0">Tahun Ajaran Aktif: <strong>{{ $tahunAjaranAktif ? $tahunAjaranAktif->nama : 'Tidak ada' }}</strong></p>
                </div>
            </div>
            <div class="card-body">

                <!-- Statistik Utama -->
                <div class="row mb-4">
                    <!-- Total Guru -->
                    <div class="col-md-3">
                        <div class="card border-1">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-user-list text-primary" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">{{ $totalGuru }}</h2>
                                    <p class="text-muted mb-0">Total Guru</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Siswa -->
                    <div class="col-md-3">
                        <div class="card border-1">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-student text-success" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">{{ $totalSiswa }}</h2>
                                    <p class="text-muted mb-0">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Kelas -->
                    <div class="col-md-3">
                        <div class="card border-1">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-chalkboard-teacher text-primary" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">{{ $totalKelas }}</h2>
                                    <p class="text-muted mb-0">Total Kelas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div class="col-md-3">
                        <div class="card border-1">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-light-danger rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="ph ph-book-open text-danger" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">{{ $totalMapel }}</h2>
                                    <p class="text-muted mb-0">Mata Pelajaran</p>
                                </div>
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