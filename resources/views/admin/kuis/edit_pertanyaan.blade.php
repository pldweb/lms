@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Soal Kuis</h4>
                    <a href="{{ url('/admin/kuis/pertanyaan/' . $pertanyaan->kuis_id) }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <div id="message-modal"></div>

                    <form id="pertanyaanForm" onsubmit="return false;" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tipe">Tipe Soal <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipe" name="tipe" required>
                                <option value="pilihan_ganda" {{ $pertanyaan->tipe == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                <option value="benar_salah" {{ $pertanyaan->tipe == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
                                <option value="isian" {{ $pertanyaan->tipe == 'isian' ? 'selected' : '' }}>Isian</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="pertanyaan">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="gambar">Gambar (Opsional)</label>
                            @if($pertanyaan->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $pertanyaan->gambar) }}" alt="Gambar Soal" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="hapus_gambar" name="hapus_gambar" value="1">
                                    <label class="form-check-label" for="hapus_gambar">
                                        Hapus gambar saat ini
                                    </label>
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                        </div>
                        
                        <!-- Pilihan Ganda Options -->
                        <div id="pilihan_ganda_options" style="display: {{ $pertanyaan->tipe == 'pilihan_ganda' ? 'block' : 'none' }}">
                            <h5 class="mt-4 mb-3">Pilihan Jawaban</h5>
                            <div class="pilihan-container">
                                @if($pertanyaan->tipe == 'pilihan_ganda')
                                    @foreach($pertanyaan->jawaban as $index => $jawaban)
                                        <div class="form-group row pilihan-item">
                                            <div class="col-md-1">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="radio" name="jawaban_benar" value="{{ $index }}" {{ $jawaban->benar ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="pilihan[]" value="{{ $jawaban->jawaban }}" placeholder="Pilihan jawaban">
                                                <input type="hidden" name="jawaban_id[]" value="{{ $jawaban->id }}">
                                            </div>
                                            <div class="col-md-1">
                                                @if($index > 0) <!-- Minimal harus ada 1 pilihan -->
                                                <button type="button" class="btn btn-sm btn-danger hapus-pilihan">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group row pilihan-item">
                                        <div class="col-md-1">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="jawaban_benar" value="0" checked>
                                            </div>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan jawaban">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="tambah_pilihan">
                                <i class="fas fa-plus"></i> Tambah Pilihan
                            </button>
                        </div>
                        
                        <!-- Benar/Salah Options -->
                        <div id="benar_salah_options" style="display: {{ $pertanyaan->tipe == 'benar_salah' ? 'block' : 'none' }}">
                            <h5 class="mt-4 mb-3">Jawaban Benar</h5>
                            @php
                                $jawabanBenar = null;
                                if($pertanyaan->tipe == 'benar_salah' && $pertanyaan->jawaban->count() > 0) {
                                    foreach($pertanyaan->jawaban as $jawaban) {
                                        if($jawaban->benar) {
                                            $jawabanBenar = $jawaban->jawaban == 'Benar' ? 1 : 0;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban_benar_salah" id="jawaban_benar_1" value="1" {{ $jawabanBenar === 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="jawaban_benar_1">Benar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban_benar_salah" id="jawaban_benar_0" value="0" {{ $jawabanBenar === 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="jawaban_benar_0">Salah</label>
                            </div>
                        </div>
                        
                        <!-- Isian Options -->
                        <div id="isian_options" style="display: {{ $pertanyaan->tipe == 'isian' ? 'block' : 'none' }}">
                            <h5 class="mt-4 mb-3">Kunci Jawaban</h5>
                            <div class="form-group">
                                @php
                                    $jawabanIsian = '';
                                    if($pertanyaan->tipe == 'isian' && $pertanyaan->jawaban->count() > 0) {
                                        $jawabanIsian = $pertanyaan->jawaban[0]->jawaban;
                                    }
                                @endphp
                                <input type="text" class="form-control" name="jawaban_isian" value="{{ $jawabanIsian }}" placeholder="Kunci jawaban (case sensitive)">
                                <small class="text-muted">Jawaban harus persis sama dengan kunci jawaban (termasuk huruf besar/kecil)</small>
                            </div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="button" id="btnSubmitPertanyaan" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ url('/admin/kuis/pertanyaan/' . $pertanyaan->kuis_id) }}" class="btn btn-secondary">Batal</a>
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
        // Inisialisasi TinyMCE untuk pertanyaan
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#pertanyaan',
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
        
        // Tampilkan opsi sesuai tipe soal
        $('#tipe').change(function() {
            const tipe = $(this).val();
            $('#pilihan_ganda_options, #benar_salah_options, #isian_options').hide();
            
            if (tipe === 'pilihan_ganda') {
                $('#pilihan_ganda_options').show();
                // Jika belum ada pilihan, tambahkan satu
                if ($('.pilihan-item').length === 0) {
                    $('#tambah_pilihan').click();
                }
            } else if (tipe === 'benar_salah') {
                $('#benar_salah_options').show();
            } else if (tipe === 'isian') {
                $('#isian_options').show();
            }
        });
        
        // Tambah pilihan jawaban
        let pilihanCount = $('.pilihan-item').length || 0;
        $('#tambah_pilihan').click(function() {
            pilihanCount++;
            const newPilihan = `
                <div class="form-group row pilihan-item">
                    <div class="col-md-1">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="jawaban_benar" value="${pilihanCount - 1}">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan jawaban">
                        <input type="hidden" name="jawaban_id[]" value="0">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger hapus-pilihan">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            $('.pilihan-container').append(newPilihan);
        });
        
        // Hapus pilihan jawaban
        $(document).on('click', '.hapus-pilihan', function() {
            $(this).closest('.pilihan-item').remove();
        });
        
        // Form validation dan submit
        $('#btnSubmitPertanyaan').click(function() {
            // Sync TinyMCE content before validation
            tinymce.triggerSave();
            
            const tipe = $('#tipe').val();
            const pertanyaan = tinymce.get('pertanyaan').getContent().trim();
            
            if (!tipe) {
                alert('Pilih tipe soal terlebih dahulu');
                $('#tipe').focus();
                return false;
            }
            
            if (!pertanyaan || pertanyaan === '<p></p>' || pertanyaan === '') {
                alert('Pertanyaan wajib diisi');
                tinymce.get('pertanyaan').focus();
                return false;
            }
            
            // Validasi sesuai tipe soal
            if (tipe === 'pilihan_ganda') {
                const pilihan = $('input[name="pilihan[]"]').map(function() {
                    return $(this).val().trim();
                }).get();
                
                if (pilihan.length < 2) {
                    alert('Minimal harus ada 2 pilihan jawaban');
                    return false;
                }
                
                if (pilihan.some(p => p === '')) {
                    alert('Semua pilihan jawaban harus diisi');
                    return false;
                }
                
                if (!$('input[name="jawaban_benar"]:checked').length) {
                    alert('Pilih jawaban yang benar');
                    return false;
                }
            } else if (tipe === 'isian') {
                const jawaban = $('input[name="jawaban_isian"]').val().trim();
                if (!jawaban) {
                    alert('Kunci jawaban wajib diisi');
                    $('input[name="jawaban_isian"]').focus();
                    return false;
                }
            }
            
            confirmModal('Apakah Anda yakin ingin menyimpan perubahan soal ini?', function() {
                const formData = new FormData($('#pertanyaanForm')[0]);
                ajxProcess("{{ url('/admin/kuis/pertanyaan/update/' . $pertanyaan->id) }}", formData, "#message-modal");
            });
        });
    });
</script>
@endsection