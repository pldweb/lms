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
                    <a href="{{ url('/admin/artikel' . (isset($jenis) ? '/' . $jenis : '')) }}" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="artikelForm" action="{{ url('/admin/artikel/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Jenis Artikel -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Artikel <span class="text-danger">*</span></label>
                                <select name="jenis" id="jenis" class="form-select" {{ isset($jenis) ? 'readonly' : '' }}>
                                    <option value="">Pilih Jenis Artikel</option>
                                    <option value="berita" {{ (isset($jenis) && $jenis == 'berita') || old('jenis') == 'berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="pengumuman" {{ (isset($jenis) && $jenis == 'pengumuman') || old('jenis') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                                @error('jenis')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Judul -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul artikel">
                                @error('judul')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ringkasan -->
                            <div class="mb-3">
                                <label for="ringkasan" class="form-label">Ringkasan</label>
                                <textarea name="ringkasan" id="ringkasan" class="form-control" rows="3" placeholder="Ringkasan singkat artikel (opsional)">{{ old('ringkasan') }}</textarea>
                                @error('ringkasan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Isi Artikel -->
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" class="form-control tinymce-editor" placeholder="Tulis isi artikel di sini...">{{ old('isi') }}</textarea>
                                @error('isi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Artikel</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Max: 2MB</div>
                                @error('gambar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                
                                <!-- Preview Image -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="mb-3 d-grid gap-2">
                                <button type="submit" name="action" value="save" class="btn btn-primary">
                                    <i class="ph ph-floppy-disk"></i> Simpan
                                </button>
                                <button type="submit" name="action" value="save_and_publish" class="btn btn-success">
                                    <i class="ph ph-paper-plane-tilt"></i> Simpan & Publish
                                </button>
                                <a href="{{ url('/admin/artikel' . (isset($jenis) ? '/' . $jenis : '')) }}" class="btn btn-secondary">
                                    <i class="ph ph-x"></i> Batal
                                </a>
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
        tinymce.init({
            selector: '.tinymce-editor',
            height: 500,
            menubar: true,
            language: 'id',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'paste',
                'textcolor', 'colorpicker', 'hr', 'pagebreak', 'nonbreaking'
            ],
            toolbar1: 'undo redo | cut copy paste | bold italic underline strikethrough | ' +
                'fontfamily fontsize | forecolor backcolor | alignleft aligncenter alignright alignjustify',
            toolbar2: 'bullist numlist | outdent indent | blockquote hr | ' +
                'table link image media | insertdatetime charmap | ' +
                'searchreplace | preview code fullscreen | help',
            font_family_formats: 
                'Arial=arial,helvetica,sans-serif; ' +
                'Georgia=georgia,serif; ' +
                'Helvetica=helvetica; ' +
                'Times New Roman=times new roman,times; ' +
                'Verdana=verdana,geneva;',
            font_size_formats: '8px 10px 12px 14px 16px 18px 20px 24px 28px 32px 36px 48px',
            block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6; Preformatted=pre',
            content_style: `
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
                    font-size: 14px; 
                    line-height: 1.6;
                    margin: 1rem;
                }
                img { max-width: 100%; height: auto; }
                table { border-collapse: collapse; width: 100%; }
                table td, table th { border: 1px solid #ddd; padding: 8px; }
            `,
            paste_as_text: false,
            paste_auto_cleanup_on_paste: true,
            paste_remove_styles: false,
            paste_remove_spans: false,
            paste_strip_class_attributes: 'all',
            extended_valid_elements: 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style]',
            image_advtab: true,
            image_caption: true,
            image_title: true,
            automatic_uploads: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
                editor.on('init', function () {
                    console.log('TinyMCE initialized successfully');
                });
            },
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    
                    input.onchange = function () {
                        const file = this.files[0];
                        if (file && file.size <= 5 * 1024 * 1024) { // Max 5MB
                            const reader = new FileReader();
                            reader.onload = function () {
                                callback(reader.result, {
                                    alt: file.name,
                                    title: file.name
                                });
                            };
                            reader.readAsDataURL(file);
                        } else {
                            alert('Ukuran file terlalu besar. Maksimal 5MB.');
                        }
                    };
                    
                    input.click();
                }
            }
        });

        // Handle form submission for save and publish
        $('button[name="action"]').click(function() {
            // Sync TinyMCE content
            tinymce.triggerSave();
            
            if ($(this).val() === 'save_and_publish') {
                $('#status').val('publish');
            } else {
                $('#status').val('draft');
            }
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

        // Form validation
        $('#artikelForm').submit(function(e) {
            // Sync TinyMCE content before validation
            tinymce.triggerSave();
            
            const jenis = $('#jenis').val();
            const judul = $('#judul').val().trim();
            const isi = tinymce.get('isi').getContent().trim();

            if (!jenis) {
                alert('Pilih jenis artikel terlebih dahulu');
                $('#jenis').focus();
                e.preventDefault();
                return false;
            }

            if (!judul) {
                alert('Judul artikel wajib diisi');
                $('#judul').focus();
                e.preventDefault();
                return false;
            }

            if (!isi || isi === '<p></p>' || isi === '') {
                alert('Isi artikel wajib diisi');
                tinymce.get('isi').focus();
                e.preventDefault();
                return false;
            }

            // Show loading
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="ph ph-spinner"></i> Menyimpan...');
        });

        @if(isset($jenis))
        // Disable jenis select if jenis is preset
        $('#jenis').prop('disabled', true);
        @endif
    });
</script>

@endsection
