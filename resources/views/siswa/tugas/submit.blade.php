@extends('layouts.admin')
@section('title', 'Kumpulkan Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kumpulkan Tugas</h3>
                    <a href="{{ url('/siswa/tugas/show/' . $tugas->id) }}" class="btn btn-secondary btn-sm">
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
                            @if($tugas->tenggat_waktu && strtotime($tugas->tenggat_waktu) <= time())
                                <tr>
                                    <th>Status</th>
                                    <td>: <span class="badge bg-warning">Pengumpulan Terlambat</span></td>
                                </tr>
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

                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('/siswa/tugas/submit/' . $tugas->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="file_tugas" class="form-label">File Tugas <span class="text-danger">*</span></label>
                                        <input type="file" name="file_tugas" id="file_tugas" class="form-control @error('file_tugas') is-invalid @enderror" required>
                                        <small class="text-muted">Format file yang diperbolehkan: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR (Maks. 10MB)</small>
                                        @error('file_tugas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-upload"></i> Kumpulkan Tugas
                                    </button>
                                    <a href="{{ url('/siswa/tugas/show/' . $tugas->id) }}" class="btn btn-secondary">
                                        <i class="ph ph-x"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection