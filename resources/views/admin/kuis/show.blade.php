@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detail Kuis</h4>
                    <div>
                        <a href="{{ url('/admin/kuis/edit/' . $kuis->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ url('/admin/kuis/pertanyaan/' . $kuis->id) }}" class="btn btn-primary">Kelola Soal</a>
                        <a href="{{ url('/admin/kuis') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Informasi Kuis</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="30%">Judul</td>
                                            <td width="5%">:</td>
                                            <td>{{ $kuis->judul }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pembuat</td>
                                            <td>:</td>
                                            <td>{{ $kuis->pembuat ? $kuis->pembuat->name : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Dibuat</td>
                                            <td>:</td>
                                            <td>{{ $kuis->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Terakhir Diupdate</td>
                                            <td>:</td>
                                            <td>{{ $kuis->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Soal</td>
                                            <td>:</td>
                                            <td>{{ $kuis->pertanyaan->count() }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Pengaturan Kuis</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%">Jumlah Soal Ditampilkan</td>
                                            <td width="5%">:</td>
                                            <td>{{ $kuis->jumlah_soal > 0 ? $kuis->jumlah_soal : 'Semua' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Acak Soal</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge {{ $kuis->acak_soal ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $kuis->acak_soal ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Acak Jawaban</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge {{ $kuis->acak_jawaban ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $kuis->acak_jawaban ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tampilkan Hasil</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge {{ $kuis->tampilkan_hasil ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $kuis->tampilkan_hasil ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tampilkan Kunci Jawaban</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge {{ $kuis->tampilkan_kunci ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $kuis->tampilkan_kunci ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Deskripsi</h5>
                                </div>
                                <div class="card-body">
                                    {!! $kuis->deskripsi ?: '<em>Tidak ada deskripsi</em>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">Instruksi Pengerjaan</h5>
                                </div>
                                <div class="card-body">
                                    {!! $kuis->instruksi ?: '<em>Tidak ada instruksi</em>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection