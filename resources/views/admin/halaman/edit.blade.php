@extends('admin.layouts.app')

@section('title', 'Edit Halaman')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Halaman</h3>
                        <div class="card-tools">
                            <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/halaman/update/' . $halaman->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="judul">Judul Halaman</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ $halaman->judul }}" required>
                            </div>
                            <div class="form-group">
                                <label for="isi">Konten</label>
                                <textarea class="form-control tinymce" id="isi" name="isi" rows="10">{{ $halaman->isi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar (Opsional)</label>
                                @if($halaman->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('img/halaman/' . $halaman->gambar) }}" alt="{{ $halaman->judul }}" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @endif
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*">
                                        <label class="custom-file-label" for="gambar">{{ $halaman->gambar ? 'Ganti gambar' : 'Pilih file' }}</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="draft" {{ $halaman->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ $halaman->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ url('/admin/halaman') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Initialize TinyMCE
            tinymce.init({
                selector: '.tinymce',
                height: 400,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css'
                ],
                file_picker_callback: function(callback, value, meta) {
                    // File picker logic if needed
                }
            });

            // Show file name when selected
            $(document).on('change', '.custom-file-input', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endpush