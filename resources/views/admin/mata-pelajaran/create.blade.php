@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Mata Pelajaran</h1>
        <a href="/admin/mata-pelajaran/" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
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
                            <label for="tingkat" class="form-label">Tingkat/Kelas</label>
                            <select class="form-control @error('tingkat') is-invalid @enderror" 
                                    id="tingkat" 
                                    name="tingkat">
                                <option value="">Semua Kelas</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Pilih jenjang terlebih dahulu</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="wajib" {{ old('kategori') === 'wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="pilihan" {{ old('kategori') === 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                                <option value="muatan_lokal" {{ old('kategori') === 'muatan_lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bobot_sks" class="form-label">Bobot SKS <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('bobot_sks') is-invalid @enderror" 
                                   id="bobot_sks" 
                                   name="bobot_sks" 
                                   value="{{ old('bobot_sks', 1) }}" 
                                   min="1" 
                                   max="6"
                                   required>
                            @error('bobot_sks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-control @error('is_active') is-invalid @enderror" 
                                    id="is_active" 
                                    name="is_active">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('is_active')
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Update tingkat berdasarkan jenjang
        $('#jenjang').change(function() {
            var jenjang = $(this).val();
            var tingkatSelect = $('#tingkat');
            
            tingkatSelect.empty();
            tingkatSelect.append('<option value="">Semua Kelas</option>');
            
            if (jenjang) {
                var kelas = [];
                switch(jenjang) {
                    case 'SD':
                        kelas = [1, 2, 3, 4, 5, 6];
                        break;
                    case 'SMP':
                        kelas = [7, 8, 9];
                        break;
                    case 'SMA':
                    case 'SMK':
                        kelas = [10, 11, 12];
                        break;
                }
                
                kelas.forEach(function(tingkat) {
                    tingkatSelect.append('<option value="' + tingkat + '">Kelas ' + tingkat + '</option>');
                });
            }
        });

        // Auto generate kode
        function generateKode() {
            var nama = $('#nama').val();
            var jenjang = $('#jenjang').val();
            var kategori = $('#kategori').val();
            
            if (nama && jenjang && $('#generate_kode').is(':checked')) {
                // Ambil 3 huruf pertama dari nama
                var namaCode = nama.substring(0, 3).toUpperCase();
                
                // Tambahkan jenjang
                var jenjangCode = jenjang;
                
                // Tambahkan kategori
                var kategoriCode = '';
                switch(kategori) {
                    case 'wajib':
                        kategoriCode = 'W';
                        break;
                    case 'pilihan':
                        kategoriCode = 'P';
                        break;
                    case 'muatan_lokal':
                        kategoriCode = 'ML';
                        break;
                }
                
                var kode = namaCode + jenjangCode + kategoriCode;
                $('#kode').val(kode);
            }
        }

        // Event listeners untuk auto generate
        $('#nama, #jenjang, #kategori').on('input change', generateKode);
        
        $('#generate_kode').change(function() {
            if ($(this).is(':checked')) {
                generateKode();
            } else {
                $('#kode').val('');
            }
        });

        // Trigger initial change untuk mengisi tingkat jika ada old value
        @if(old('jenjang'))
            $('#jenjang').trigger('change');
            setTimeout(function() {
                $('#tingkat').val('{{ old("tingkat") }}');
            }, 100);
        @endif
    });
</script>
@endsection
