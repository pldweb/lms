@extends('layouts.admin')
@section('title', 'Edit Nilai')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Edit Nilai</h3>
                    <a href="{{ url('/guru/nilai') }}" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama Siswa</th>
                                <td>: {{ $nilai->pengumpulanTugas->siswa->name }}</td>
                            </tr>
                            <tr>
                                <th>Email Siswa</th>
                                <td>: {{ $nilai->pengumpulanTugas->siswa->email }}</td>
                            </tr>
                            <tr>
                                <th>Judul Tugas</th>
                                <td>: {{ $nilai->pengumpulanTugas->tugas->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $nilai->pengumpulanTugas->tugas->kelas->nama }}</td>
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

                <form action="{{ url('/guru/nilai/update/' . $nilai->id) }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="skor" class="form-label">Nilai (0-100)</label>
                                <input type="number" class="form-control @error('skor') is-invalid @enderror" id="skor" name="skor" value="{{ old('skor', $nilai->skor) }}" min="0" max="100" required>
                                @error('skor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="umpan_balik" class="form-label">Umpan Balik</label>
                                <textarea class="form-control tinymce @error('umpan_balik') is-invalid @enderror" id="umpan_balik" name="umpan_balik" rows="5">{{ old('umpan_balik', $nilai->umpan_balik) }}</textarea>
                                @error('umpan_balik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-check"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('/guru/nilai/show/' . $nilai->id) }}" class="btn btn-secondary">
                                <i class="ph ph-x"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '.tinymce',
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help',
    });
</script>
@endsection