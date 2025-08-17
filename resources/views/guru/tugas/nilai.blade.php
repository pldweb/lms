@extends('layouts.admin')
@section('title', 'Nilai Tugas')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Nilai Tugas</h3>
                    <a href="{{ url('/guru/tugas/show/' . $pengumpulan->tugas_id) }}" class="btn btn-secondary btn-sm">
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
                                <td>: {{ $pengumpulan->tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td>: {{ $pengumpulan->siswa->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $pengumpulan->siswa->email }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    @if($pengumpulan->status == 'submitted')
                                        <span class="badge bg-success">Sudah Mengumpulkan</span>
                                    @elseif($pengumpulan->status == 'late')
                                        <span class="badge bg-warning">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
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
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('/guru/tugas/nilai/' . $pengumpulan->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="skor" class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                                        <input type="number" name="skor" id="skor" class="form-control @error('skor') is-invalid @enderror" value="{{ old('skor', isset($nilai) ? $nilai->skor : '') }}" min="0" max="100" required>
                                        @error('skor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="umpan_balik" class="form-label">Umpan Balik</label>
                                        <textarea name="umpan_balik" id="umpan_balik" class="form-control @error('umpan_balik') is-invalid @enderror" rows="6">{{ old('umpan_balik', isset($nilai) ? $nilai->umpan_balik : '') }}</textarea>
                                        @error('umpan_balik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph ph-check"></i> Simpan Nilai
                                    </button>
                                    <a href="{{ url('/guru/tugas/show/' . $pengumpulan->tugas_id) }}" class="btn btn-secondary">
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

<script>
    $(document).ready(function() {
        // Inisialisasi TinyMCE untuk editor umpan balik
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#umpan_balik',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help'
            });
        }
    });
</script>

@endsection