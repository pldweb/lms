@extends('layouts.admin')
@section('title', 'Detail Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail Tugas</h3>
                    <a href="{{ url('/guru/tugas') }}" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Judul</th>
                                <td>: {{ $tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $tugas->kelas->nama }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>: {{ $tugas->kelas->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <th>Tenggat Waktu</th>
                                <td>: {{ $tugas->tenggat_waktu ? date('d M Y H:i', strtotime($tugas->tenggat_waktu)) : 'Tidak ada tenggat' }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>: {{ date('d M Y H:i', strtotime($tugas->created_at)) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Instruksi Tugas:</h5>
                        <div class="p-3 border rounded">
                            {!! $tugas->instruksi !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Daftar Pengumpulan Tugas</h5>
                            <div>
                                <a href="{{ url('/guru/tugas/edit/' . $tugas->id) }}" class="btn btn-warning btn-sm">
                                    <i class="ph ph-pencil"></i> Edit Tugas
                                </a>
                                <a href="{{ url('/guru/tugas/delete/' . $tugas->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                    <i class="ph ph-trash"></i> Hapus Tugas
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Waktu Pengumpulan</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($siswa) > 0)
                                        @foreach($siswa as $index => $s)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $s->name }}</td>
                                                <td>{{ $s->email }}</td>
                                                <td>
                                                    @if(isset($s->pengumpulan))
                                                        @if($s->pengumpulan->status == 'submitted')
                                                            <span class="badge bg-success">Sudah Mengumpulkan</span>
                                                        @elseif($s->pengumpulan->status == 'late')
                                                            <span class="badge bg-warning">Terlambat</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-danger">Belum Mengumpulkan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($s->pengumpulan))
                                                        {{ date('d M Y H:i', strtotime($s->pengumpulan->waktu_pengumpulan)) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($s->pengumpulan) && isset($s->pengumpulan->nilai))
                                                        <span class="badge bg-primary">{{ $s->pengumpulan->nilai->skor }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">Belum dinilai</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($s->pengumpulan))
                                                        <a href="{{ asset('storage/' . $s->pengumpulan->path_file) }}" class="btn btn-info btn-sm" target="_blank">
                                                            <i class="ph ph-download"></i> Unduh
                                                        </a>
                                                        <a href="{{ url('/guru/tugas/nilai/' . $s->pengumpulan->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="ph ph-star"></i> Nilai
                                                        </a>
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>
                                                            <i class="ph ph-download"></i> Unduh
                                                        </button>
                                                        <button class="btn btn-secondary btn-sm" disabled>
                                                            <i class="ph ph-star"></i> Nilai
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada siswa di kelas ini</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection