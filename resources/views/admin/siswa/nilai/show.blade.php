@extends('layouts.admin')
@section('title', 'Detail Nilai')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Detail Nilai</h3>
                    <a href="{{ url('/siswa/nilai') }}" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Judul Tugas</th>
                                <td>: {{ $nilai->pengumpulanTugas->tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $nilai->pengumpulanTugas->tugas->kelas->nama }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>: {{ $nilai->pengumpulanTugas->tugas->kelas->tahun_ajaran }}</td>
                            </tr>
                            <tr>
                                <th>Deadline</th>
                                <td>: {{ date('d M Y H:i', strtotime($nilai->pengumpulanTugas->tugas->deadline)) }}</td>
                            </tr>
                            <tr>
                                <th>Status Pengumpulan</th>
                                <td>: 
                                    @if($nilai->pengumpulanTugas->status == 'submitted')
                                        <span class="badge bg-success">Sudah Mengumpulkan</span>
                                    @elseif($nilai->pengumpulanTugas->status == 'late')
                                        <span class="badge bg-warning">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Waktu Pengumpulan</th>
                                <td>: {{ date('d M Y H:i', strtotime($nilai->pengumpulanTugas->waktu_pengumpulan)) }}</td>
                            </tr>
                            <tr>
                                <th>Nilai</th>
                                <td>: <span class="badge bg-primary">{{ $nilai->skor }}</span></td>
                            </tr>
                            <tr>
                                <th>Dinilai Pada</th>
                                <td>: {{ date('d M Y H:i', strtotime($nilai->dinilai_pada)) }}</td>
                            </tr>
                            <tr>
                                <th>Dinilai Oleh</th>
                                <td>: {{ $nilai->penilai->name }}</td>
                            </tr>
                            <tr>
                                <th>File Tugas</th>
                                <td>: 
                                    <a href="{{ asset('storage/' . $nilai->pengumpulanTugas->path_file) }}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="ph ph-download"></i> Unduh File
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Umpan Balik:</h5>
                        <div class="p-3 border rounded">
                            {!! $nilai->umpan_balik !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url('/siswa/tugas/show/' . $nilai->pengumpulanTugas->tugas_id) }}" class="btn btn-primary">
                            <i class="ph ph-book"></i> Lihat Tugas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection