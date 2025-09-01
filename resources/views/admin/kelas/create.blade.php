@extends('layouts.admin')
@section('title', 'Tambah Kelas')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kelas</h1>
        <a href="/admin/kelas/" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kelas</h6>
        </div>
        <div class="card-body">
            <form action="/admin/kelas/store" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: VII-A"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode" class="form-label">Kode Kelas <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode') }}" 
                                   placeholder="Contoh: 7A2024">
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kosongkan untuk auto-generate</small>
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
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-control @error('tingkat') is-invalid @enderror" 
                                    id="tingkat" 
                                    name="tingkat" 
                                    required>
                                <option value="">Pilih Tingkat</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('kapasitas') is-invalid @enderror" 
                                   id="kapasitas" 
                                   name="kapasitas" 
                                   value="{{ old('kapasitas', 30) }}" 
                                   min="1" 
                                   max="50"
                                   required>
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="form-control @error('tahun_ajaran_id') is-invalid @enderror" 
                                    id="tahun_ajaran_id" 
                                    name="tahun_ajaran_id" 
                                    required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran Utama</label>
                            <select class="form-control @error('mata_pelajaran_id') is-invalid @enderror" 
                                    id="mata_pelajaran_id" 
                                    name="mata_pelajaran_id">
                                <option value="">Pilih Mata Pelajaran (Opsional)</option>
                                @foreach($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}" 
                                            data-jenjang="{{ $mp->jenjang }}"
                                            {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                        {{ $mp->kode }} - {{ $mp->nama }}
                                        @if($mp->jenjang)
                                            ({{ $mp->jenjang }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('mata_pelajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Untuk kelas mata pelajaran tertentu</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="3" 
                              placeholder="Deskripsi kelas...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                
                <div class="form-group text-right">
                    <a href="/admin/kelas/" class="btn btn-secondary">
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
            tingkatSelect.append('<option value="">Pilih Tingkat</option>');
            
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
            
            // Filter mata pelajaran berdasarkan jenjang
            filterMataPelajaran();
        });

        // Filter mata pelajaran berdasarkan jenjang
        function filterMataPelajaran() {
            var selectedJenjang = $('#jenjang').val();
            $('#mata_pelajaran_id option').each(function() {
                var optionJenjang = $(this).data('jenjang');
                if (!optionJenjang || optionJenjang === selectedJenjang || selectedJenjang === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Auto generate kode kelas
        function generateKode() {
            var jenjang = $('#jenjang').val();
            var tingkat = $('#tingkat').val();
            var nama = $('#nama').val();
            
            if (jenjang && tingkat && nama) {
                var tahun = new Date().getFullYear();
                var kode = tingkat + nama.replace(/[^A-Za-z]/g, '') + tahun;
                $('#kode').val(kode);
            }
        }

        $('#jenjang, #tingkat, #nama').on('change input', function() {
            if ($('#kode').val() === '') {
                generateKode();
            }
        });

        // Trigger change untuk old values
        @if(old('jenjang'))
            $('#jenjang').trigger('change');
            setTimeout(function() {
                $('#tingkat').val('{{ old("tingkat") }}');
            }, 100);
        @endif
    });
</script>
@endsection
