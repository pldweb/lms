@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Kuis</h4>
                    <a href="{{ url('/admin/kuis') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <div id="message-modal"></div>

                    <form id="kuisForm" onsubmit="return false;">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="judul">Judul Kuis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $kuis->judul) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $kuis->deskripsi) }}</textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="instruksi">Instruksi Pengerjaan</label>
                                    <textarea class="form-control" id="instruksi" name="instruksi" rows="4">{{ old('instruksi', $kuis->instruksi) }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jumlah_soal">Jumlah Soal (0 = Semua Soal)</label>
                                    <input type="number" class="form-control" id="jumlah_soal" name="jumlah_soal" value="{{ old('jumlah_soal', $kuis->jumlah_soal) }}" min="0">
                                    <small class="text-muted">Jika diisi 0, maka semua soal akan ditampilkan</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="acak_soal" name="acak_soal" value="1" {{ old('acak_soal', $kuis->acak_soal) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="acak_soal">
                                            Acak Urutan Soal
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="acak_jawaban" name="acak_jawaban" value="1" {{ old('acak_jawaban', $kuis->acak_jawaban) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="acak_jawaban">
                                            Acak Urutan Jawaban
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tampilkan_hasil" name="tampilkan_hasil" value="1" {{ old('tampilkan_hasil', $kuis->tampilkan_hasil) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tampilkan_hasil">
                                            Tampilkan Hasil Kuis kepada Siswa
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tampilkan_kunci" name="tampilkan_kunci" value="1" {{ old('tampilkan_kunci', $kuis->tampilkan_kunci) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tampilkan_kunci">
                                            Tampilkan Kunci Jawaban kepada Siswa
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="button" id="btnSubmit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ url('/admin/kuis') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi TinyMCE untuk deskripsi dan instruksi
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#deskripsi, #instruksi',
                height: 200,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help'
            });
        }
        
        // Character counter untuk judul
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
        
        // Form validation dan submit
        $('#btnSubmit').click(function() {
            // Sync TinyMCE content before validation
            tinymce.triggerSave();
            
            const judul = $('#judul').val().trim();
            const deskripsi = tinymce.get('deskripsi').getContent().trim();
            const instruksi = tinymce.get('instruksi').getContent().trim();

            if (!judul) {
                alert('Judul kuis wajib diisi');
                $('#judul').focus();
                return false;
            }
            
            confirmModal('Apakah Anda yakin ingin menyimpan perubahan kuis ini?', function() {
                ajxProcess("{{ url('/admin/kuis/update/' . $kuis->id) }}", new FormData($('#kuisForm')[0]), "#message-modal");
            });
        });
    });
</script>
@endsection