@extends('layouts.admin')
@section('title', 'Tambah Kategori Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tambah Kategori Galeri</h3>
                    <a href="{{ url('/admin/galeri/kategori') }}" class="btn btn-secondary">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="kategoriForm" method="POST" onsubmit="return false" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" style="height: auto;" rows="4" cols="6" placeholder="Deskripsi kategori galeri..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="aktif" selected>Aktif</option>
                                            <option value="nonaktif">Non-Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="urutan" class="form-label">Urutan</label>
                                        <input type="number" class="form-control" id="urutan" name="urutan" min="0" value="0">
                                        <small class="text-muted">Urutan tampil kategori (angka kecil tampil pertama)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gambar_cover" class="form-label">Gambar Cover</label>
                                <input type="file" class="form-control" id="gambar_cover" name="gambar_cover" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB</small>
                            </div>

                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="simpanDraft" class="btn btn-secondary">
                            <i class="ph ph-floppy-disk"></i> Simpan sebagai Draft
                        </button>
                        <button type="button" id="simpanAktif" class="btn btn-primary">
                            <i class="ph ph-check"></i> Simpan & Aktifkan
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
            } else {
                $('#imagePreview').hide();
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

            if (!namaKategori) {
                alert('Nama kategori wajib diisi');
                $('#nama_kategori').focus();
                return false;
            }

            return true;
        }

        // Function untuk submit kategori
        function submitKategori(status) {
            if (!validateForm()) {
                return false;
            }

            $('#status').val(status);
            const formData = new FormData($('#kategoriForm')[0]);

            let confirmMessage = status === 'aktif' ? 
                'Apakah Anda yakin ingin menyimpan dan mengaktifkan kategori ini?' : 
                'Apakah Anda yakin ingin menyimpan kategori sebagai draft?';

            confirmModal(confirmMessage, function() {
                ajxProcess('/admin/galeri/kategori-store', formData, '#message-modal');
            });
        }

        // Event handlers untuk tombol
        $('#simpanDraft').click(function() {
            submitKategori('nonaktif');
        });

        $('#simpanAktif').click(function() {
            submitKategori('aktif');
        });
    });
</script>

@endsection
