@extends('layouts.admin')
@section('title', 'Edit ' . ucfirst($artikel->jenis))
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Edit {{ ucfirst($artikel->jenis) }}</h3>
                    <a href="{{ url('/admin/artikel/' . $artikel->jenis) }}" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form id="artikelForm" action="{{ url('/admin/artikel/update/' . $artikel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Jenis Artikel -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Artikel <span class="text-danger">*</span></label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="berita" {{ $artikel->jenis == 'berita' ? 'selected' : '' }}>Berita</option>
                                    <option value="pengumuman" {{ $artikel->jenis == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                </select>
                                @error('jenis')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Judul -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $artikel->judul) }}" placeholder="Masukkan judul artikel">
                                @error('judul')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ringkasan -->
                            <div class="mb-3">
                                <label for="ringkasan" class="form-label">Ringkasan</label>
                                <textarea name="ringkasan" id="ringkasan" class="form-control" rows="3" placeholder="Ringkasan singkat artikel (opsional)">{{ old('ringkasan', $artikel->ringkasan) }}</textarea>
                                @error('ringkasan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Isi Artikel -->
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" class="form-control" rows="15" placeholder="Tulis isi artikel di sini...">{{ old('isi', $artikel->isi) }}</textarea>
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
                                    <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ old('status', $artikel->status) == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Artikel -->
                            <div class="mb-3">
                                <div class="card bg-light">
                                    <div class="card-body p-3">
                                        <h6 class="card-title">Info Artikel</h6>
                                        <small class="text-muted">
                                            <strong>Penulis:</strong> {{ $artikel->penulis->nama }}<br>
                                            <strong>Dibuat:</strong> {{ $artikel->created_at->format('d/m/Y H:i') }}<br>
                                            <strong>Diupdate:</strong> {{ $artikel->updated_at->format('d/m/Y H:i') }}<br>
                                            @if($artikel->tanggal_publish)
                                                <strong>Publish:</strong> {{ $artikel->tanggal_publish->format('d/m/Y H:i') }}<br>
                                            @endif
                                            <strong>Views:</strong> {{ number_format($artikel->views) }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Artikel</label>
                                
                                @if($artikel->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Saat Ini" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                        <p class="text-muted small mt-1">Gambar saat ini</p>
                                    </div>
                                @endif
                                
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Max: 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
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
                                    <i class="ph ph-floppy-disk"></i> Update
                                </button>
                                @if($artikel->status == 'draft')
                                    <button type="submit" name="action" value="save_and_publish" class="btn btn-success">
                                        <i class="ph ph-paper-plane-tilt"></i> Update & Publish
                                    </button>
                                @endif
                                <a href="{{ url('/admin/artikel/' . $artikel->jenis) }}" class="btn btn-secondary">
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
        // Handle form submission for save and publish
        $('button[name="action"]').click(function() {
            if ($(this).val() === 'save_and_publish') {
                $('#status').val('publish');
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

        // Auto resize textarea
        $('#isi').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
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
            const jenis = $('#jenis').val();
            const judul = $('#judul').val().trim();
            const isi = $('#isi').val().trim();

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

            if (!isi) {
                alert('Isi artikel wajib diisi');
                $('#isi').focus();
                e.preventDefault();
                return false;
            }

            // Show loading
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="ph ph-spinner"></i> Menyimpan...');
        });
    });
</script>

@endsection
