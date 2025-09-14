@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Kelola Soal Kuis: {{ $kuis->judul }}</h4>
                    <div>
                        <a href="{{ url('/admin/kuis/show/' . $kuis->id) }}" class="btn btn-info">Detail Kuis</a>
                        <a href="{{ url('/admin/kuis') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="message-modal"></div>

                    <div class="mb-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahPertanyaanModal">
                            <i class="fas fa-plus"></i> Tambah Soal Baru
                        </button>
                    </div>

                    @if($pertanyaan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Tipe</th>
                                        <th>Pertanyaan</th>
                                        <th width="15%">Jumlah Jawaban</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pertanyaan as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $item->urutan }}</td>
                                            <td>
                                                @if($item->tipe == 'pilihan_ganda')
                                                    <span class="badge badge-primary">Pilihan Ganda</span>
                                                @elseif($item->tipe == 'benar_salah')
                                                    <span class="badge badge-success">Benar/Salah</span>
                                                @elseif($item->tipe == 'isian')
                                                    <span class="badge badge-info">Isian</span>
                                                @endif
                                            </td>
                                            <td>
                                                {!! strip_tags($item->pertanyaan, '<b><i><u><strong><em>') !!}
                                                @if($item->gambar)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Soal" class="img-thumbnail" style="max-height: 100px;">
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($item->tipe == 'pilihan_ganda' || $item->tipe == 'benar_salah')
                                                    {{ $item->jawaban->count() }}
                                                @else
                                                    <span class="badge badge-secondary">Isian</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/kuis/pertanyaan/edit/' . $item->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus soal ini?')) { window.location.href='{{ url('/admin/kuis/pertanyaan/delete/' . $item->id) }}'; }">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada soal untuk kuis ini. Silakan tambahkan soal baru.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pertanyaan -->
<div class="modal fade" id="tambahPertanyaanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPertanyaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="pertanyaanForm" onsubmit="return false;" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPertanyaanModalLabel">Tambah Soal Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipe">Tipe Soal <span class="text-danger">*</span></label>
                        <select class="form-control" id="tipe" name="tipe" required>
                            <option value="">Pilih Tipe Soal</option>
                            <option value="pilihan_ganda">Pilihan Ganda</option>
                            <option value="benar_salah">Benar/Salah</option>
                            <option value="isian">Isian</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pertanyaan">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="gambar">Gambar (Opsional)</label>
                        <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                    </div>
                    
                    <div id="pilihan_ganda_options" style="display: none;">
                        <h5 class="mt-4 mb-3">Pilihan Jawaban</h5>
                        <div class="pilihan-container">
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
                        </div>
                        <button type="button" class="btn btn-sm btn-success mt-2" id="tambah_pilihan">
                            <i class="fas fa-plus"></i> Tambah Pilihan
                        </button>
                    </div>
                    
                    <div id="benar_salah_options" style="display: none;">
                        <h5 class="mt-4 mb-3">Jawaban Benar</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban_benar_salah" id="jawaban_benar_1" value="1" checked>
                            <label class="form-check-label" for="jawaban_benar_1">Benar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban_benar_salah" id="jawaban_benar_0" value="0">
                            <label class="form-check-label" for="jawaban_benar_0">Salah</label>
                        </div>
                    </div>
                    
                    <div id="isian_options" style="display: none;">
                        <h5 class="mt-4 mb-3">Kunci Jawaban</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" name="jawaban_isian" placeholder="Kunci jawaban (case sensitive)">
                            <small class="text-muted">Jawaban harus persis sama dengan kunci jawaban (termasuk huruf besar/kecil)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSubmitPertanyaan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
            } else if (tipe === 'benar_salah') {
                $('#benar_salah_options').show();
            } else if (tipe === 'isian') {
                $('#isian_options').show();
            }
        });
        
        // Tambah pilihan jawaban
        let pilihanCount = 1;
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
            
            confirmModal('Apakah Anda yakin ingin menyimpan soal ini?', function() {
                const formData = new FormData($('#pertanyaanForm')[0]);
                ajxProcess("{{ url('/admin/kuis/pertanyaan/tambah/' . $kuis->id) }}", formData, "#message-modal");
                $('#tambahPertanyaanModal').modal('hide');
            });
        });
    });
</script>
@endsection