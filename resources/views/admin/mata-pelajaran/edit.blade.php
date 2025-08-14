@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Mata Pelajaran</h1>
        <div>
            <a href="/admin/mata-pelajaran/show/{{ $mataPelajaran->id }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-eye fa-sm text-white-50"></i> Detail
            </a>
            <a href="/admin/mata-pelajaran/" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
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
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Mata Pelajaran</h6>
        </div>
        <div class="card-body">
            <form action="/admin/mata-pelajaran/update/{{ $mataPelajaran->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $mataPelajaran->nama) }}" 
                                   placeholder="Contoh: Matematika"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode" class="form-label">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode', $mataPelajaran->kode) }}" 
                                   placeholder="Kode mata pelajaran"
                                   required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kode harus unik</small>
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
                                <option value="SD" {{ old('jenjang', $mataPelajaran->jenjang) === 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jenjang', $mataPelajaran->jenjang) === 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('jenjang', $mataPelajaran->jenjang) === 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('jenjang', $mataPelajaran->jenjang) === 'SMK' ? 'selected' : '' }}>SMK</option>
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
                                <option value="wajib" {{ old('kategori', $mataPelajaran->kategori) === 'wajib' ? 'selected' : '' }}>Wajib</option>
                                <option value="pilihan" {{ old('kategori', $mataPelajaran->kategori) === 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                                <option value="muatan_lokal" {{ old('kategori', $mataPelajaran->kategori) === 'muatan_lokal' ? 'selected' : '' }}>Muatan Lokal</option>
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
                                   value="{{ old('bobot_sks', $mataPelajaran->bobot_sks) }}" 
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
                                <option value="1" {{ old('is_active', $mataPelajaran->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $mataPelajaran->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Dibuat</label>
                            <div class="form-control-plaintext">
                                <small class="text-muted">{{ $mataPelajaran->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              placeholder="Deskripsi mata pelajaran...">{{ old('deskripsi', $mataPelajaran->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Info Usage -->
                @if($usageCount > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Mata pelajaran ini sedang digunakan pada {{ $usageCount }} kelas. 
                    Perubahan pada jenjang/tingkat dapat mempengaruhi kelas-kelas tersebut.
                </div>
                @endif

                <hr>
                
                <div class="form-group text-right">
                    <a href="/admin/mata-pelajaran/" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <a href="/admin/mata-pelajaran/show/{{ $mataPelajaran->id }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    @if($usageCount > 0)
    <div class="row">
        <div class="col-xl-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Penggunaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usageCount }} Kelas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Update tingkat berdasarkan jenjang
        function updateTingkat() {
            var jenjang = $('#jenjang').val();
            var tingkatSelect = $('#tingkat');
            var currentTingkat = '{{ old("tingkat", $mataPelajaran->tingkat) }}';
            
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
                    var selected = (currentTingkat == tingkat) ? 'selected' : '';
                    tingkatSelect.append('<option value="' + tingkat + '" ' + selected + '>Kelas ' + tingkat + '</option>');
                });
            }
        }

        $('#jenjang').change(updateTingkat);
        
        // Initialize tingkat
        updateTingkat();
    });
</script>
@endsection
