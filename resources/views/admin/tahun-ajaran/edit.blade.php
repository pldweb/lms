@extends('layouts.admin')
@section('title', 'Edit Tahun Ajaran')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Tahun Ajaran</h3>
                <a href="{{ url('/admin/tahun-ajaran/show/' . $tahunAjaran->id) }}" class="btn btn-secondary btn-sm btn-add">
                    <i class="ph ph-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <form method="POST" id="form-tahun-ajaran" enctype="multipart/form-data" onsubmit="return false;">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for="nama" class="mb-5">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                                <input type="text" 
                                    class="form-control" 
                                    id="nama" 
                                    name="nama" 
                                    value="{{ $tahunAjaran->nama }}" 
                                    placeholder="Contoh: 2024/2025"
                                    required>
                                <small class="form-text text-muted">Format: YYYY/YYYY</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for="tanggal_mulai" class="mb-5">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" 
                                    class="form-control" 
                                    id="tanggal_mulai" 
                                    name="tanggal_mulai" 
                                    value="{{ $tahunAjaran->tanggal_mulai }}" 
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for="tanggal_selesai" class="mb-5">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" 
                                    class="form-control" 
                                    id="tanggal_selesai" 
                                    name="tanggal_selesai" 
                                    value="{{ $tahunAjaran->tanggal_selesai }}" 
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-10">
                            <div class="form-group">
                                <label for="keterangan" class="mb-5">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" style="height: auto;" rows="4" maxlength="255" placeholder="Keterangan tambahan (opsional)">{{ $tahunAjaran->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-add">Simpan</button>
                        <a href="{{ url('/admin/tahun-ajaran/show/' . $tahunAjaran->id) }}" class="btn btn-secondary btn-add">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto generate nama tahun ajaran dari tanggal
    $('#tanggal_mulai, #tanggal_selesai').change(function() {
        var tanggalMulai = $('#tanggal_mulai').val();
        var tanggalSelesai = $('#tanggal_selesai').val();
        
        if (tanggalMulai && tanggalSelesai) {
            var tahunMulai = new Date(tanggalMulai).getFullYear();
            var tahunSelesai = new Date(tanggalSelesai).getFullYear();
            
            if (tahunSelesai > tahunMulai) {
                $('#nama').val(tahunMulai + '/' + tahunSelesai);
            }
        }
    });
});
</script>
@endsection