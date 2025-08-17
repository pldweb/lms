@extends('layouts.admin')
@section('title', 'Detail Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail Tugas</h3>
                    <div>
                        <a href="{{ url('/admin/tugas/edit') }}/{{ $tugas->id }}" class="btn btn-warning btn-sm">
                            <i class="ph ph-pencil"></i> Edit
                        </a>
                        <a href="{{ url('/admin/tugas') }}" class="btn btn-secondary btn-sm">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Judul</th>
                                <td>{{ $tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $tugas->kelas_nama }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>{{ $tugas->tahun_ajaran_nama }}</td>
                            </tr>
                            <tr>
                                <th>Tenggat Waktu</th>
                                <td>{{ $tugas->tenggat_waktu ? date('d M Y H:i', strtotime($tugas->tenggat_waktu)) : 'Tidak ada tenggat' }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ date('d M Y H:i', strtotime($tugas->created_at)) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Instruksi Tugas</h5>
                            </div>
                            <div class="card-body">
                                {!! $tugas->instruksi !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengumpulan Tugas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Waktu Pengumpulan</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($pengumpulan) > 0)
                                @foreach($pengumpulan as $p)
                                    <tr>
                                        <td>{{ $p->siswa_nama }}</td>
                                        <td>{{ $p->siswa_email }}</td>
                                        <td>
                                            @if($p->status == 'submitted')
                                                <span class="badge bg-success">Dikumpulkan</span>
                                            @elseif($p->status == 'late')
                                                <span class="badge bg-warning">Terlambat</span>
                                            @else
                                                <span class="badge bg-danger">Belum Dikumpulkan</span>
                                            @endif
                                        </td>
                                        <td>{{ $p->waktu_pengumpulan ? date('d M Y H:i', strtotime($p->waktu_pengumpulan)) : '-' }}</td>
                                        <td>
                                            @if(isset($p->skor))
                                                <span class="badge bg-primary">{{ $p->skor }}</span>
                                            @else
                                                <span class="badge bg-secondary">Belum dinilai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->path_file)
                                                <a href="{{ url('/storage/' . $p->path_file) }}" class="btn btn-info btn-sm" target="_blank">
                                                    <i class="ph ph-download"></i> Unduh
                                                </a>
                                            @endif
                                            
                                            <a href="{{ url('/admin/tugas/nilai') }}/{{ $p->id }}" class="btn btn-primary btn-sm">
                                                <i class="ph ph-star"></i> Nilai
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada pengumpulan tugas</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection