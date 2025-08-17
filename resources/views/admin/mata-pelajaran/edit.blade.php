@extends('layouts.admin')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Edit Mata Pelajaran</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="/admin/mata-pelajaran/show/{{ $mataPelajaran->id }}" class="btn btn-info btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-eye"></i> Detail
                        </a>
                        <a href="/admin/mata-pelajaran/" class="btn btn-secondary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-top: 0;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
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
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-control @error('semester') is-invalid @enderror" 
                                    id="semester" 
                                    name="semester" 
                                    required>
                                <option value="">Pilih Semester</option>
                                <option value="1" {{ old('semester', $mataPelajaran->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                                <option value="2" {{ old('semester', $mataPelajaran->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('sks') is-invalid @enderror" 
                                   id="sks" 
                                   name="sks" 
                                   value="{{ old('sks', $mataPelajaran->sks) }}" 
                                   min="1" 
                                   max="6"
                                   required>
                            @error('sks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="urutan" class="form-label">Urutan</label>
                            <input type="number" 
                                   class="form-control @error('urutan') is-invalid @enderror" 
                                   id="urutan" 
                                   name="urutan" 
                                   value="{{ old('urutan', $mataPelajaran->urutan) }}" 
                                   min="1">
                            @error('urutan')
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
                                <option value="1" {{ old('aktif', $mataPelajaran->aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('aktif', $mataPelajaran->aktif) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('aktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Dibuat</label>
                            <div class="form-control-plaintext">
                                <small class="text-muted">{{ $mataPelajaran->created_at }}</small>
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
                    
                </div>

                <!-- Info Usage -->
                @if($jumlahKelas > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Mata pelajaran ini sedang digunakan pada {{ $jumlahKelas }} kelas. 
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
                    </div>
                </div>

                <!-- Stats Cards -->
                @if($jumlahKelas > 0)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Penggunaan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKelas }} Kelas</div>
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Update tingkat berdasarkan jenjang
        function updateTingkat() {
            var jenjang = $('#jenjang').val();
            var tingkatSelect = $('#tingkat');
            var currentTingkat = '{{ old("tingkat", "") }}';
            
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
