@extends('layouts.admin')
@section('title', 'Tambah Item Galeri')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tambah Item Galeri</h3>
                    <a href="{{ url('/admin/galeri') }}" class="btn btn-secondary">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="galeriForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_galeri_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="kategori_galeri" name="kategori_galeri" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                                <small class="text-muted">Untuk multiple items, nomor akan ditambahkan otomatis</small>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi galeri..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_foto" class="form-label">Tanggal Foto/Video</label>
                                        <input type="date" class="form-control" id="tanggal_foto" name="tanggal_foto">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fotografer" class="form-label">Fotografer/Videografer</label>
                                        <input type="text" class="form-control" id="fotografer" name="fotografer" placeholder="Nama fotografer...">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Non-Aktif</option>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe" id="tipe_video" value="video">
                                        <label class="form-check-label" for="tipe_video">
                                            <i class="ph ph-video"></i> Video YouTube
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Foto Section -->
                            <div id="foto-section">
                                <div class="mb-3">
                                    <label for="files" class="form-label">Upload Foto <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="files" name="files[]" accept="image/*" multiple>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 5MB per file. Bisa pilih multiple files.</small>
                                </div>

                                <div id="imagePreview" class="mb-3"></div>
                            </div>

                            <!-- Video YouTube Section -->
                            <div id="video-section" style="display: none;">
                                <div class="mb-3">
                                    <label for="youtube_urls" class="form-label">URL Video YouTube <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="youtube_urls" name="youtube_urls" rows="8" placeholder="Masukkan URL YouTube, satu URL per baris:&#10;https://youtu.be/videoID1&#10;https://www.youtube.com/watch?v=videoID2&#10;..."></textarea>
                                    <small class="text-muted">
                                        Format yang didukung:<br>
                                        • https://youtu.be/videoID<br>
                                        • https://www.youtube.com/watch?v=videoID<br>
                                        Satu URL per baris untuk multiple video
                                    </small>
                                </div>

                                <div id="videoPreview" class="mb-3"></div>
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

        initSelect2(".select2");

        // Toggle content type
        $('input[name="tipe"]').change(function() {
            if ($(this).val() === 'foto') {
                $('#foto-section').show();
                $('#video-section').hide();
                $('#files').attr('required', true);
                $('#youtube_urls').attr('required', false);
            } else {
                $('#foto-section').hide();
                $('#video-section').show();
                $('#files').attr('required', false);
                $('#youtube_urls').attr('required', true);
            }
        });

        // Image preview for multiple files
        $('#files').change(function() {
            const files = this.files;
            const previewContainer = $('#imagePreview');
            previewContainer.empty();

            if (files.length > 0) {
                previewContainer.append('<h6>Preview Foto (' + files.length + ' file):</h6>');
                previewContainer.append('<div class="row" id="previewGrid"></div>');

                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#previewGrid').append(`
                                <div class="col-md-4 mb-2">
                                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="img-fluid rounded" style="max-height: 120px; width: 100%; object-fit: cover;">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // YouTube URL preview
        $('#youtube_urls').on('input', function() {
            const urls = $(this).val().split('\n').filter(url => url.trim() !== '');
            const previewContainer = $('#videoPreview');
            previewContainer.empty();

            if (urls.length > 0) {
                previewContainer.append('<h6>Preview Video (' + urls.length + ' video):</h6>');
                previewContainer.append('<div class="row" id="videoGrid"></div>');

                urls.forEach((url, index) => {
                    const videoId = extractYouTubeID(url.trim());
                    if (videoId) {
                        $('#videoGrid').append(`
                            <div class="col-md-4 mb-2">
                                <div class="position-relative">
                                    <img src="https://img.youtube.com/vi/${videoId}/maxresdefault.jpg" alt="Video ${index + 1}" class="img-fluid rounded" style="max-height: 120px; width: 100%; object-fit: cover;">
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="ph ph-play-circle text-white" style="font-size: 24px; text-shadow: 0 0 5px rgba(0,0,0,0.5);"></i>
                                    </div>
                                </div>
                                <small class="text-muted">Video ${index + 1}</small>
                            </div>
                        `);
                    }
                });
            }
        });

        function extractYouTubeID(url) {
            const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[7].length === 11) ? match[7] : false;
        }

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

        // Function untuk validasi form
        function validateForm() {
            const kategori = $('#kategori_galeri_id').val();
            const judul = $('#judul').val().trim();
            const tipe = $('input[name="tipe"]:checked').val();

            if (!kategori) {
                alert('Kategori wajib dipilih');
                $('#kategori_galeri_id').focus();
                return false;
            }

            if (!judul) {
                alert('Judul wajib diisi');
                $('#judul').focus();
                return false;
            }

            if (tipe === 'foto') {
                const files = $('#files')[0].files;
                if (files.length === 0) {
                    alert('Minimal 1 foto harus diupload');
                    $('#files').focus();
                    return false;
                }
            } else if (tipe === 'video') {
                const urls = $('#youtube_urls').val().trim();
                if (!urls) {
                    alert('URL YouTube wajib diisi');
                    $('#youtube_urls').focus();
                    return false;
                }
            }

            return true;
        }

        // Function untuk submit galeri
        function submitGaleri(status) {
            if (!validateForm()) {
                return false;
            }

            $('#status').val(status);
            const formData = new FormData($('#galeriForm')[0]);

            let confirmMessage = status === 'aktif' ? 
                'Apakah Anda yakin ingin menyimpan dan mengaktifkan item galeri ini?' : 
                'Apakah Anda yakin ingin menyimpan item sebagai draft?';

            confirmModal(confirmMessage, function() {
                ajxProcess('/admin/galeri/store', formData, '#message-modal');
            });
        }

        // Event handlers untuk tombol
        $('#simpanDraft').click(function() {
            submitGaleri('nonaktif');
        });

        $('#simpanAktif').click(function() {
            submitGaleri('aktif');
        });
    });
</script>

@endsection
