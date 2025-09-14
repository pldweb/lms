@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $kuis->judul }}</h4>
                    @if($sisaWaktu)
                        <div class="timer-container">
                            <span class="badge badge-warning">Sisa Waktu: <span id="timer">00:00:00</span></span>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Petunjuk:</strong>
                        <ul>
                            <li>Kerjakan soal dengan teliti</li>
                            <li>Jawaban akan otomatis tersimpan setelah Anda memilih atau mengisi jawaban</li>
                            <li>Klik tombol "Selesaikan Kuis" jika sudah selesai mengerjakan semua soal</li>
                            @if($tugas->durasi_menit > 0)
                                <li>Kuis akan otomatis selesai jika waktu habis</li>
                            @endif
                        </ul>
                    </div>

                    <form id="form-selesai" action="{{ url('/siswa/kuis/selesaikan/' . $hasil->id) }}" method="POST">
                        @csrf
                    </form>

                    <div class="row mb-4">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-danger" onclick="konfirmasiSelesai()">Selesaikan Kuis</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Navigasi Soal</h5>
                                </div>
                                <div class="card-body">
                                    <div class="soal-nav d-flex flex-wrap">
                                        @foreach($pertanyaan as $index => $item)
                                            @php
                                                $sudahDijawab = isset($jawabanSiswa[$item->id]);
                                                $btnClass = $sudahDijawab ? 'btn-success' : 'btn-outline-secondary';
                                            @endphp
                                            <a href="#soal-{{ $item->id }}" class="btn {{ $btnClass }} m-1 btn-soal" data-id="{{ $item->id }}">
                                                {{ $index + 1 }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            @foreach($pertanyaan as $index => $item)
                                <div id="soal-{{ $item->id }}" class="card mb-4 soal-container" data-id="{{ $item->id }}">
                                    <div class="card-header">
                                        <h5>Soal {{ $index + 1 }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="pertanyaan mb-3">
                                            {!! $item->pertanyaan !!}
                                        </div>
                                        
                                        @if($item->gambar)
                                            <div class="gambar-soal mb-3">
                                                <img src="{{ asset('storage/kuis/' . $item->gambar) }}" alt="Gambar Soal" class="img-fluid" style="max-height: 300px;">
                                            </div>
                                        @endif

                                        <div class="jawaban-container">
                                            <form id="form-jawaban-{{ $item->id }}" class="form-jawaban" data-pertanyaan-id="{{ $item->id }}">
                                                @csrf
                                                <input type="hidden" name="pertanyaan_id" value="{{ $item->id }}">
                                                
                                                @if($item->tipe == 'pilihan_ganda' || $item->tipe == 'benar_salah')
                                                    @foreach($item->jawaban as $jawaban)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="jawaban_id" 
                                                                id="jawaban-{{ $jawaban->id }}" value="{{ $jawaban->id }}"
                                                                {{ isset($jawabanSiswa[$item->id]) && $jawabanSiswa[$item->id] == $jawaban->id ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="jawaban-{{ $jawaban->id }}">
                                                                {!! $jawaban->jawaban !!}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @elseif($item->tipe == 'isian')
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="jawaban_teks" 
                                                            placeholder="Ketik jawaban Anda di sini"
                                                            value="{{ \App\Models\JawabanSiswaKuis::where('siswa_id', Auth::id())->where('pertanyaan_id', $item->id)->value('jawaban_teks') }}">
                                                    </div>
                                                @elseif($item->tipe == 'esai')
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="jawaban_teks" rows="5" 
                                                            placeholder="Ketik jawaban Anda di sini">{{ \App\Models\JawabanSiswaKuis::where('siswa_id', Auth::id())->where('pertanyaan_id', $item->id)->value('jawaban_teks') }}</textarea>
                                                    </div>
                                                @endif
                                                
                                                <div class="jawaban-status mt-2" id="status-{{ $item->id }}">
                                                    @if(isset($jawabanSiswa[$item->id]))
                                                        <small class="text-success"><i class="fas fa-check-circle"></i> Jawaban tersimpan</small>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fungsi untuk menyimpan jawaban
        function simpanJawaban(formId) {
            const form = $(formId);
            const pertanyaanId = form.data('pertanyaan-id');
            const statusElement = $(`#status-${pertanyaanId}`);
            const btnSoal = $(`.btn-soal[data-id="${pertanyaanId}"]`);
            
            $.ajax({
                url: '{{ url("/siswa/kuis/jawab/" . $hasil->id) }}',
                type: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    statusElement.html('<small class="text-info"><i class="fas fa-spinner fa-spin"></i> Menyimpan...</small>');
                },
                success: function(response) {
                    if (response.success) {
                        statusElement.html('<small class="text-success"><i class="fas fa-check-circle"></i> Jawaban tersimpan</small>');
                        btnSoal.removeClass('btn-outline-secondary').addClass('btn-success');
                    } else {
                        statusElement.html('<small class="text-danger"><i class="fas fa-times-circle"></i> Gagal menyimpan</small>');
                    }
                },
                error: function() {
                    statusElement.html('<small class="text-danger"><i class="fas fa-times-circle"></i> Gagal menyimpan</small>');
                }
            });
        }
        
        // Event handler untuk radio button (pilihan ganda dan benar/salah)
        $(document).on('change', 'input[type="radio"]', function() {
            const formId = `#${$(this).closest('form').attr('id')}`;
            simpanJawaban(formId);
        });
        
        // Event handler untuk input text dan textarea (isian dan esai)
        let typingTimer;
        $(document).on('keyup', 'input[type="text"], textarea', function() {
            const formId = `#${$(this).closest('form').attr('id')}`;
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                simpanJawaban(formId);
            }, 1000);
        });
        
        // Navigasi soal
        $('.btn-soal').on('click', function(e) {
            e.preventDefault();
            const target = $($(this).attr('href'));
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        });
        
        // Timer untuk durasi kuis
        @if($sisaWaktu)
            let sisaDetik = {{ $sisaWaktu }};
            const timerElement = $('#timer');
            
            function updateTimer() {
                const jam = Math.floor(sisaDetik / 3600);
                const menit = Math.floor((sisaDetik % 3600) / 60);
                const detik = sisaDetik % 60;
                
                timerElement.text(
                    `${jam.toString().padStart(2, '0')}:${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`
                );
                
                if (sisaDetik <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu habis! Kuis akan diselesaikan otomatis.');
                    $('#form-selesai').submit();
                }
                
                sisaDetik--;
            }
            
            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        @endif
    });
    
    // Konfirmasi selesai kuis
    function konfirmasiSelesai() {
        if (confirm('Apakah Anda yakin ingin menyelesaikan kuis ini? Anda tidak dapat mengubah jawaban setelah kuis diselesaikan.')) {
            $('#form-selesai').submit();
        }
    }
</script>
@endsection