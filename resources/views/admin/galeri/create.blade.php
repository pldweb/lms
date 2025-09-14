@extends('layouts.admin')
@section('title', isset($galeri) ? 'Edit Item Galeri' : 'Tambah Item Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ isset($galeri) ? 'Edit Item Galeri' : 'Tambah Item Galeri' }}</h3>
                        <a href="{{ url('/admin/galeri') }}" class="btn btn-secondary">
                            <i class="ph ph-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($galeri))
                    <form id="galeriForm" enctype="multipart/form-data" onsubmit="return false;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $galeri->id }}">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                    <form id="galeriForm" enctype="multipart/form-data" onsubmit="return false;">
                        @csrf
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_galeri_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="kategori_galeri" name="kategori_galeri_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}" {{ isset($galeri) && $galeri->kategori_galeri_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ isset($galeri) ? $galeri->judul : '' }}" required>
                                <small class="text-muted">{{ !isset($galeri) ? 'Untuk multiple items, nomor akan ditambahkan otomatis' : '' }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi galeri...">{{ isset($galeri) ? $galeri->deskripsi : '' }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_foto" class="form-label">Tanggal Foto</label>
                                        <input type="date" class="form-control" id="tanggal_foto" name="tanggal_foto" value="{{ isset($galeri) && $galeri->tanggal_foto ? $galeri->tanggal_foto->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fotografer" class="form-label">Fotografer</label>
                                        <input type="text" class="form-control" id="fotografer" name="fotografer" placeholder="Nama fotografer..." value="{{ isset($galeri) ? $galeri->fotografer : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ isset($galeri) && $galeri->status == 'aktif' ? 'selected' : (!isset($galeri) ? 'selected' : '') }}>Aktif</option>
                                    <option value="nonaktif" {{ isset($galeri) && $galeri->status == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Konten <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe" id="tipe_foto" value="foto" checked>
                                        <label class="form-check-label" for="tipe_foto">
                                            <i class="ph ph-image"></i> Upload Foto
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="tipe" value="foto">
                            </div>

                            <!-- Upload Foto Section -->
                            <div id="foto-section">
                                @if(isset($galeri))
                                <div class="mb-3">
                                    <label for="file" class="form-label">Foto Saat Ini</label>
                                    <div class="card mb-2">
                                        <img src="{{ asset('img/galeri/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}" class="card-img-top img-thumbnail" style="max-height: 200px; object-fit: contain;">
                                        <div class="card-body p-2">
                                            <p class="card-text small">{{ $galeri->file_path }}</p>
                                        </div>
                                    </div>
                                    <label for="file" class="form-label">Ganti Foto</label>
                                    <input type="file" class="form-control" id="file" name="file" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB. Biarkan kosong jika tidak ingin mengganti foto.</small>
                                </div>
                                @else
                                <div class="mb-3">
                                    <label for="files" class="form-label">Upload Foto <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="files" name="files[]" accept="image/*" multiple>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB per file. Bisa pilih multiple files.</small>
                                </div>

                                <div id="imagePreview" class="mb-3" style="display: none;">
                                    <div class="row" id="previewContainer"></div>
                                </div>
                                @endif
                            </div>


                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="simpanDraft" class="btn btn-secondary btn-add">
                            <i class="ph ph-floppy-disk"></i> {{ isset($galeri) ? 'Update sebagai Non-Aktif' : 'Simpan sebagai Non-Aktif' }}
                        </button>
                        <button type="button" id="simpanAktif" class="btn btn-primary btn-add">
                            <i class="ph ph-check"></i> {{ isset($galeri) ? 'Update & Aktifkan' : 'Simpan & Aktifkan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        initSelect2(".select2");

        // Image preview for multiple files
        $('#files').change(function() {
            const files = this.files;
            const previewContainer = $('#imagePreview');
            $('#previewContainer').html('');
            
            if (files.length > 0) {
                previewContainer.show();
                
                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#previewContainer').append(`
                                <div class="col-md-4 mb-2">
                                    <div class="card">
                                        <img src="${e.target.result}" alt="Preview ${index + 1}" class="card-img-top img-thumbnail" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <p class="card-text small text-truncate">${file.name}</p>
                                            <p class="card-text small text-muted">${(file.size / 1024).toFixed(2)} KB</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previewContainer.hide();
            }
        });



        // Character counter for judul
        $('#judul').on('input', function() {
            const maxLength = 255;
            const currentLength = $(this).val().length;
            const remaining = maxLength - currentLength;
            
            if (!$(this).next('.char-counter').length) {
                $(this).after('<div class="char-counter text-muted small"></div>');
            }
            
            $(this).next('.char-counter').text(remaining + ' karakter tersisa');
            
            if (remaining < 20) {
                $(this).next('.char-counter').removeClass('text-muted').addClass('text-warning');
            } else {
                $(this).next('.char-counter').removeClass('text-warning').addClass('text-muted');
            }
        });

    });

        // Function untuk submit galeri
        function submitGaleri(status) {
            // Validasi form terlebih dahulu
            if (!validateForm()) {
                return false;
            }

            $('#status').val(status);
            const formData = new FormData($('#galeriForm')[0]);
            
            // Tentukan URL berdasarkan mode (create atau update)
            const isUpdate = {{ isset($galeri) ? 'true' : 'false' }};
            const url = isUpdate ? '{{ url("/admin/galeri/update") }}' : '{{ url("/admin/galeri/store") }}';
            
            let confirmMessage;
            if (isUpdate) {
                confirmMessage = status === 'aktif' ? 
                    'Apakah Anda yakin ingin mengupdate dan mengaktifkan item galeri ini?' : 
                    'Apakah Anda yakin ingin mengupdate item sebagai non-aktif?';
            } else {
                confirmMessage = status === 'aktif' ? 
                    'Apakah Anda yakin ingin menyimpan dan mengaktifkan item galeri ini?' : 
                    'Apakah Anda yakin ingin menyimpan item sebagai non-aktif?';
            }

            confirmModal(confirmMessage, function() {
                ajxProcess(url, formData, '#message-modal');
            });
        }

        // Validasi form sebelum submit
        function validateForm() {
            let isValid = true;
            const isUpdate = {{ isset($galeri) ? 'true' : 'false' }};
            
            // Validasi kategori
            if (!$('#kategori_galeri').val()) {
                isValid = false;
                alert('Silakan pilih kategori galeri');
                return isValid;
            }
            
            // Validasi judul
            if (!$('#judul').val()) {
                isValid = false;
                alert('Silakan isi judul galeri');
                return isValid;
            }
            
            // Validasi file foto - hanya untuk mode create
            if (!isUpdate) {
                if ($('#files').get(0).files.length === 0) {
                    isValid = false;
                    alert('Silakan pilih minimal satu file foto');
                    return isValid;
                }
            }
            
            return isValid;
        }

        // Event handlers untuk tombol
        $('#simpanDraft').click(function() {
            submitGaleri('nonaktif');
        });

        $('#simpanAktif').click(function() {
            submitGaleri('aktif');
        });
</script>

@endsection
