@extends('layouts.admin')
@section('title', 'Edit Kategori Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Kategori Galeri</h3>
                    <a href="{{ url('/admin/galeri/kategori') }}" class="btn btn-secondary">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="kategoriForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi kategori galeri...">{{ $kategori->deskripsi }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="aktif" {{ $kategori->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ $kategori->status == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="urutan" class="form-label">Urutan</label>
                                        <input type="number" class="form-control" id="urutan" name="urutan" min="0" value="{{ $kategori->urutan }}">
                                        <small class="text-muted">Urutan tampil kategori (angka kecil tampil pertama)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gambar_cover" class="form-label">Gambar Cover</label>
                                <input type="file" class="form-control" id="gambar_cover" name="gambar_cover" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                            </div>

                            <div id="imagePreview" class="mb-3" @if($kategori->gambar_cover) @else style="display: none;" @endif>
                                <img id="previewImg" src="{{ $kategori->gambar_cover ? asset('img/galeri/kategori/' . $kategori->gambar_cover) : '' }}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                @if($kategori->gambar_cover)
                                    <div class="mt-2">
                                        <small class="text-muted">Gambar saat ini</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="updateKategori" class="btn btn-primary">
                            <i class="ph ph-check"></i> Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Image preview
        $('#gambar_cover').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Character counter for nama kategori
        $('#nama_kategori').on('input', function() {
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

        // Function untuk validasi form
        function validateForm() {
            const namaKategori = $('#nama_kategori').val().trim();
            const status = $('#status').val();

            if (!namaKategori) {
                alert('Nama kategori wajib diisi');
                $('#nama_kategori').focus();
                return false;
            }

            if (!status) {
                alert('Status wajib dipilih');
                $('#status').focus();
                return false;
            }

            return true;
        }

        // Update kategori
        $('#updateKategori').click(function() {
            if (!validateForm()) {
                return false;
            }

            const formData = new FormData($('#kategoriForm')[0]);

            confirmModal('Apakah Anda yakin ingin mengupdate kategori ini?', function() {
                ajxProcess('/admin/galeri/kategori/update/{{ $kategori->id }}', formData, '#message-modal');
            });
        });
    });
</script>

@endsection
