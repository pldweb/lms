@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Tambah Mata Pelajaran</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="/admin/mata-pelajaran/" class="btn btn-secondary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-top: 0;">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Mata Pelajaran</h6>
                            </div>
                            <div class="card-body">
            <form action="/admin/mata-pelajaran/store" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: Matematika"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode" class="form-label">Kode Mata Pelajaran</label>
                            <input type="text" 
                                   class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode') }}" 
                                   placeholder="Otomatis jika kosong">
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kosongkan untuk otomatis generate</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jenjang" class="form-label">Jenjang <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenjang') is-invalid @enderror" 
                                    id="jenjang" 
                                    name="jenjang" 
                                    required>
                                <option value="">Pilih Jenjang</option>
                                <option value="SD" {{ old('jenjang') === 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jenjang') === 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('jenjang') === 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('jenjang') === 'SMK' ? 'selected' : '' }}>SMK</option>
                            </select>
                            @error('jenjang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-control @error('semester') is-invalid @enderror" 
                                    id="semester" 
                                    name="semester" 
                                    required>
                                <option value="">Pilih Semester</option>
                                <option value="1" {{ old('semester') === '1' ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ old('semester') === '2' ? 'selected' : '' }}>Semester 2</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="urutan" class="form-label">Urutan</label>
                            <input type="number" 
                                   class="form-control @error('urutan') is-invalid @enderror" 
                                   id="urutan" 
                                   name="urutan" 
                                   value="{{ old('urutan', 1) }}" 
                                   min="1" 
                                   placeholder="Urutan mata pelajaran">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Urutan tampil mata pelajaran</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('sks') is-invalid @enderror" 
                                   id="sks" 
                                   name="sks" 
                                   value="{{ old('sks', 1) }}" 
                                   min="1" 
                                   max="6"
                                   required>
                            @error('sks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="aktif" class="form-label">Status</label>
                            <select class="form-control @error('aktif') is-invalid @enderror" 
                                    id="aktif" 
                                    name="aktif">
                                <option value="1" {{ old('aktif', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('aktif') == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('aktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              placeholder="Deskripsi mata pelajaran...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="generate_kode" 
                               name="generate_kode" 
                               {{ old('generate_kode', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="generate_kode">
                            Generate kode otomatis dari nama mata pelajaran
                        </label>
                    </div>
                </div>

                <hr>
                
                                <div class="form-group text-right">
                                    <a href="/admin/mata-pelajaran/" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto generate urutan berdasarkan jenjang dan semester
        $('#jenjang, #semester').change(function() {
            var jenjang = $('#jenjang').val();
            var semester = $('#semester').val();
            
            if (jenjang && semester) {
                // Auto set urutan berdasarkan jenjang dan semester
                var baseUrutan = 1;
                switch(jenjang) {
                    case 'SD':
                        baseUrutan = semester === '1' ? 1 : 10;
                        break;
                    case 'SMP':
                        baseUrutan = semester === '1' ? 20 : 30;
                        break;
                    case 'SMA':
                    case 'SMK':
                        baseUrutan = semester === '1' ? 40 : 50;
                        break;
                }
                
                if ($('#urutan').val() === '' || $('#urutan').val() === '1') {
                    $('#urutan').val(baseUrutan);
                }
            }
        });

        // Auto generate kode
        function generateKode() {
            var nama = $('#nama').val();
            var jenjang = $('#jenjang').val();
            var semester = $('#semester').val();
            
            if (nama && jenjang && $('#generate_kode').is(':checked')) {
                // Ambil 3 huruf pertama dari nama
                var namaCode = nama.substring(0, 3).toUpperCase();
                
                // Tambahkan jenjang
                var jenjangCode = jenjang;
                
                // Tambahkan semester
                var semesterCode = semester ? '-' + semester : '';
                
                var kode = jenjangCode + '-' + namaCode + semesterCode;
                $('#kode').val(kode);
            }
        }

        // Event listeners untuk auto generate
        $('#nama, #jenjang, #semester').on('input change', generateKode);
        
        $('#generate_kode').change(function() {
            if ($(this).is(':checked')) {
                generateKode();
            } else {
                $('#kode').val('');
            }
        });

        // Trigger initial change untuk auto generate jika ada old value
        @if(old('jenjang') && old('semester'))
            $('#jenjang, #semester').trigger('change');
        @endif
    });
</script>
@endsection
