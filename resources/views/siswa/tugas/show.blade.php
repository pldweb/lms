@extends('layouts.admin')
@section('title', 'Detail Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail Tugas</h3>
                    <a href="{{ url('/siswa/tugas') }}" class="btn btn-secondary btn-sm">
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
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    @if(isset($pengumpulan))
                                        @if($pengumpulan->status == 'submitted')
                                            <span class="badge bg-success">Sudah Mengumpulkan</span>
                                        @elseif($pengumpulan->status == 'late')
                                            <span class="badge bg-warning">Terlambat</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">Belum Mengumpulkan</span>
                                    @endif
                                </td>
                            </tr>
                            @if(isset($pengumpulan))
                                <tr>
                                    <th>Waktu Pengumpulan</th>
                                    <td>: {{ date('d M Y H:i', strtotime($pengumpulan->waktu_pengumpulan)) }}</td>
                                </tr>
                                <tr>
                                    <th>File Tugas</th>
                                    <td>: 
                                        <a href="{{ asset('storage/' . $pengumpulan->path_file) }}" class="btn btn-info btn-sm" target="_blank">
                                            <i class="ph ph-download"></i> Unduh File
                                        </a>
                                    </td>
                                </tr>
                                @if(isset($pengumpulan->nilai))
                                    <tr>
                                        <th>Nilai</th>
                                        <td>: <span class="badge bg-primary">{{ $pengumpulan->nilai->skor }}</span></td>
                                    </tr>
                                @endif
                            @endif
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

                @if(isset($pengumpulan) && isset($pengumpulan->nilai) && $pengumpulan->nilai->umpan_balik)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5>Umpan Balik Guru:</h5>
                            <div class="p-3 border rounded">
                                {!! $pengumpulan->nilai->umpan_balik !!}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        @if(!isset($pengumpulan))
                            @if(!$tugas->tenggat_waktu || strtotime($tugas->tenggat_waktu) > time())
                                <a href="{{ url('/siswa/tugas/submit/' . $tugas->id) }}" class="btn btn-primary">
                                    <i class="ph ph-upload"></i> Kumpulkan Tugas
                                </a>
                            @else
                                <a href="{{ url('/siswa/tugas/submit/' . $tugas->id) }}" class="btn btn-warning">
                                    <i class="ph ph-upload"></i> Kumpulkan Tugas (Terlambat)
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection