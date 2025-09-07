@extends('layouts.admin')
@section('title', isset($jenis) ? 'Tambah ' . ucfirst($jenis) : 'Tambah Artikel')

@push('styles')
<script src="https://cdn.tiny.cloud/1/sn32vy26z8kumz26wibs2fxo0g1tt4jyps2d26s2epz27j2m/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<style>
.tox-tinymce {
    border-radius: 6px !important;
    border: 1px solid #d1d5db !important;
}
.tox .tox-edit-area__iframe {
    background-color: #fff !important;
}
</style>
@endpush

@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">
                        @if(isset($jenis))
                            Tambah {{ ucfirst($jenis) }}
                        @else
                            Tambah Artikel
                        @endif
                    </h3>
                    <a href="{{ url('/admin/artikel' . (isset($jenis) ? '/' . $jenis : '')) }}" class="btn btn-secondary btn-add">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="artikelForm" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Jenis Artikel -->
                            <input type="hidden" name="jenis" id="jenis" class="form-control" value="{{ $jenis }}">

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" id="kategori" class="form-select">
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Judul -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul artikel">
                            </div>

                            <!-- Isi Artikel -->
                            <div class="mt-20">
                                <label for="isi" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" class="form-control tinymce-editor" placeholder="Tulis isi artikel di sini...">{{ old('isi') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish Sekarang</option>
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Jadwalkan Publish</option>
                                </select>
                            </div>

                            <!-- Tanggal Publish (untuk status scheduled) -->
                            <div class="mb-3" id="tanggal-publish-group" style="display: none;">
                                <label for="tanggal_publish" class="form-label">Tanggal & Waktu Publish <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="tanggal_publish" id="tanggal_publish" class="form-control" value="{{ old('tanggal_publish') }}">
                                <div class="form-text">Artikel akan otomatis dipublish pada tanggal dan waktu yang ditentukan</div>
                            </div>

                            <!-- Gambar -->
                            <div class="mt-20">
                                <label for="gambar" class="form-label">Gambar Artikel</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Max: 2MB</div>
                                
                                <!-- Preview Image -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex gap-5 mt-20">
                                <button type="button" id="simpanDraft" class="btn btn-secondary btn-add">
                                    <i class="ph ph-floppy-disk"></i> Simpan sebagai Draft
                                </button>
                                <button type="button" id="publishSekarang" class="btn btn-success btn-add">
                                    <i class="ph ph-paper-plane-tilt"></i> Publish Sekarang
                                </button>
                                <button type="button" id="jadwalkanPublish" class="btn btn-primary btn-add" style="display: none;">
                                    <i class="ph ph-clock"></i> Jadwalkan Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize TinyMCE
        TinyMCE('.tinymce-editor');

        // Handle status change untuk show/hide tanggal publish
        $('#status').change(function() {
            const status = $(this).val();
            if (status === 'scheduled') {
                $('#tanggal-publish-group').show();
                $('#jadwalkanPublish').show();
                $('#publishSekarang').hide();
                $('#tanggal_publish').attr('required', true);
            } else {
                $('#tanggal-publish-group').hide();
                $('#jadwalkanPublish').hide();
                $('#publishSekarang').show();
                $('#tanggal_publish').attr('required', false);
            }
        });

        // Set minimum date untuk tanggal publish (tidak boleh kurang dari sekarang)
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        $('#tanggal_publish').attr('min', minDateTime);

        // Function untuk validasi form
        function validateForm() {
            tinymce.triggerSave();
            
            const jenis = $('#jenis').val();
            const judul = $('#judul').val().trim();
            const isi = tinymce.get('isi').getContent().trim();
            const status = $('#status').val();
            const tanggalPublish = $('#tanggal_publish').val();

            if (!jenis) {
                alert('Pilih jenis artikel terlebih dahulu');
                $('#jenis').focus();
                return false;
            }

            if (!judul) {
                alert('Judul artikel wajib diisi');
                $('#judul').focus();
                return false;
            }

            if (!isi || isi === '<p></p>' || isi === '') {
                alert('Isi artikel wajib diisi');
                tinymce.get('isi').focus();
                return false;
            }

            if (status === 'scheduled' && !tanggalPublish) {
                alert('Tanggal publish wajib diisi untuk artikel terjadwal');
                $('#tanggal_publish').focus();
                return false;
            }

            if (status === 'scheduled' && new Date(tanggalPublish) <= new Date()) {
                alert('Tanggal publish harus lebih dari waktu sekarang');
                $('#tanggal_publish').focus();
                return false;
            }

            return true;
        }

        // Function untuk submit artikel
        function submitArtikel(actionType) {
            if (!validateForm()) {
                return false;
            }

            // Set status berdasarkan action
            let statusValue = 'draft';
            let confirmMessage = 'Apakah Anda yakin ingin menyimpan artikel sebagai draft?';
            
            if (actionType === 'publish') {
                statusValue = 'publish';
                confirmMessage = 'Apakah Anda yakin ingin mempublish artikel sekarang?';
            } else if (actionType === 'schedule') {
                statusValue = 'scheduled';
                const tanggal = new Date($('#tanggal_publish').val()).toLocaleString('id-ID');
                confirmMessage = `Apakah Anda yakin ingin menjadwalkan publish artikel pada ${tanggal}?`;
            }

            $('#status').val(statusValue);
            const data = new FormData($('#artikelForm')[0]);

            confirmModal(confirmMessage, function() {
                ajxProcess('/admin/artikel/store', data, '#message-modal');
            });
        }

        // Event handlers untuk tombol
        $('#simpanDraft').click(function() {
            submitArtikel('draft');
        });

        $('#publishSekarang').click(function() {
            submitArtikel('publish');
        });

        $('#jadwalkanPublish').click(function() {
            submitArtikel('schedule');
        });

        // Image preview
        $('#gambar').change(function() {
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
</script>

@endsection
